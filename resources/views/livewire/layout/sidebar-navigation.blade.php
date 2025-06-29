    <nav class="flex flex-1 flex-col">
        <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
                <ul role="list" class="-mx-2 space-y-1">

                    <li>
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                            <span class="iconify mr-2 ml-0 h-6 w-6 shrink-0 text-gray-700 group-hover:text-green-600 
                                @if (request()->routeIs('dashboard')) text-green-600 @endif" 
                                data-icon="material-symbols:dashboard-outline">
                            </span>
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    </li>

                    <li>
                        <x-nav-link :href="route('products')" :active="request()->routeIs('products')" wire:navigate >

                            <span class="iconify mr-2 ml-0 h-6 w-6 shrink-0 text-gray-700 group-hover:text-green-600 
                                @if (request()->routeIs('products')) text-green-600 @endif" 
                                data-icon="streamline-ultimate:products-gifts">
                            </span>
                            {{ __('Products') }}
                        </x-nav-link>
                    </li>

                    <li>
                        <x-nav-link  href="{{ route('sales') }}" :active="request()->routeIs('sales')">

                            <span class="iconify ml-0 h-6 w-6 shrink-0 text-gray-700 group-hover:text-green-600 
                                @if (request()->routeIs('sales')) text-green-600 @endif" 
                                data-icon="hugeicons:sale-tag-02">
                            </span>

                            {{ __('Sales') }}
                        </x-nav-link>
                    </li>

                    {{-- <li>
                        <x-nav-link  href="{{ route('jurnal') }}" :active="request()->routeIs('jurnal')">

                            <span class="iconify ml-0 h-6 w-6 shrink-0 text-gray-700 group-hover:text-green-600 
                                @if (request()->routeIs('jurnal')) text-green-600 @endif" 
                                data-icon="iconoir:journal">
                            </span>

                            {{ __('Journal Entries') }}
                        </x-nav-link>
                    </li> --}}

                    {{-- <li>
                        <x-nav-link  href="{{ route('reports') }}" :active="request()->routeIs('reports')">

                            <span class="iconify ml-0 h-6 w-6 shrink-0 text-gray-700 group-hover:text-green-600 
                                @if (request()->routeIs('reports')) text-green-600 @endif" 
                                data-icon="mdi:report-pie">
                            </span>

                            {{ __('Financial Reports') }}
                        </x-nav-link>
                    </li> --}}

                </ul>
            </li>
        </ul>
    </nav>
