<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Sale;
use Livewire\Component;

class Dashboard extends Component
{
    public $stats = [];
    public $recentSales = [];
    public $lowStockProducts = [];

    public function mount()
    {
        $this->stats = [
            [
                'title' => 'Total Products',
                'value' => Product::count(),
                'bgColor' => 'bg-blue-100',
                'textColor' => 'text-blue-600',
                'icon' => 'mdi:package-variant-closed',
            ],
            [
                'title' => 'Total Stock',
                'value' => Product::sum('stock'),
                'bgColor' => 'bg-green-100',
                'textColor' => 'text-green-600',
                'icon' => 'mdi:warehouse',
            ],
            [
                'title' => 'Total Sales',
                'value' => Sale::sum('total'),
                'bgColor' => 'bg-purple-100',
                'textColor' => 'text-purple-600',
                'icon' => 'mdi:currency-bdt',
            ],
            [
                'title' => 'Low Stock Items',
                'value' => Product::where('stock', '<', 10)->count(),
                'bgColor' => 'bg-red-100',
                'textColor' => 'text-red-600',
                'icon' => 'mdi:alert-circle-outline',
            ],
        ];

        $this->recentSales = Sale::latest()->take(5)->get();
        $this->lowStockProducts = Product::where('stock', '<', 10)->get();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
