<?php
// app/Http/Controllers/AIRecommenderController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class AIRecommenderController extends Controller
{
    public function recommend(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $userPrompt = $request->input('message');

        // Log the user input
        Log::info('User Prompt Received:', ['message' => $userPrompt]);

        // Step 1: Ask Cohere to extract keywords
        try {
            $cohereResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('COHERE_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.cohere.ai/v1/chat', [
                'chat_history' => [],
                'message' => "The user is looking for a book. Here is their message: \"$userPrompt\". Extract keywords related to the book's category, title, or description. Respond ONLY in JSON like { \"keywords\": [\"keyword1\", \"keyword2\"] }.",
                'model' => 'command-r-plus',
                'temperature' => 0.3,
            ]);

            // Log the raw response from Cohere
            Log::info('Cohere API Response:', ['response' => $cohereResponse->json()]);
        } catch (\Exception $e) {
            Log::error('Error Communicating with Cohere API:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to communicate with Cohere API.'], 500);
        }

        // Parse the JSON response
        $cohereData = $cohereResponse->json();

        if (!isset($cohereData['text'])) {
            Log::error('Invalid Cohere API Response Format:', ['response' => $cohereData]);
            return response()->json(['error' => 'Invalid response from Cohere API.'], 500);
        }

        $json = json_decode($cohereData['text'], true);

        if (json_last_error() === JSON_ERROR_NONE && isset($json['keywords'])) {
            Log::info('Parsed Cohere AI Response:', ['parsed_json' => $json]);
            $keywords = $json['keywords'];
        } else {
            Log::error('Error Parsing Cohere Response:', ['error' => json_last_error_msg()]);
            return response()->json(['error' => 'Invalid JSON format in Cohere API response.'], 500);
        }

        // Step 2: Search your database
        $query = Book::query()
            ->join('categories', 'books.category_id', '=', 'categories.id')
            // Select only required fields
            ->select('books.id', 'books.title', 'books.author','books.image')
            ->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('categories.name', 'like', '%' . $keyword . '%')
                      ->orWhere('categories.description', 'like', '%' . $keyword . '%')
                      ->orWhere('books.title', 'like', '%' . $keyword . '%')
                      ->orWhere('books.description', 'like', '%' . $keyword . '%')
                      ->whereRaw("MATCH(categories.name, categories.description) AGAINST(? IN NATURAL LANGUAGE MODE)", [$keyword])
                      ->orWhereRaw("MATCH(books.title, books.description) AGAINST(? IN NATURAL LANGUAGE MODE)", [$keyword]);
                }
            });

        // Log the database query
        Log::info('Database Query:', [
            'query' => $query->toSql(),
            'bindings' => $query->getBindings(),
        ]);

        // Execute the query and fetch results directly without cache
        $books = $query->get();

        // Log the query results
        Log::info('Query Results:', ['books' => $books]);
        Log::info('Number of books found:', ['count' => $books->count()]);

        return response()->json([
            'books' => $books,
            'keywords' => $keywords,
        ]);
    }
}
