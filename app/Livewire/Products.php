<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Products extends Component
{
    public $products;
    public $showModal = false;
    public $editMode = false;
    public $productId;
    public $name, $purchase_price, $sell_price, $stock, $opening_stock;

    protected $rules = [
        'name' => 'required',
        'purchase_price' => 'required|numeric',
        'sell_price' => 'required|numeric',
        'stock' => 'required|integer',
        'opening_stock' => 'required|integer',
    ];

    public function mount()
    {
        $this->products = Product::latest()->get();
    }

    public function showAddModal()
    {
        $this->resetInputFields();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function showEditModal($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $id;
        $this->name = $product->name;
        $this->purchase_price = $product->purchase_price;
        $this->sell_price = $product->sell_price;
        $this->stock = $product->stock;
        $this->opening_stock = $product->opening_stock;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function saveProduct()
    {
        $this->validate();
        if ($this->editMode) {
            $product = Product::find($this->productId);
            $product->update([
                'name' => $this->name,
                'purchase_price' => $this->purchase_price,
                'sell_price' => $this->sell_price,
                'stock' => $this->stock,
                'opening_stock' => $this->opening_stock,
            ]);
        } else {
            Product::create([
                'name' => $this->name,
                'purchase_price' => $this->purchase_price,
                'sell_price' => $this->sell_price,
                'stock' => $this->stock,
                'opening_stock' => $this->opening_stock,
            ]);
        }
        $this->products = Product::latest()->get();
        $this->showModal = false;
        $this->resetInputFields();

        LivewireAlert::title('Product successfully recorded!')
        ->success()
        ->show();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->purchase_price = '';
        $this->sell_price = '';
        $this->stock = '';
        $this->opening_stock = '';
        $this->productId = null;
    }

    public function render()
    {
        return view('livewire.products');
    }
}
