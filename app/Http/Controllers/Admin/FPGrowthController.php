<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FpGrowthService;
use App\Models\FpGrowthSetting;
use App\Models\Transaction;

class FpGrowthController extends Controller
{
        public function index(FpGrowthService $fpGrowth)
{
    $setting = FpGrowthSetting::first();
    $minSupport = $setting->min_support ?? 30;

    // FP-Growth rules (TETAP)
    $rules = $fpGrowth->generateWithConfidence($minSupport);

    // TOP BUKU POPULER
    $topBooks = Transaction::where('status', 'selesai')
        ->join('books', 'transactions.book_id', '=', 'books.id')
        ->selectRaw('books.title, COUNT(*) as total')
        ->groupBy('books.title')
        ->orderByDesc('total')
        ->limit(5)
        ->get();

    return view('admin.fpgrowth.index', compact(
        'rules',
        'minSupport',
        'topBooks'
    ));
}

    public function parameter()
    {
        $setting = FpGrowthSetting::first();

        if (!$setting) {
            $setting = FpGrowthSetting::create([
                'min_support' => 20
            ]);
        }

        return view('admin.fpgrowth.parameter', compact('setting'));
    }


    public function saveParameter(Request $request)
    {
        $request->validate([
            'min_support' => 'required|integer|min:1|max:100'
        ]);

        $setting = FpGrowthSetting::first();
        $setting->update([
            'min_support' => $request->min_support
        ]);

        return back()->with('success', 'Minimum support berhasil diperbarui');
    }

}
