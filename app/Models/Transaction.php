<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'reservation_date',
        'borrow_date',
        'max_return_date',
        'return_date',
        'fine',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'borrow_date'      => 'date',
        'max_return_date'  => 'date',
        'return_date'      => 'date',
    ];

    // RELATION
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ACCESSOR: max kembalinya (due date)
    public function getDueDateAttribute()
    {
        if ($this->max_return_date) {
            return $this->max_return_date;
        }

        return $this->borrow_date ? $this->borrow_date->copy()->addDays(3) : null;
    }

    // ACCESSOR: denda real-time
    public function getLateFeeAttribute()
    {
        $feePerDay = 1000;

        if (!$this->borrow_date || $this->status === 'reservasi') {
            return 0;
        }

        // Hitung terhadap return_date kalau sudah dikembalikan, kalau belum pakai now()
        $compareDate = $this->return_date ?? now();

        if ($compareDate->lte($this->due_date)) {
            return 0;
        }

        $lateDays = $compareDate->diffInDays($this->due_date);

        return $lateDays * $feePerDay;
    }
}
