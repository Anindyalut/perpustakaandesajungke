<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // ⬅️ WAJIB
use App\Models\Book;
use App\Services\FpGrowthService;

class HomeController extends Controller
{
    public function index(Request $request, FpGrowthService $fpGrowth)
{
    $query = Book::where('stock', '>', 0);

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('author', 'like', "%{$search}%")
              ->orWhere('publisher', 'like', "%{$search}%");
        });
    }

    $books = $query->get();

    // 🔥 ambil hasil FP-Growth
    $rules = $fpGrowth->getGlobalRecommendations(30, 60, 5);

    // 🔄 konversi ke Book model
    $recommendations = Book::whereIn(
        'title',
        collect($rules)->pluck('to')
    )->get();

    return view('member.home', compact(
        'books',
        'recommendations'
    ));
}

}
