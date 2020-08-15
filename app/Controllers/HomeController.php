<?php


namespace App\Controllers;


use App\Models\Book;

class HomeController
{
    public function index()
    {
        $books = (new Book())->list();

        return view('index', ['books' => $books]);
    }
}