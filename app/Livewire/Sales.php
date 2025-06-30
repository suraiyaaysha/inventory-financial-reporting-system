<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sale;
use App\Models\Product;
use Carbon\Carbon;

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Sales extends Component
{

    public $sales;
    public $products;
    public $showModal = false;

    public $form = [
        'product_id' => '',
        'quantity' => '',
        'discount' => 0,
        'vat_rate' => 5,
        'paid_amount' => '',
    ];

    public $calculations = [
        'unit_price' => 0,
        'subtotal' => 0,
        'discount_amount' => 0,
        'vat_amount' => 0,
        'total' => 0,
        'due_amount' => 0,
    ];

    protected $rules = [
        'form.product_id' => 'required|exists:products,id',
        'form.quantity' => 'required|integer|min:1',
        'form.discount' => 'nullable|numeric|min:0',
        'form.vat_rate' => 'nullable|numeric|min:0|max:100',
        'form.paid_amount' => 'nullable|numeric|min:0',
    ];

    public function mount()
    {
        $this->sales = Sale::orderByDesc('id')->get();
        $this->products = Product::where('stock', '>', 0)->get();
    }

    public function updated($propertyName)
    {
        if (str_starts_with($propertyName, 'form.')) {
            $this->performCalculations();
        }
    }

    private function performCalculations()
    {
        $product = $this->products->find($this->form['product_id']);


        if ($product && !empty($this->form['quantity'])) {
            $quantity = (int) $this->form['quantity'];
            
            $discount = (float) ($this->form['discount'] ?? 0);
            $vatRate = (float) ($this->form['vat_rate'] ?? 0);
            $paidAmount = (float) ($this->form['paid_amount'] ?? 0);

            $subtotal = $product->sell_price * $quantity;
            $discountAmount = $discount; 
            $afterDiscount = $subtotal - $discountAmount;
            $vatAmount = ($afterDiscount * $vatRate) / 100;
            $total = $afterDiscount + $vatAmount;
            $dueAmount = max(0, $total - $paidAmount);

            $this->calculations = [
                'unit_price' => $product->sell_price,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'vat_amount' => $vatAmount,
                'total' => $total,
                'due_amount' => $dueAmount,
            ];
        } else {
            // Reset calculations
            $this->resetCalculations();
        }
    }


    public function showAddModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function saveSale()
    {
        $this->performCalculations();

        $this->validate();

        $product = Product::findOrFail($this->form['product_id']);
        $quantity = (int) $this->form['quantity'];

        // Update product stock
        $product->stock -= $quantity;
        $product->save();

        // Create the sale record
        $sale = Sale::create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'unit_price' => $product->sell_price,
            'subtotal' => (float) $this->calculations['subtotal'],
            'discount' => (float) $this->calculations['discount_amount'],
            'vat_rate' => (float) $this->form['vat_rate'], 
            'vat_amount' => (float) $this->calculations['vat_amount'],
            'total' => (float) $this->calculations['total'],
            'paid_amount' => (float) ($this->form['paid_amount'] ?? 0),
            'due_amount' => (float) $this->calculations['due_amount'],
            'sale_date' => Carbon::now()->toDateString(),
        ]);

        // Refresh data
        $this->sales = Sale::orderByDesc('id')->get();
        $this->products = Product::where('stock', '>', 0)->get();

        // Close modal and reset form
        $this->showModal = false;
        $this->resetForm();

        LivewireAlert::title('Sale successfully recorded!')
        ->success()
        ->show();
    }

    public function resetForm()
    {
        $this->form = [
            'product_id' => '',
            'quantity' => '',
            'discount' => 0,
            'vat_rate' => 5,
            'paid_amount' => '',
        ];
        $this->resetCalculations();
    }

    private function resetCalculations()
    {
        $this->calculations = [
            'unit_price' => 0,
            'subtotal' => 0,
            'discount_amount' => 0,
            'vat_amount' => 0,
            'total' => 0,
            'due_amount' => 0,
        ];
    }

    public function render()
    {
        return view('livewire.sales');
    }
}
