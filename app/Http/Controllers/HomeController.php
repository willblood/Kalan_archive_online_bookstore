<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $viewData=[];

        $books = Book::all();
        $viewData['title']="Home";
        $viewData["books"]= $books;
        return view("welcome")
        ->with("viewData", $viewData);
    }
}
