<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    /**
     * Display a listing of books.
     */
    public function index(Request $request): View
    {
        $viewData = [];
        $viewData["title"] = "Books - Online Store";
        $viewData["subtitle"] = "List of books";

        // Get the query builder
        $query = Book::query();

        // Search functionality
        if ($request->has('search') && $request->get('search') !== '') {
            $search = $request->get('search');
            \Log::info('Search initiated with term: ' . $search);

            // Make the search case-insensitive and more lenient
            $searchTerm = strtolower($search);

            // Log the search term being used
            \Log::info('Search term after processing: ' . $searchTerm);

            // Build the search query using Laravel's where clause
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('author', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });

            // Log the final query and bindings
            \Log::info('Final query: ' . $query->toSql());
            \Log::info('Query bindings: ' . json_encode($query->getBindings()));
        }

        // Apply category filter if provided and not empty
        if ($request->has('category') && $request->get('category') !== '' && $request->get('category') !== null) {
            $query->where('category_id', $request->get('category'));
        }

        // Apply price range filter if provided and not empty
        if ($request->has('price') && $request->get('price') !== '' && $request->get('price') !== null) {
            $priceRange = $request->get('price');
            switch ($priceRange) {
                case '0-5000':
                    $query->whereBetween('price', [0, 5000]);
                    break;
                case '5000-10000':
                    $query->whereBetween('price', [5000, 10000]);
                    break;
                case '10000-20000':
                    $query->whereBetween('price', [10000, 20000]);
                    break;
            }
        }

        // Stock filter
        if ($request->has('stock') && $request->get('stock') !== '' && $request->get('stock') !== null) {
            if ($request->stock === 'in-stock') {
                $query->where('stock', '>', 0);
            } elseif ($request->stock === 'out-of-stock') {
                $query->where('stock', 0);
            }
        }

        // Get the results with pagination
        $viewData["books"] = $query->paginate(5);
        $viewData["categories"] = Category::all();
        $viewData["searchTerm"] = $request->get('search', '');

        // Log final results
        \Log::info('Number of books found: ' . $viewData["books"]->count());
        \Log::info('Current page: ' . $viewData["books"]->currentPage());
        \Log::info('Total pages: ' . $viewData["books"]->lastPage());
        \Log::info('Raw books data: ' . json_encode($viewData["books"]->items()));

        return view('product.index')->with("viewData", $viewData);
    }

    /**
     * Display the specified book.
     */
    public function show($id): View
    {
        $book = Book::with('category')->findOrFail($id);
        return view('product.show', ['viewData' => ['book' => $book]]);
    }
}
