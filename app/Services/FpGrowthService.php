<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Book;

class FpGrowthService
{
    /**
     * Generate association rules berdasarkan support & confidence
     * minSupportPercent dalam bentuk persen (misal 30)
     */
    public function generateWithConfidence(int $minSupportPercent = 30): array
    {
        // 1️⃣ Ambil transaksi selesai
        $transactions = Transaction::where('status', 'selesai')
            ->whereNotNull('borrow_date')
            ->get();

        if ($transactions->isEmpty()) {
            return [];
        }

        // 2️⃣ Kelompokkan transaksi (user + tanggal)
        $grouped = $transactions->groupBy(fn ($t) =>
            $t->user_id . '-' . $t->borrow_date
        );

        // 3️⃣ Bentuk basket transaksi
        $baskets = [];
        foreach ($grouped as $items) {
            $books = $items->pluck('book_id')->unique()->values()->toArray();
            if (count($books) >= 2) {
                $baskets[] = $books;
            }
        }

        if (empty($baskets)) {
            return [];
        }

        $totalTransactions = count($baskets);

        // 4️⃣ Hitung support item tunggal
        $itemCount = [];
        foreach ($baskets as $basket) {
            foreach ($basket as $bookId) {
                $itemCount[$bookId] = ($itemCount[$bookId] ?? 0) + 1;
            }
        }

        // 5️⃣ Filter item frequent (support item ≥ minsup)
        $frequentItems = [];
        foreach ($itemCount as $bookId => $count) {
            $support = ($count / $totalTransactions) * 100;
            if ($support >= $minSupportPercent) {
                $frequentItems[$bookId] = $count;
            }
        }

        if (count($frequentItems) < 2) {
            return [];
        }

        // 6️⃣ Bentuk association rules A → B
        $rules = [];

        foreach ($frequentItems as $a => $countA) {
            foreach ($frequentItems as $b => $countB) {
                if ($a === $b) continue;

                // Hitung support A ∪ B
                $countAB = 0;
                foreach ($baskets as $basket) {
                    if (in_array($a, $basket) && in_array($b, $basket)) {
                        $countAB++;
                    }
                }

                if ($countAB === 0) continue;

                $supportAB = ($countAB / $totalTransactions) * 100;

                // 🔴 FILTER PENTING: support itemset
                if ($supportAB < $minSupportPercent) {
                    continue;
                }

                // Hitung confidence
                $confidence = ($countAB / $countA) * 100;

                $rules[] = [
                    'from'       => Book::find($a)?->title,
                    'to'         => Book::find($b)?->title,
                    'support'    => round($supportAB, 2),
                    'confidence' => round($confidence, 2),
                ];
            }
        }

        // 7️⃣ Urutkan berdasarkan confidence tertinggi
        usort($rules, fn ($a, $b) =>
            $b['confidence'] <=> $a['confidence']
        );

        return $rules;
    }

    /**
     * Rekomendasi personal untuk member
     * minConfidence default 60%
     */
    public function getRecommendationsForMember(int $userId, int $minConfidence = 60): array
    {
        // Buku yang pernah dipinjam member
        $borrowedBooks = Transaction::where('user_id', $userId)
            ->where('status', 'selesai')
            ->pluck('book_id')
            ->unique()
            ->toArray();

        if (empty($borrowedBooks)) {
            return [];
        }

        // Gunakan support kecil agar rekomendasi lebih fleksibel
        $rules = $this->generateWithConfidence(1);

        $recommended = [];

        foreach ($rules as $rule) {
            $fromId = Book::where('title', $rule['from'])->value('id');

            if (
                in_array($fromId, $borrowedBooks) &&
                $rule['confidence'] >= $minConfidence
            ) {
                $recommended[] = [
                    'title'      => $rule['to'],
                    'confidence' => $rule['confidence'],
                ];
            }
        }

        return collect($recommended)
            ->unique('title')
            ->values()
            ->toArray();
    }
}
