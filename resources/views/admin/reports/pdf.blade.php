<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #333;
            padding: 6px;
        }

        table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .total {
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>LAPORAN TRANSAKSI PERPUSTAKAAN</h2>

<div class="info">
    @if($from && $to)
        Periode: {{ $from }} s/d {{ $to }} <br>
    @endif

    @if($status)
        Status: {{ ucfirst($status) }}
    @else
        Status: Semua
    @endif
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Member</th>
            <th>Buku</th>
            <th>Status</th>
            <th>Denda</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $i => $t)
        <tr>
            <td class="text-center">{{ $i + 1 }}</td>
            <td>{{ $t->user->name }}</td>
            <td>{{ $t->book->title }}</td>
            <td class="text-center">{{ ucfirst($t->status) }}</td>
            <td class="text-center">
                Rp {{ number_format($t->fine,0,',','.') }}
            </td>
            <td class="text-center">
                {{ $t->created_at->format('d M Y') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<p class="total">
    Total Transaksi: {{ $transactions->count() }} <br>
    Total Denda: Rp {{ number_format($transactions->sum('fine'),0,',','.') }}
</p>

</body>
</html>
