<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Home Page - Kalan Archive';
        $viewData['books_swiper'] = Book::paginate(11);
        $viewData['featured'] = Book::paginate(9);
        $viewData['trending'] = Book::orderBy('created_at', 'desc')->take(4)->get();
        return view('welcome')->with('viewData', $viewData);
    }
}
