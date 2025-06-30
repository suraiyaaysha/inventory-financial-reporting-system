<div>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Products</h1>
            <p class="text-gray-600 mt-2">Manage your Products</p>
        </div>
        <button wire:click="showAddModal" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            <span>Add Product</span>
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left py-4 px-6 font-semibold text-gray-900">Product Name</th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-900">Purchase Price</th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-900">Sell Price</th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-900">Stock</th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-900">Status</th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-4 px-6">{{ $product->name }}</td>
                            <td class="py-4 px-6">{{ $product->purchase_price }}</td>
                            <td class="py-4 px-6">{{ $product->sell_price }}</td>
                            <td class="py-4 px-6">{{ $product->stock }}</td>
                            <td class="py-4 px-6">
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
                            <td class="py-4 px-6">
                                <button wire:click="showEditModal({{ $product->id }})" class="bg-yellow-400 text-white px-2 py-1 rounded">Edit</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500">
                                No products recorded yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">{{ $editMode ? 'Edit Product' : 'Add Product' }}</h2>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <form wire:submit.prevent="saveProduct" class="p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                        <input type="text" wire:model.defer="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Purchase Price</label>
                        <input type="number" step="0.01" wire:model.defer="purchase_price" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                        @error('purchase_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sell Price</label>
                        <input type="number" step="0.01" wire:model.defer="sell_price" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                        @error('sell_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                        <input type="number" wire:model.defer="stock" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                        @error('stock') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Opening Stock</label>
                        <input type="number" wire:model.defer="opening_stock" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                        @error('opening_stock') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex space-x-4 pt-4">
                        <button type="button" wire:click="$set('showModal', false)" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">Cancel</button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">{{ $editMode ? 'Update' : 'Add' }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
