<!DOCTYPE html>
<html class="h-full bg-white" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Inventory & Financial Reporting System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom CSS -->
    @stack('css')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="h-full">
    <div class="min-h-screen bg-gray-100">

        <div x-data="{ isOpen: false }">

            <!-- Sidebar Navbar Start -->

            <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
            <div class="relative z-50 lg:hidden" role="dialog" aria-modal="true" x-show="isOpen">

                <div class="fixed inset-0 bg-gray-900/80"></div>

                <div class="fixed inset-0 flex">
                    <div class="relative mr-16 flex w-full max-w-xs flex-1">

                        <div class="absolute left-full top-0 flex w-16 justify-center pt-5" @click="isOpen = !isOpen">
                            <button type="button" class="-m-2.5 p-2.5">
                                <span class="sr-only">Close sidebar</span>
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Static sidebar for Mobile -->
                        <div
                            class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6 pb-4">
                            <div class="flex h-16 shrink-0 items-center">
                                <a href="/" class="font-bold text-xl text-gray-900">
                                    <x-application-logo class="h-11 w-auto" />
                                </a>
                            </div>
                            <livewire:layout.sidebar-navigation />

                        </div>

                    </div>
                </div>
            </div>

            <!-- Static sidebar for Desktop -->
            <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
                <!-- Sidebar navigation component -->
                <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6 pb-4">
                    <div class="flex h-16 shrink-0 items-center">
                        <a href="/" class="font-bold text-xl text-gray-900">
                            <x-application-logo class="h-12 w-auto" />
                        </a>
                    </div>

                        <livewire:layout.sidebar-navigation />

                </div>
            </div>

            <!-- Sidebar Navbar End -->

            <div class="lg:pl-72">

                <!-- Top Navbar Start -->
                <livewire:layout.top-navbar />
                <!-- Top Navbar End-->

                <main class="py-8">
                    <div class="px-4 sm:px-6 lg:px-6">

                        {{ $slot }}

                    </div>
                </main>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    @stack('script')

    @include('layouts.scripts')

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- For livewire alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
