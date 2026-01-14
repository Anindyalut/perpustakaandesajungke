<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Services\FpGrowthService;


class HomeController extends Controller
{

    public function index(FpGrowthService $fpGrowth)
{
    $books = Book::where('stock', '>', 0)->get();

    $recommendations = $fpGrowth->getRecommendationsForMember(
        auth()->id(),
        60 // minimal confidence
    );

    return view('member.home', compact(
        'books',
        'recommendations'
    ));
}
}
