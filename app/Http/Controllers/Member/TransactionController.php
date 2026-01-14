<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Riwayat peminjaman member
     */
    public function index()
    {
        $transactions = Transaction::with('book')
            ->where('user_id', auth()->id())
            ->orderByDesc('borrow_date')
            ->get();

        return view('member.transactions.index', compact('transactions'));
    }

    /**
     * Pinjam / reservasi buku
     */
    public function store(Book $book)
    {
        // Cek stok buku
        if ($book->stock <= 0) {
            return back()->with('error', 'Stok buku habis');
        }

        // Cek apakah user sudah punya transaksi aktif (reservasi/dipinjam) untuk buku ini
        $exists = Transaction::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->whereIn('status', ['reservasi', 'dipinjam'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Buku ini sudah dipinjam atau direservasi');
        }

        // Buat transaksi baru
        $transaction = Transaction::create([
            'user_id'          => auth()->id(),
            'book_id'          => $book->id,
            'status'           => 'reservasi',
            'reservation_date' => Carbon::today(),
        ]);

        // Kurangi stok buku
        $book->decrement('stock');

        return back()->with('success', 'Buku berhasil direservasi');
    }
}
