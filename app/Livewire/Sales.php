<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sale;
use App\Models\Product;
use Carbon\Carbon;

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

    public function updatedForm()
    {
        $product = $this->products->find($this->form['product_id']);
        if ($product && $this->form['quantity']) {
            $quantity = (int) $this->form['quantity'];
            $discount = (float) $this->form['discount'];
            $vatRate = (float) $this->form['vat_rate'];
            $paidAmount = (float) $this->form['paid_amount'];
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
        }
    }


    public function showAddModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function saveSale()
    {
        $this->validate();
        $product = Product::findOrFail($this->form['product_id']);
        $quantity = (int) $this->form['quantity'];
        $product->stock -= $quantity;
        $product->save();
        $sale = Sale::create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'unit_price' => $product->sell_price,
            'subtotal' => $this->calculations['subtotal'],
            'discount' => $this->calculations['discount_amount'],
            'vat_rate' => $this->form['vat_rate'],
            'vat_amount' => $this->calculations['vat_amount'],
            'total' => $this->calculations['total'],
            'paid_amount' => $this->form['paid_amount'] ?? 0,
            'due_amount' => $this->calculations['due_amount'],
            'sale_date' => Carbon::now()->toDateString(),
        ]);
        $this->sales = Sale::orderByDesc('id')->get();
        $this->products = Product::where('stock', '>', 0)->get();
        $this->showModal = false;
        $this->resetForm();
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

