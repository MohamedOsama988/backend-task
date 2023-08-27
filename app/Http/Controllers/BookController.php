<?php

namespace App\Http\Controllers;
use App\Console\Commands\WebScraping;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //
    public function index()
    {
        //return view('books.index');
        $books = Book::simplePaginate(20);
        return view('books.index', compact('books'));
    }

    public function indexOverride($n)
    {
        //return view('books.index');
        $books = Book::simplePaginate(20+$n);
        $scraping = new WebScraping();
        $scraping->max = 2;
        $scraping->handle();
        return ($books->slice(-8));
    }
}
