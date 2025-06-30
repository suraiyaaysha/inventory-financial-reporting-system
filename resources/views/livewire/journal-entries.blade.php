<div>
    <div class="p-4 space-y-6">
        <h2 class="text-2xl font-bold mb-6">Journal Entries</h2>

        @foreach($sales as $sale)
            @php
                $entries = [
                    [
                        'type' => 'SALES',
                        'description' => "Sales of {$sale->product_name} - {$sale->quantity} units",
                        'debit' => $sale->subtotal,
                        'credit' => 0,
                    ],
                    [
                        'type' => 'DISCOUNT',
                        'description' => "Discount on sale #{$sale->id}",
                        'debit' => 0,
                        'credit' => $sale->discount,
                    ],
                    [
                        'type' => 'VAT',
                        'description' => "VAT on sale #{$sale->id}",
                        'debit' => $sale->vat_amount,
                        'credit' => 0,
                    ],
                    [
                        'type' => 'CASH',
                        'description' => "Cash received for sale #{$sale->id}",
                        'debit' => 0,
                        'credit' => $sale->paid_amount,
                    ],
                    [
                        'type' => 'DUE',
                        'description' => "Due amount for sale #{$sale->id}",
                        'debit' => $sale->due_amount,
                        'credit' => 0,
                    ],
                ];

                $filteredEntries = array_filter($entries, function($entry) {
                    return $entry['debit'] > 0 || $entry['credit'] > 0;
                });

                $totalDebit = array_sum(array_column($filteredEntries, 'debit'));
                $totalCredit = array_sum(array_column($filteredEntries, 'credit'));
            @endphp

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                {{-- Sale Header - clickable for toggle --}}
                <div 
                    class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 cursor-pointer hover:from-blue-100 hover:to-indigo-100 transition-colors flex justify-between items-center"
                    wire:click="toggleSaleExpansion({{ $sale->id }})"
                >
                    <div class="flex items-center space-x-4">
                        <div class="bg-blue-600 p-2 rounded-lg">
                            <!-- Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-receipt text-white">
                                <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"></path>
                                <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path>
                                <path d="M12 17.5v-11"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Sale #{{ $sale->id }} - {{ $sale->product_name }}</h3>
                            <p class="text-sm text-gray-600">{{ $sale->sale_date }} • {{ $sale->quantity }} units • Total: ৳{{ number_format($sale->total, 2) }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Journal Balance</p>
                        <p class="font-semibold text-gray-900">Dr: ৳{{ number_format($totalDebit, 2) }} | Cr: ৳{{ number_format($totalCredit, 2) }}</p>
                    </div>
                </div>

                {{-- Journal entries - show only if expanded --}}
                @if(in_array($sale->id, $expandedSales))
                    <div class="p-6">
                        <div class="grid gap-3">
                            @foreach($filteredEntries as $entry)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center space-x-3">
                                        <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-sm font-medium border
                                            @if($entry['type'] == 'SALES') border-green-200 bg-green-100 text-green-800
                                            @elseif($entry['type'] == 'DISCOUNT') border-red-200 bg-red-100 text-red-800
                                            @elseif($entry['type'] == 'VAT') border-blue-200 bg-blue-100 text-blue-800
                                            @elseif($entry['type'] == 'CASH') border-purple-200 bg-purple-100 text-purple-800
                                            @elseif($entry['type'] == 'DUE') border-orange-200 bg-orange-100 text-orange-800
                                            @else border-gray-200 bg-gray-100 text-gray-800
                                            @endif
                                        ">
                                            <span>{{ $entry['type'] }}</span>
                                        </span>
                                        <span class="text-gray-900 font-medium">{{ $entry['description'] }}</span>
                                    </div>
                                    <div class="flex items-center space-x-6">
                                        <div class="text-right min-w-[100px]">
                                            <p class="text-xs text-gray-500 uppercase tracking-wide">Debit</p>
                                            @if($entry['debit'] > 0)
                                                <p class="font-semibold text-green-600">৳{{ number_format($entry['debit'], 2) }}</p>
                                            @else
                                                <p class="text-gray-400">-</p>
                                            @endif
                                        </div>
                                        <div class="text-right min-w-[100px]">
                                            <p class="text-xs text-gray-500 uppercase tracking-wide">Credit</p>
                                            @if($entry['credit'] > 0)
                                                <p class="font-semibold text-red-600">৳{{ number_format($entry['credit'], 2) }}</p>
                                            @else
                                                <p class="text-gray-400">-</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex justify-between items-center bg-blue-50 p-3 rounded-lg">
                                <span class="font-semibold text-blue-900">Transaction Total:</span>
                                <div class="flex space-x-6">
                                    <span class="text-green-600 font-semibold">Dr: ৳{{ number_format($totalDebit, 2) }}</span>
                                    <span class="text-red-600 font-semibold">Cr: ৳{{ number_format($totalCredit, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach

    </div>
</div>

