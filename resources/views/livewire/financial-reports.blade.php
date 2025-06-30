
<div>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Financial Report</h2>

        <div class="flex items-center gap-4 mb-6">
            <div>
                <label for="fromDate" class="block text-sm font-medium text-gray-700">From Date</label>
                <input type="date" id="fromDate" v:model="fromDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label for="toDate" class="block text-sm font-medium text-gray-700">To Date</label>
                <input type="date" id="toDate" v:model="toDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                <p class="text-sm font-medium text-gray-600">Total Sales</p>
                <p class="text-2xl font-bold text-gray-900 mt-2">৳{{ number_format($totalSales, 2) }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                <span class="iconify h-6 w-6" data-icon="mdi:dollar"></span>
                </div>
            </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                <p class="text-sm font-medium text-gray-600">Total Expenses</p>
                <p class="text-2xl font-bold text-gray-900 mt-2">৳{{ number_format($totalExpenses, 2) }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-lg">
                <span class="iconify h-6 w-6" data-icon="ix:barchart"></span>
                </div>
            </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Net Profit</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">
                    ৳{{ number_format($profit, 2) }}
                    </p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                <span class="iconify h-6 w-6" data-icon="material-symbols:trending-up"></span>
                </div>
            </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                <p class="text-sm font-medium text-gray-600">Sales Count</p>
                <p class="text-2xl font-bold text-gray-900 mt-2">{{ count($recentSales) }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-lg">
                <span class="iconify h-6 w-6" data-icon="mdi:file-text-outline"></span>
                </div>
            </div>
            </div>
        </div>

        <!-- Profit Analysis & Sales Summary Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Profit Analysis</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                        <span class="text-gray-700">Gross Revenue</span>
                        <span class="font-semibold text-green-600">৳{{ number_format($totalSales, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                        <span class="text-gray-700">Cost of Goods Sold</span>
                        <span class="font-semibold text-red-600">৳{{ number_format($totalExpenses, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                        <span class="text-gray-700">Profit Margin</span>
                        <span class="font-semibold text-blue-600">
                            @if($totalSales > 0)
                                {{ number_format(($profit / $totalSales) * 100, 1) }}%
                            @else
                                0%
                            @endif
                        </span>
                    </div>
                    <hr class="my-4">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-lg font-medium text-gray-900">Net Profit</span>
                        <span class="text-xl font-bold text-green-600">৳{{ number_format($profit, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Sales Summary</h3>
                <div class="space-y-3">
                    @forelse($recentSales as $sale)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $sale->product_name }}</p>
                                <p class="text-sm text-gray-600">{{ $sale->quantity }} units × ৳{{ number_format($sale->unit_price, 2) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">৳{{ number_format($sale->total, 2) }}</p>
                                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($sale->sale_date)->format('n/j/Y') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No sales found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
