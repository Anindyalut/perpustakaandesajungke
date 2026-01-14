<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Buku</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 4px;
        }

        .subtitle {
            text-align: center;
            font-size: 11px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: middle;
        }

        th {
            background-color: #e0f2f1; /* ijo perpus */
            text-align: center;
            font-weight: bold;
        }

        td {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .total-row {
            background-color: #c8e6c9;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 9px;
        }
    </style>
</head>
<body>

    <h2>LAPORAN DATA BUKU PERPUSTAKAAN</h2>
    <div class="subtitle">
        Dicetak pada {{ now()->format('d M Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>ISBN</th>
                <th>Ukuran</th>
                <th>Hal</th>
                <th>Warna</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Total Harga</th>
            </tr>
        </thead>

        @php
            $grandTotal = 0;
        @endphp

        <tbody>
            @forelse($books as $i => $book)
                @php
                    $totalHarga = $book->stock * $book->price;
                    $grandTotal += $totalHarga;
                @endphp

                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="text-left">{{ $book->title }}</td>
                    <td class="text-left">{{ $book->author }}</td>
                    <td class="text-left">{{ $book->publisher }}</td>
                    <td>{{ $book->year }}</td>
                    <td>{{ $book->isbn }}</td>
                    <td>{{ $book->ukuran ?? '-' }}</td>
                    <td>{{ $book->jumlah_halaman ?? '-' }}</td>
                    <td>{{ strtoupper($book->color ?? '-') }}</td>
                    <td>{{ $book->stock }}</td>
                    <td>
                        Rp {{ number_format($book->price, 0, ',', '.') }}
                    </td>
                    <td>
                        Rp {{ number_format($totalHarga, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12">Tidak ada data buku</td>
                </tr>
            @endforelse

            {{-- TOTAL KESELURUHAN --}}
            <tr class="total-row">
                <td colspan="11" style="text-align:right;">
                    TOTAL KESELURUHAN
                </td>
                <td>
                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Sistem Perpustakaan • {{ config('app.name') }}
    </div>

</body>
</html>
