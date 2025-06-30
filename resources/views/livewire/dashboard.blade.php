<div>
    <div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600 mt-2">Welcome to your inventory management system</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @foreach($stats as $stat)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">{{ $stat['title'] }}</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">
                        {{ is_numeric($stat['value']) ? number_format($stat['value']) : $stat['value'] }}
                    </p>
                </div>
                <div class="{{ $stat['bgColor'] }} p-3 rounded-lg">
                    <span class="iconify text-xl {{ $stat['textColor'] }}" data-icon="{{ $stat['icon'] }}"></span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Main Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Sales -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Sales</h3>
            <div class="space-y-3">
                @forelse($recentSales as $sale)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">{{ $sale->product_name }}</p>
                            <p class="text-sm text-gray-600">{{ $sale->quantity }} units</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">৳{{ number_format($sale->total, 2) }}</p>
                            <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M, Y') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No sales recorded yet</p>
                @endforelse
            </div>
        </div>

        <!-- Stock Alert -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Stock Alert</h3>
            <div class="space-y-3">
                @forelse($lowStockProducts as $product)
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200">
                        <div>
                            <p class="font-medium text-gray-900">{{ $product->name }}</p>
                            <p class="text-sm text-red-600">Low stock warning</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-red-700">{{ $product->stock }} units</p>
                            <p class="text-sm text-gray-600">Remaining</p>
                        </div>
                    </div>
                @empty
                    <p class="text-green-600 text-center py-4">All products have sufficient stock</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

</div>
