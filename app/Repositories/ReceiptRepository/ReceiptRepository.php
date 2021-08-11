<?php

namespace App\Repositories\ReceiptRepository;

use App\Models\Receipt;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class ReceiptRepository extends BaseRepository implements ReceiptRepositoryInterface
{

    public function getModel()
    {
        return Receipt::class;
    }

    public function getCoinsPerMonth($years)
    {
        $coinMonth = [];
        foreach ($years as $year) {
            $months = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $coins = DB::table('receipts')
                ->selectRaw('MONTH(created_at) as month, sum(value * quantity) as coin')
                ->whereRaw('YEAR(created_at) = ' . $year->year)
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->get();
            foreach ($coins as $coin) {
                $months[--$coin->month] = $coin->coin - '0';
            }
            $coinMonth[$year->year] = $months;
        }

        return $coinMonth;
    }
}
