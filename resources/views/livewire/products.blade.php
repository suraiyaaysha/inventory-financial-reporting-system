<div>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Products List</h2>
        <button wire:click="showAddModal" class="bg-blue-500 text-white px-4 py-2 rounded">Add Product</button>
    </div>

    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="px-4 py-2 border">Name</th>
                <th class="px-4 py-2 border">Purchase Price</th>
                <th class="px-4 py-2 border">Sell Price</th>
                <th class="px-4 py-2 border">Stock</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td class="px-4 py-2 border">{{ $product->name }}</td>
                    <td class="px-4 py-2 border">{{ $product->purchase_price }}</td>
                    <td class="px-4 py-2 border">{{ $product->sell_price }}</td>
                    <td class="px-4 py-2 border">{{ $product->stock }}</td>
                    <td class="px-4 py-2 border">
                        @if($product->stock < 10)
                            <span class="inline-flex items-center space-x-1 px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12A9 9 0 113 12a9 9 0 0118 0z" /></svg>
                                <span>Low Stock</span>
                            </span>
                        @else
                            <span class="inline-flex px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                In Stock
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border">
                        <button wire:click="showEditModal({{ $product->id }})" class="bg-yellow-400 text-white px-2 py-1 rounded">Edit</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
                <h3 class="text-lg font-bold mb-4">{{ $editMode ? 'Edit Product' : 'Add Product' }}</h3>
                <form wire:submit.prevent="saveProduct">
                    <div class="mb-2">
                        <label>Name</label>
                        <input type="text" wire:model.defer="name" class="w-full border rounded px-2 py-1" />
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-2">
                        <label>Purchase Price</label>
                        <input type="number" step="0.01" wire:model.defer="purchase_price" class="w-full border rounded px-2 py-1" />
                        @error('purchase_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-2">
                        <label>Sell Price</label>
                        <input type="number" step="0.01" wire:model.defer="sell_price" class="w-full border rounded px-2 py-1" />
                        @error('sell_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-2">
                        <label>Stock</label>
                        <input type="number" wire:model.defer="stock" class="w-full border rounded px-2 py-1" />
                        @error('stock') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-2">
                        <label>Opening Stock</label>
                        <input type="number" wire:model.defer="opening_stock" class="w-full border rounded px-2 py-1" />
                        @error('opening_stock') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" wire:click="$set('showModal', false)" class="bg-gray-400 text-white px-4 py-2 rounded mr-2">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">{{ $editMode ? 'Update' : 'Add' }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
