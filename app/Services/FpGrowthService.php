<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Book;

class FpGrowthService
{
    /**
     * Generate FP-Growth Association Rules
     * + Top Buku Populer (berdasarkan frequent itemset)
     *
     * @param int $minSupportPercent
     * @return array
     */
    public function generateWithConfidence(int $minSupportPercent = 30): array
    {
        // 1️⃣ Ambil transaksi selesai
        $transactions = Transaction::where('status', 'selesai')
            ->whereNotNull('borrow_date')
            ->get();

        if ($transactions->isEmpty()) {
            return [
                'rules' => [],
                'frequentBooks' => []
            ];
        }

        // 2️⃣ Kelompokkan transaksi
        // Satu basket = satu user dalam satu bulan
        $grouped = $transactions->groupBy(fn ($t) =>
            $t->user_id . '-' . date('Y-m', strtotime($t->borrow_date))
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
            return [
                'rules' => [],
                'frequentBooks' => []
            ];
        }

        $totalTransactions = count($baskets);

        // 4️⃣ Hitung frekuensi item tunggal
        $itemCount = [];
        foreach ($baskets as $basket) {
            foreach ($basket as $bookId) {
                $itemCount[$bookId] = ($itemCount[$bookId] ?? 0) + 1;
            }
        }

        // Ambil judul buku sekali saja (optimasi)
        $bookTitles = Book::pluck('title', 'id');

        // 5️⃣ Filter item frequent berdasarkan min support
        $frequentItems = [];
        foreach ($itemCount as $bookId => $count) {
            $support = ($count / $totalTransactions) * 100;
            if ($support >= $minSupportPercent) {
                $frequentItems[$bookId] = $count;
            }
        }

        if (count($frequentItems) < 2) {
            return [
                'rules' => [],
                'frequentBooks' => []
            ];
        }

        // 6️⃣ Bentuk association rules
        $rules = [];

        foreach ($frequentItems as $a => $countA) {
            foreach ($frequentItems as $b => $countB) {
                if ($a === $b) continue;

                // Hitung A ∪ B
                $countAB = 0;
                foreach ($baskets as $basket) {
                    if (in_array($a, $basket) && in_array($b, $basket)) {
                        $countAB++;
                    }
                }

                if ($countAB === 0) continue;

                $supportAB = ($countAB / $totalTransactions) * 100;

                // Filter support itemset
                if ($supportAB < $minSupportPercent) {
                    continue;
                }

                // Hitung confidence
                $confidence = ($countAB / $countA) * 100;

                $rules[] = [
                    'from'       => $bookTitles[$a] ?? '-',
                    'to'         => $bookTitles[$b] ?? '-',
                    'support'    => round($supportAB, 2),
                    'confidence' => round($confidence, 2),
                ];
            }
        }

        // 7️⃣ Urutkan rules berdasarkan confidence
        usort($rules, fn ($a, $b) =>
            $b['confidence'] <=> $a['confidence']
        );

        // 8️⃣ Top buku populer (frequent itemset)
        $frequentBooks = collect($frequentItems)
            ->sortDesc()
            ->take(5)
            ->map(fn ($count, $id) => [
                'title' => $bookTitles[$id] ?? '-',
                'count' => $count
            ])
            ->values()
            ->toArray();

        return [
            'rules' => $rules,
            'frequentBooks' => $frequentBooks
        ];
    }

    /**
 * Rekomendasi buku global untuk member
 */
public function getGlobalRecommendations(
    int $minSupport = 30,
    int $minConfidence = 60,
    int $limit = 5
): array {
    $result = $this->generateWithConfidence($minSupport);

    $rules = collect($result['rules'])
        ->filter(fn ($r) => $r['confidence'] >= $minConfidence)
        ->sortByDesc('confidence')
        ->take($limit)
        ->values()
        ->toArray();

    return $rules;
}

}
