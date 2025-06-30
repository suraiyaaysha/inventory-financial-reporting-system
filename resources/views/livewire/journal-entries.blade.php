<div>
    <div class="p-4 space-y-6">
        <h2 class="text-2xl font-bold mb-6">Journal Entries</h2>

        @foreach($sales as $sale)
            @php
                $journalEntries = [];


                if ($sale->paid_amount > 0) {
                    $journalEntries[] = [
                        'type' => 'Cash',
                        'description' => "Cash received for Sale #{$sale->id}",
                        'debit' => $sale->paid_amount,
                        'credit' => 0,
                        'account_type_class' => 'border-purple-200 bg-purple-100 text-purple-800'
                    ];
                }

                if ($sale->due_amount > 0) {
                    $journalEntries[] = [
                        'type' => 'Accounts Receivable',
                        'description' => "Due amount from customer for Sale #{$sale->id}",
                        'debit' => $sale->due_amount,
                        'credit' => 0,
                        'account_type_class' => 'border-orange-200 bg-orange-100 text-orange-800'
                    ];
                }

                $journalEntries[] = [
                    'type' => 'Sales Revenue',
                    'description' => "Gross sales of {$sale->product_name} ({$sale->quantity} units) for Sale #{$sale->id}",
                    'debit' => 0,
                    'credit' => $sale->subtotal,
                    'account_type_class' => 'border-green-200 bg-green-100 text-green-800'
                ];


                if ($sale->discount > 0) {
                    $journalEntries[] = [
                        'type' => 'Sales Discount',
                        'description' => "Discount given on Sale #{$sale->id}",
                        'debit' => $sale->discount,
                        'credit' => 0,
                        'account_type_class' => 'border-red-200 bg-red-100 text-red-800'
                    ];
                }

                if ($sale->vat_amount > 0) {
                    $journalEntries[] = [
                        'type' => 'VAT Payable',
                        'description' => "VAT collected on Sale #{$sale->id}",
                        'debit' => 0,
                        'credit' => $sale->vat_amount,
                        'account_type_class' => 'border-blue-200 bg-blue-100 text-blue-800'
                    ];
                }

                $productPurchasePrice = $sale->product->purchase_price ?? 0;
                $cogsAmount = $productPurchasePrice * $sale->quantity;

                if ($cogsAmount > 0) {
                    $journalEntries[] = [
                        'type' => 'Cost of Goods Sold',
                        'description' => "Cost of items sold for Sale #{$sale->id} ({$sale->quantity} units of {$sale->product_name})",
                        'debit' => $cogsAmount,
                        'credit' => 0,
                        'account_type_class' => 'border-gray-200 bg-gray-100 text-gray-800'
                    ];

                    $journalEntries[] = [
                        'type' => 'Inventory',
                        'description' => "Inventory reduction for Sale #{$sale->id}",
                        'debit' => 0,
                        'credit' => $cogsAmount,
                        'account_type_class' => 'border-gray-200 bg-gray-100 text-gray-800'
                    ];
                }

                $totalDebit = array_sum(array_column($journalEntries, 'debit'));
                $totalCredit = array_sum(array_column($journalEntries, 'credit'));
            @endphp


            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div
                    class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 cursor-pointer hover:from-blue-100 hover:to-indigo-100 transition-colors flex justify-between items-center"
                    wire:click="toggleSaleExpansion({{ $sale->id }})"
                >
                    <div class="flex items-center space-x-4">
                        <div class="bg-blue-600 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-receipt text-white">
                                <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"></path>
                                <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path>
                                <path d="M12 17.5v-11"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Sale #{{ $sale->id }} - {{ $sale->product_name }}</h3>
                            <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y') }} • {{ $sale->quantity }} units • Total: ৳{{ number_format($sale->total, 2) }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Journal Balance</p>

                        <p class="font-semibold {{ abs($totalDebit - $totalCredit) < 0.01 ? 'text-gray-900' : 'text-red-600' }}">
                            Dr: ৳{{ number_format($totalDebit, 2) }} | Cr: ৳{{ number_format($totalCredit, 2) }}
                            @if(abs($totalDebit - $totalCredit) >= 0.01)
                                <span class="text-xs ml-2">(Unbalanced!)</span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Journal entries details - shown only if the sale is expanded --}}
                @if(in_array($sale->id, $expandedSales))
                    <div class="p-6">
                        <div class="grid gap-3">
                            @foreach($journalEntries as $entry)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center space-x-3">

                                        <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-sm font-medium border {{ $entry['account_type_class'] ?? 'border-gray-200 bg-gray-100 text-gray-800' }}">
                                            <span>{{ $entry['type'] }}</span>
                                        </span>
                                        <span class="text-gray-900 font-medium">{{ $entry['description'] }}</span>
                                    </div>
                                    <div class="flex items-center space-x-6">
                                        {{-- Debit amount display --}}
                                        <div class="text-right min-w-[100px]">
                                            <p class="text-xs text-gray-500 uppercase tracking-wide">Debit</p>
                                            @if($entry['debit'] > 0)
                                                <p class="font-semibold text-green-600">৳{{ number_format($entry['debit'], 2) }}</p>
                                            @else
                                                <p class="text-gray-400">-</p>
                                            @endif
                                        </div>
                                        {{-- Credit amount display --}}
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

                        {{-- Transaction total summary --}}
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

