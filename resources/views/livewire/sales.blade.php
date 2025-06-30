<div>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Sales</h1>
            <p class="text-gray-600 mt-2">Manage your sales transactions</p>
        </div>
        <button wire:click="showAddModal" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            <span>New Sale</span>
        </button>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left py-4 px-6 font-semibold text-gray-900">Sale ID</th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-900">Product</th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-900">Quantity</th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-900">Subtotal</th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-900">Discount</th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-900">VAT</th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-900">Total</th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-900">Paid</th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-900">Due</th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-900">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-green-100 p-2 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3V3zm3 3h12v12H6V6z" /></svg>
                                    </div>
                                    <span class="font-mono text-sm text-gray-900">#{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-medium text-gray-900">{{ $sale->product_name }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-gray-900">{{ $sale->quantity }} units</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-gray-900">৳{{ number_format($sale->subtotal, 2) }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-red-600">-৳{{ number_format($sale->discount, 2) }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-gray-900">৳{{ number_format($sale->vat_amount, 2) }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-semibold text-gray-900">৳{{ number_format($sale->total, 2) }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-green-600">৳{{ number_format($sale->paid_amount, 2) }}</span>
                            </td>
                            <td class="py-4 px-6">
                                @if($sale->due_amount > 0)
                                    <span class="text-red-600 font-medium">৳{{ number_format($sale->due_amount, 2) }}</span>
                                @else
                                    <span class="text-green-600">Paid</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-gray-600">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-8 text-center text-gray-500">
                                No sales recorded yet
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
                    <h2 class="text-xl font-semibold text-gray-900">Create New Sale</h2>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form wire:submit.prevent="saveSale"
                x-data="{
                    products: @js($products->keyBy('id')),
                    selectedProductId: @entangle('form.product_id'),
                    quantity: @entangle('form.quantity'),
                    // REMOVED .defer from discount, vat_rate, and paid_amount
                    discount: @entangle('form.discount'),
                    vat_rate: @entangle('form.vat_rate'),
                    paid_amount: @entangle('form.paid_amount'),
                    get product() {
                        return this.products[this.selectedProductId] || { sell_price: 0, stock: 0 };
                    },
                    get subtotal() {
                        return this.product.sell_price * this.quantity || 0;
                    },
                    get discountAmount() {
                        return parseFloat(this.discount) || 0;
                    },
                    get afterDiscount() {
                        return this.subtotal - this.discountAmount;
                    },
                    get vatAmount() {
                        return this.afterDiscount * (parseFloat(this.vat_rate) || 0) / 100;
                    },
                    get total() {
                        return this.afterDiscount + this.vatAmount;
                    },
                    get dueAmount() {
                        return Math.max(0, this.total - (parseFloat(this.paid_amount) || 0));
                    }
                }"
                class="p-6 space-y-6"
                >
                <!-- Product Select -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Product</label>
                    <select x-model="selectedProductId" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                        <option value="">Choose a product...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }} - ৳{{ $product->sell_price }} (Stock: {{ $product->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Quantity & Unit Price -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                        <input type="number" x-model="quantity" min="1" class="w-full px-3 py-2 border rounded-lg" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Unit Price (৳)</label>
                        <input type="text" :value="`৳${product.sell_price}`" class="w-full px-3 py-2 border rounded-lg bg-gray-50" disabled />
                    </div>
                </div>

                <!-- Discount & VAT -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Discount (৳)</label>
                        <input type="number" x-model="discount" step="0.01" min="0" class="w-full px-3 py-2 border rounded-lg" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">VAT Rate (%)</label>
                        <input type="number" x-model="vat_rate" step="0.01" min="0" max="100" class="w-full px-3 py-2 border rounded-lg" />
                    </div>
                </div>

                <!-- Paid Amount -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Paid Amount (৳)</label>
                    <input type="number" x-model="paid_amount" step="0.01" min="0" class="w-full px-3 py-2 border rounded-lg" />
                </div>

                <!-- Summary Section -->
                <template x-if="selectedProductId && quantity">
                    <div class="summary-part bg-blue-50 rounded-lg p-4 border border-blue-200 mt-4">
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span>Subtotal:</span>
                                <span class="font-medium">৳<span x-text="subtotal.toFixed(2)"></span></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Discount:</span>
                                <span class="text-red-600">-৳<span x-text="discountAmount.toFixed(2)"></span></span>
                            </div>
                            <div class="flex justify-between">
                                <span>VAT (<span x-text="vat_rate"></span>%):</span>
                                <span>৳<span x-text="vatAmount.toFixed(2)"></span></span>
                            </div>
                            <hr class="my-2 border-blue-200" />
                            <div class="flex justify-between text-lg font-semibold">
                                <span>Total:</span>
                                <span>৳<span x-text="total.toFixed(2)"></span></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Paid:</span>
                                <span class="text-green-600">৳<span x-text="parseFloat(paid_amount || 0).toFixed(2)"></span></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Due:</span>
                                <span :class="dueAmount > 0 ? 'text-red-600' : 'text-green-600'">৳<span x-text="dueAmount.toFixed(2)"></span></span>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Buttons -->
                <div class="flex space-x-4 pt-4">
                    <button type="button" wire:click="$set('showModal', false)" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Sale</button>
                </div>
            </form>
            
            </div>
        </div>
    @endif
</div>
