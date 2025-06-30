<?php

namespace App\Livewire;

use App\Models\Sale;
use Livewire\Component;


class JournalEntries extends Component
{
    public $expandedSales = [];

    public function toggleSaleExpansion($saleId)
    {
        if (in_array($saleId, $this->expandedSales)) {
            $this->expandedSales = array_diff($this->expandedSales, [$saleId]);
        } else {
            $this->expandedSales[] = $saleId;
        }
    }

    public function render()
    {
        $sales = Sale::latest()->get();

        return view('livewire.journal-entries', compact('sales'));
    }
}
