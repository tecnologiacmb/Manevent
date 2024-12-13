<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="/dist/tailwind.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">

    <div class="min-h-screen w-full h-full " style="background-color: #d181123b;">
        <dh-component>

            <div class="flex flex-no-wrap">

                <div class="min-h-screen w-64 absolute sm:relative shadow md:h-full flex-col justify-between hidden sm:flex"
                    style="background-color: #ca872a45;">

                    <div class="px-8">

                        <div class="h-16 w-full flex items-center text-black text-xl">
                            LOGO
                        </div>
                        <ul class="mt-12">
                            <li class="flex w-full justify-between text-black cursor-pointer items-center mb-6">
                                <div
                                    class="p-2.5 mt-0 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-black text-black  hover:text-white">
                                    <i class="bi bi-house-fill"></i>
                                    <div class="flex justify-between w-full items-center">
                                        <h1 class="cursor-pointer px-3 text-xl rounded-md mt-1 hover:text-white">
                                            <a href="{{ route('dashboard') }}"
                                                :active="request() - > routeIs('dashboard')" class="ml-2"
                                                wire:navigate>Home</a>
                                        </h1>

                                    </div>
                                </div>

                            </li>
                            <li class="flex w-full justify-between text-black cursor-pointer items-center mb-6">
                                <div
                                    class="p-2.5 mt-0 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-black text-black  hover:text-white">
                                    <i class="bi bi-house-fill"></i>
                                    <div class="flex justify-between w-full items-center">
                                        <h1 class="cursor-pointer px-3 text-xl rounded-md mt-1 hover:text-white">
                                            <a href="{{ route('evento') }}" :active="request() - > routeIs('evento')"
                                                class="ml-2" wire:navigate>Eventos</a>
                                        </h1>

                                    </div>
                                </div>

                            </li>
                            <li
                                class=" w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6 ">

                                <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-black text-black hover:text-white "
                                    onclick="dropdown1()">
                                    <i class="bi bi-gear-fill"></i>
                                    <div class="flex justify-between w-full items-center ">
                                        <h1 class="cursor-pointer px-3 text-xl rounded-md mt-1 hover:text-white">
                                            Administrar
                                        </h1>
                                        <span class="text-sm rotate-180" id="arrow1">
                                            <i class="bi bi-chevron-down"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="text-left text-sm mt-2 w-4/5 mx-auto text-black font-bold" id="submenu1">

                                    <h1 class="cursor-pointer p-2 hover:bg-black rounded-md mt-1 hover:text-white">
                                        <i class="bi bi-bank2"></i>
                                        <a href="{{ route('banco') }}" :active="request() - > routeIs('banco')"
                                            class="ml-2" wire:navigate>Banco</a>
                                    </h1>
                                    <h1 class="cursor-pointer p-2 hover:bg-black rounded-md mt-1 hover:text-white">
                                        <i class="bi bi-cash-coin"></i>
                                        <a href="{{ route('metodo-pago') }}"
                                            :active="request() - > routeIs('metodo-pago')" class="ml-2"
                                            wire:navigate>Metodo
                                            Pago</a>
                                    </h1>
                                    <h1 class="cursor-pointer p-2 hover:bg-black rounded-md mt-1 hover:text-white">
                                        <i class="bi bi-tags-fill"></i><a href="{{ route('categoria') }}"
                                            :active="request() - > routeIs('categoria')" class="ml-2"
                                            wire:navigate>Categoria</a>
                                    </h1>
                                    <h1 class="cursor-pointer p-2 hover:bg-black rounded-md mt-1 hover:text-white">
                                        <i class="bi bi-collection-fill"></i> <a href="{{ route('grupo') }}"
                                            :active="request() - > routeIs('grupo')" class="ml-2"
                                            wire:navigate>Grupo</a>
                                    </h1>

                                </div>

                            </li>
                            <li
                                class=" w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6 ">

                                <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-black text-black hover:text-white"
                                    onclick="dropdown2()">
                                    <i class="bi bi-pencil-square"></i>
                                    <div class="flex justify-between w-full items-center">
                                        <h1 class="cursor-pointer px-3 text-xl rounded-md mt-1 hover:text-white">
                                            Inscripciones
                                        </h1>
                                        <span class="text-sm rotate-180" id="arrow2">
                                            <i class="bi bi-chevron-down"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="text-left text-sm mt-2 w-4/5 mx-auto text-black font-bold" id="submenu2">
                                    <h1 class="flex cursor-pointer p-2 hover:bg-black rounded-md mt-1 hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-person-walking" viewBox="0 0 16 16">
                                            <path
                                                d="M9.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0M6.44 3.752A.75.75 0 0 1 7 3.5h1.445c.742 0 1.32.643 1.243 1.38l-.43 4.083a1.8 1.8 0 0 1-.088.395l-.318.906.213.242a.8.8 0 0 1 .114.175l2 4.25a.75.75 0 1 1-1.357.638l-1.956-4.154-1.68-1.921A.75.75 0 0 1 6 8.96l.138-2.613-.435.489-.464 2.786a.75.75 0 1 1-1.48-.246l.5-3a.75.75 0 0 1 .18-.375l2-2.25Z" />
                                            <path
                                                d="M6.25 11.745v-1.418l1.204 1.375.261.524a.8.8 0 0 1-.12.231l-2.5 3.25a.75.75 0 1 1-1.19-.914zm4.22-4.215-.494-.494.205-1.843.006-.067 1.124 1.124h1.44a.75.75 0 0 1 0 1.5H11a.75.75 0 0 1-.531-.22Z" />
                                        </svg>
                                        <a href="{{ route('caminata') }}" :active="request() - > routeIs('caminata')"
                                            class="ml-2" wire:navigate>Caminata</a>
                                    </h1>
                                    <h1
                                        class="flex cursor-pointer p-2 rounded-md mt-1 hover:bg-black hover:text-white
                                    ">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 22V16.9612C14 16.3537 13.7238 15.7791 13.2494 15.3995L11.5 14M11.5 14L13 7.5M11.5 14L10 13M13 7.5L11 7M13 7.5L15.0426 10.7681C15.3345 11.2352 15.8062 11.5612 16.3463 11.6693L18 12M10 13L11 7M10 13L9.40011 16.2994C9.18673 17.473 8.00015 18.2 6.85767 17.8573L4 17M11 7L8.10557 8.44721C7.428 8.786 7 9.47852 7 10.2361V12M14.5 3.5C14.5 4.05228 14.0523 4.5 13.5 4.5C12.9477 4.5 12.5 4.05228 12.5 3.5C12.5 2.94772 12.9477 2.5 13.5 2.5C14.0523 2.5 14.5 2.94772 14.5 3.5Z">
                                            </path>
                                        </svg>
                                        <a href="{{ route('carrera') }}" :active="request() - > routeIs('carrera')"
                                            class="ml-2" wire:navigate>Carrera</a>
                                    </h1>

                                </div>

                            </li>

                            <li
                                class="flex w-full justify-between text-black hover:text-black text-xl cursor-pointer items-center mb-6">

                                <div
                                    class="p-2.5 mt-0 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-black text-black
                                hover:text-white">
                                    <i class="bi bi-currency-dollar"></i>
                                    <div class="flex justify-between w-full items-center">

                                        <h1 class="cursor-pointer px-2 text-xl rounded-md mt-1 hover:text-white">
                                            <a href="{{ route('tasaDolar') }}"
                                                :active="request() - > routeIs('tasaDolar')" wire:navigate>Tasa del
                                                Dolar</a></span>
                                        </h1>
                                    </div>
                                </div>

                            </li>
                            <li
                                class="flex w-full justify-between text-black hover:text-black text-xl cursor-pointer items-center mb-6">

                                <div
                                    class="p-2.5 mt-0 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-black text-black hover:text-white">
                                    <svg class="h-8 w-8 text-black hover:text-white" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M15 4l6 2v5h-3v8a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1v-8h-3v-5l6 -2a3 3 0 0 0 6 0" />
                                    </svg>
                                    <div class="flex justify-between w-full items-center">

                                        <h1 class="cursor-pointer px-2 text-xl rounded-md mt-1 hover:text-white">
                                            <a href="{{ route('franelas') }}"
                                                :active="request() - > routeIs('franelas')"
                                                wire:navigate>Franelas</a></span>
                                        </h1>
                                    </div>
                                </div>

                            </li>
                        </ul>

                    </div>

                </div>
                {{-- 600px --}}
                <div class="min-h-screen w-64 z-40 absolute bg-white shadow md:h-full flex-col justify-between sm:hidden transition duration-150 ease-in-out"
                    id="mobile-nav">

                    <button aria-label="toggle sidebar" id="openSideBar"
                        class="h-10 w-10 bg-gray-800 absolute right-0 mt-16 -mr-10 flex items-center shadow rounded-tr rounded-br justify-center cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 rounded focus:ring-gray-800"
                        onclick="sidebarHandler(true)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-adjustments"
                            width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <circle cx="6" cy="10" r="2" />
                            <line x1="6" y1="4" x2="6" y2="8" />
                            <line x1="6" y1="12" x2="6" y2="20" />
                            <circle cx="12" cy="16" r="2" />
                            <line x1="12" y1="4" x2="12" y2="14" />
                            <line x1="12" y1="18" x2="12" y2="20" />
                            <circle cx="18" cy="7" r="2" />
                            <line x1="18" y1="4" x2="18" y2="5" />
                            <line x1="18" y1="9" x2="18" y2="20" />
                        </svg>
                    </button>
                    <button aria-label="Close sidebar" id="closeSideBar"
                        class="hidden h-10 w-10 bg-gray-800 absolute right-0 mt-16 -mr-10 flex items-center shadow rounded-tr rounded-br justify-center cursor-pointer text-white"
                        onclick="sidebarHandler(false)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20"
                            height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                    <div class="px-8">
                        <div class="h-16 w-full flex items-center">
                            LOGO
                        </div>
                        <ul class="mt-12">
                            <li
                                class="flex w-full justify-between text-gray-300 hover:text-gray-500 cursor-pointer items-center mb-6">
                                <a href="javascript:void(0)"
                                    class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">

                                    <span class="text-sm ml-2">Dashboard</span>
                                </a>

                            </li>
                            <li
                                class=" w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6 ">

                                <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white"
                                    onclick="dropdownA()">
                                    <i class="bi bi-chat-left-text-fill"></i>
                                    <div class="flex justify-between w-full items-center">
                                        <span class="text-[15px] ml-4 text-gray-200 font-bold">Chatbox</span>
                                        <span class="text-sm rotate-180" id="arrowA">
                                            <i class="bi bi-chevron-down"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold"
                                    id="submenuA">
                                    <h1 class="cursor-pointer p-2 hover:bg-blue-600 rounded-md mt-1">
                                        Social
                                    </h1>
                                    <h1 class="cursor-pointer p-2 hover:bg-blue-600 rounded-md mt-1">
                                        Personal
                                    </h1>
                                    <h1 class="cursor-pointer p-2 hover:bg-blue-600 rounded-md mt-1">
                                        Friends
                                    </h1>
                                </div>

                            </li>
                            <li
                                class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                                <a href="javascript:void(0)"
                                    class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">

                                    <span class="text-sm ml-2">Performance</span>
                                </a>
                            </li>
                            <li
                                class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                                <a href="javascript:void(0)"
                                    class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">

                                    <span class="text-sm ml-2">Deliverables</span>
                                </a>
                            </li>
                            <li
                                class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                                <a href="javascript:void(0)"
                                    class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">

                                    <span class="text-sm ml-2">Invoices</span>
                                </a>

                            </li>
                            <li
                                class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-6">
                                <a href="javascript:void(0)"
                                    class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">

                                    <span class="text-sm ml-2">Inventory</span>
                                </a>
                            </li>
                            <li
                                class="flex w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center">
                                <a href="javascript:void(0)"
                                    class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">

                                    <span class="text-sm ml-2">Settings</span>
                                </a>
                            </li>
                        </ul>
                        <div class="flex justify-center mt-48 mb-4 w-full">
                            <div class="relative">
                                <div class="text-gray-300 absolute ml-4 inset-0 m-auto w-4 h-4">

                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="py-0 h-64 md:w-4/5 xl:w-full mx-auto px-0  ">

                    @if (isset($header))
                        <header class="shadow" style="background-color: #ca872a45;">
                            <div class="max-w-7xl mx-full py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endif
                    <main>
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </dh-component>
    </div>

</body>
<script>
    var sideBar = document.getElementById("mobile-nav");
    var openSidebar = document.getElementById("openSideBar");
    var closeSidebar = document.getElementById("closeSideBar");
    sideBar.style.transform = "translateX(-260px)";

    function sidebarHandler(flag) {
        if (flag) {
            sideBar.style.transform = "translateX(0px)";
            openSidebar.classList.add("hidden");
            closeSidebar.classList.remove("hidden");
        } else {
            sideBar.style.transform = "translateX(-260px)";
            closeSidebar.classList.add("hidden");
            openSidebar.classList.remove("hidden");
        }
    }
</script>
<script type="text/javascript">
    function dropdown1() {
        document.querySelector("#submenu1").classList.toggle("hidden");
        document.querySelector("#arrow1").classList.toggle("rotate-0");
    }
    dropdown1();


    function dropdown2() {
        document.querySelector("#submenu2").classList.toggle("hidden");
        document.querySelector("#arrow2").classList.toggle("rotate-0");
    }
    dropdown2();

    function dropdown3() {
        document.querySelector("#submenu3").classList.toggle("hidden");
        document.querySelector("#arrow3").classList.toggle("rotate-0");
    }
    dropdown3();
    /*  6000px */
    function dropdownA() {
        document.querySelector("#submenuA").classList.toggle("hidden");
        document.querySelector("#arrowA").classList.toggle("rotate-0");
    }
    dropdownA();

    function dropdownB() {
        document.querySelector("#submenuB").classList.toggle("hidden");
        document.querySelector("#arrowB").classList.toggle("rotate-0");
    }
    dropdownB();

    function dropdownC() {
        document.querySelector("#submenuC").classList.toggle("hidden");
        document.querySelector("#arrowC").classList.toggle("rotate-0");
    }
    dropdownC();
</script>

</html>