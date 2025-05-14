<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->is_admin) {
                return redirect('/')->with('error', 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $books = Book::paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all(); // Fetch all categories
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        Log::info('Store method called');
        try {
            // Validate the request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'e_book' => 'required|boolean',
                'description' => 'required|string',
                'category_id' => 'nullable|exists:categories,id',
                'new_category' => 'nullable|string|max:255',
                'image' => 'nullable|image|max:2048',
            ]);

            Log::info('Validation passed:', $validated);

            // Ensure either category_id or new_category is provided
            if (!$request->filled('category_id') && !$request->filled('new_category')) {
                return redirect()->back()->withErrors(['category_id' => 'Please select an existing category or provide a new category.'])->withInput();
            }

            // Handle new category creation
            if ($request->filled('new_category')) {
                Log::info('Creating new category:', ['name' => $request->new_category]);
                $newCategory = \App\Models\Category::create([
                    'name' => $request->new_category,
                    'description' => 'Created from book form',
                ]);
                $validated['category_id'] = $newCategory->id; // Assign the new category ID
                Log::info('New Category Created:', $newCategory->toArray());
            }

            // Create the book
            $book = new Book($validated);
            Log::info('Book Instance Before Save:', $book->toArray());

            // Handle image upload
            if ($request->hasFile('image')) {
                $book->image = $request->file('image')->store('books', 'public');
                Log::info('Image Uploaded:', ['path' => $book->image]);
            }

            $book->save();
            Log::info('Book Saved:', $book->toArray());

            return redirect()->route('admin.books.index')->with('success', 'Book created successfully.');
        } catch (\Exception $e) {
            Log::error('Error in store method:', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An error occurred while saving the book.');
        }
    }

    public function edit(Book $book)
    {
        $categories = \App\Models\Category::all(); // Fetch categories if needed
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'e_book' => 'required|boolean',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'new_category' => 'nullable|string|max:255',
        ]);

        // Check if a new category is provided
        if ($request->filled('new_category')) {
            $newCategory = \App\Models\Category::create([
                'name' => $request->new_category,
                'description' => 'Created from book edit form',
            ]);
            $validated['category_id'] = $newCategory->id;
        }

        $book->fill($validated);

        if ($request->hasFile('image')) {
            $book->image = $request->file('image')->store('books', 'public');
        }

        $book->save();

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully.');
    }
}
