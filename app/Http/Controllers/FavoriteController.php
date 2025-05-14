<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('book')->latest()->get();
        return view('favorites.index', compact('favorites'));
    }

    public function store(Book $book)
    {
        $user = Auth::user();

        // Check if the book is already favorited
        $existing = Favorite::where('user_id', $user->id)
                          ->where('book_id', $book->id)
                          ->first();

        if ($existing) {
            // If exists, remove it
            $existing->delete();
            $message = 'Book removed from favorites';
        } else {
            // If doesn't exist, add it
            $user->favorites()->create(['book_id' => $book->id]);
            $message = 'Book successfully added to your favorite books!';
        }

        return back()->with('success', $message);
    }

    public function remove(Favorite $favorite)
    {
        // Only allow users to remove their own favorites
        if ($favorite->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $favorite->delete();
        return back()->with('success', 'Book removed from favorites.');
    }
}
