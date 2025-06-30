<?php

namespace App\Livewire;

use App\Models\Sale;
use Livewire\Component;

class FinancialReports extends Component
{
    public $fromDate;
    public $toDate;

    public $totalSales = 0;
    public $totalExpenses = 0;
    public $profit = 0;
    public $recentSales = [];

    public function mount()
    {
        $this->fromDate = now()->startOfMonth()->format('Y-m-d');
        $this->toDate = now()->endOfMonth()->format('Y-m-d');
        $this->calculate();
    }

    public function calculate()
    {
        $sales = Sale::whereBetween('sale_date', [$this->fromDate, $this->toDate])->get();

        $this->totalSales = $sales->sum('total');
        $this->totalExpenses = $sales->sum('discount') + $sales->sum('vat_amount');
        $this->profit = $this->totalSales - $this->totalExpenses;

        $this->recentSales = Sale::whereBetween('sale_date', [$this->fromDate, $this->toDate])
            ->orderByDesc('sale_date')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.financial-reports');
    }
}
