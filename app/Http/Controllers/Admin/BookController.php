<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $books = Book::when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('publisher', 'like', "%{$search}%");
            })
            ->orderBy('title', 'asc')   // A-Z
            ->paginate(10)              // 10 data per halaman
            ->withQueryString();        // agar search tidak hilang saat pindah halaman

        return view('admin.books.index', compact('books', 'search'));
    }


    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title'     => 'required',
        'author'    => 'required',
        'publisher' => 'required',
        'year'      => 'required|numeric',
        'isbn'      => 'required',
        'ukuran'          => 'nullable|string|max:50',
        'jumlah_halaman'  => 'nullable|integer|min:1',
        'color'     => 'required',
        'stock'     => 'required|numeric',
        'price'     => 'required|numeric',
        'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = $request->except('image');

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')
                                ->store('covers', 'public');
    }

    Book::create($data);

    return redirect()
        ->route('admin.books.index')
        ->with('success', 'Buku berhasil ditambahkan');
}


    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }
    

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title'     => 'required',
            'author'    => 'required',
            'publisher' => 'required',
            'year'      => 'required|numeric',
            'isbn'      => 'required',
            'ukuran'          => 'nullable|string|max:50',
            'jumlah_halaman'  => 'nullable|integer|min:1',
            'color'     => 'required',
            'stock'     => 'required|numeric|min:0',
            'price'     => 'required|numeric|min:0',
            'image'     => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');

        // kalau upload gambar baru
        if ($request->hasFile('image')) {
            if ($book->image && file_exists(storage_path('app/public/'.$book->image))) {
                unlink(storage_path('app/public/'.$book->image));
            }

            $data['image'] = $request->file('image')->store('covers', 'public');
        }

        $book->update($data);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Data buku berhasil diperbarui');
    }


    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus');
    }

    public function exportPdf()
    {
        $books = Book::orderBy('title','asc')->get();

        $totalAsset = $books->sum(fn($b) => $b->stock * $b->price);

        $pdf = Pdf::loadView('admin.books.pdf', compact('books','totalAsset'))
                ->setPaper('A4', 'portrait');

        return $pdf->download('laporan-buku.pdf');
    }
}
