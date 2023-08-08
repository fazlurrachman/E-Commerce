<?php

namespace App\Charts;

use App\Models\Transaction;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class MonthlyTransactionChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        // monthly
        $bulan = [];
        $transaction = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::create(null, $i, 1, 0, 0, 0);
            $bulan[] = $month->format('F');
            $format = Transaction::whereMonth('created_at', $month->format('m'))->whereYear('created_at', date('Y'))->sum('total_price');
            $transaction[] = $format;
        }

        return $this->chart->barChart()
            ->setTitle('Transaction')
            ->setSubtitle('Tahun ' . date('Y'))
            ->addData('Transactions', $transaction)
            ->setXAxis($bulan);
        // ->setXAxisTitle('Bulan')
        // ->setYAxisTitle('Total Price')
        // ->setDatasetColors(['#3490dc'])
        // ->setGrid(false);
        // ->setYAxisFormat('Rp {value:,.0f}');

    }
}
