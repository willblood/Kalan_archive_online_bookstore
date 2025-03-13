<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function index(){
        $viewData=[];
        $viewData["title"] = "Shop Books";
        $viewData["books"] = Book::paginate(5);
        return view("product.index",)
        ->with("viewData",$viewData);
    }

    public function show($id){
        $viewData=[];
        $book=Book::findOrFail( $id );
        $viewData["book"] = $book;
        $viewData["title"] = $book->title;
        return view("product.show")
        ->with("viewData",$viewData);
    }
}
