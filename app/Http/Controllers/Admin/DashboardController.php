<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        // Total buku (jumlah judul)
        $totalBuku = Book::count();

        // Total stok buku (jumlah fisik)
        $totalStokBuku = Book::sum('stock');

        // Buku sedang dipinjam
        $dipinjam = Transaction::where('status', 'dipinjam')->count();

        // Buku reservasi
        $reservasi = Transaction::where('status', 'reservasi')->count();

        // Total member
        $totalMember = User::where('role', 'member')->count();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalStokBuku',
            'dipinjam',
            'reservasi',
            'totalMember'
        ));
    }
}
