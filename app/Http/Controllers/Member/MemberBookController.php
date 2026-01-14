<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;

class MemberBookController extends Controller
{
    public function show(Book $book)
    {
        return view('member.books.show', compact('book'));
    }
}
