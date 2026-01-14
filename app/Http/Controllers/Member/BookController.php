<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;

class BookController extends Controller
{
    public function show(Book $book)
    {
        return view('member.books.show', compact('book'));
    }
}
