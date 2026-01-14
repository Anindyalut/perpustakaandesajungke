<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Menampilkan semua transaksi ke halaman admin
     */
    public function index()
    {
        $transactions = Transaction::with(['user', 'book'])
            ->latest()
            ->get();

        // Total denda keseluruhan
        $totalFine = $transactions->sum('fine');

        return view('admin.transactions.index', compact('transactions', 'totalFine'));
    }

    /**
     * Ubah status menjadi "Dipinjam"
     */
    public function setBorrowed(Transaction $transaction)
    {
        if ($transaction->status !== 'reservasi') {
            return back()->with('error', 'Status tidak valid');
        }

        $borrowDate = Carbon::today();

        $transaction->update([
            'status'          => 'dipinjam',
            'borrow_date'     => $borrowDate,
            'max_return_date' => $borrowDate->copy()->addDays(2),
        ]);

        // Kurangi stok buku
        $transaction->book->decrement('stock');

        return back()->with('success', 'Status diubah menjadi Dipinjam');
    }

    /**
     * Ubah status menjadi "Selesai" dan hitung denda otomatis
     */
    public function setReturned(Transaction $transaction)
    {
        if ($transaction->status !== 'dipinjam') {
            return back()->with('error', 'Status tidak valid');
        }

        $returnDate = Carbon::today();
        $dueDate = Carbon::parse($transaction->max_return_date);

        // Hitung keterlambatan
        $lateDays = $returnDate->greaterThan($dueDate)
            ? $dueDate->diffInDays($returnDate)
            : 0;

        // Denda Rp1.000 per hari
        $fine = $lateDays * 1000;

        $transaction->update([
            'status'      => 'selesai',
            'return_date' => $returnDate,
            'fine'        => $fine,
        ]);

        // Tambah stok buku
        $transaction->book->increment('stock');

        return back()->with(
            'success',
            $fine > 0
                ? "Transaksi selesai. Denda keterlambatan: Rp " . number_format($fine, 0, ',', '.')
                : 'Transaksi selesai tanpa denda'
        );
    }
}
