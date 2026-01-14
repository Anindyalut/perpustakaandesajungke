<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['book', 'user']);

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [
                $request->from . ' 00:00:00',
                $request->to . ' 23:59:59'
            ]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->get();

        return view('admin.reports.index', [
            'transactions'      => $transactions,
            'totalTransactions' => $transactions->count(),
            'totalFine'         => $transactions->sum('fine'),
            'totalBorrowed'     => $transactions->where('status','dipinjam')->count(),
        ]);
    }

    public function exportPdf(Request $request)
    {
        $query = Transaction::with(['book', 'user']);

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [
                $request->from . ' 00:00:00',
                $request->to . ' 23:59:59'
            ]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->get();

        $pdf = Pdf::loadView('admin.reports.pdf', [
            'transactions' => $transactions,
            'from' => $request->from,
            'to'   => $request->to,
            'status' => $request->status,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan-transaksi.pdf');
    }
}
