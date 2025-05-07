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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->


    @livewireStyles

</head>

<body class="font-sans antialiased">
    <style>
        .sidebar {
            position: sticky;
            /* O usa sticky si prefieres */
            top: 0;
            /* Mantén en la parte superior */
            left: 0;
            /* Alinea al lado izquierdo */
            width: 260px;
            /* Ancho deseado */
            height: 100vh;
            /* Altura completa de la ventana */
            overflow-y: auto;
            /* Scrolling interno si es necesario */
        }

        .main-content {
            margin-left: 10px;
            /* Debería ser igual al ancho del sidebar */
        }
    </style>
    <div class="w-full h-full bg-slate-100">
        <dh-component>
            <div class="flex flex-no-wrap ">

                <aside
                    class="sidebar min-h-screen absolute sm:relative shadow flex-col justify-between hidden sm:flex bg-slate-200">

                    <div class="px-6 py-4">

                        <div class="w-full flex justify-center text-black text-xl ">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())

                                <button
                                    class="flex text-sm border-transparent rounded-full focus:outline-none focus:border-gray-300 transition mt-2 relative duration-300 cursor-pointer hover:translate-y-[3px] ">
                                    @if (Auth::user()->profile_photo_path)
                                        <img class="h-24 w-24 rounded-full object-cover"
                                            src="/storage/{{ Auth::user()->profile_photo_path }}"
                                            alt="{{ Auth::user()->name }}" />
                                    @else
                                        <div class="h-24 w-24 rounded-full flex items-center justify-center text-white text-4xl"
                                            style="background-color: #0a0a0a;"> <!-- Color gris por ejemplo -->
                                            {{-- Mostrar iniciales --}}
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(strrchr(Auth::user()->name, ' '), 1, 1)) }}
                                        </div>
                                    @endif
                                </button>
                            @endif
                        </div>
                        <div class="text-lg text-center mt-8 capitalize">Sistema de eventos</div>
                        <hr class="border-t-gray-800 w-full">
                        <ul class="py-16">
                            <li class="flex w-full justify-between text-black cursor-pointer items-center mb-2">

                                <a href="{{ route('dashboard') }}" :active="request() - > routeIs('dashboard')"
                                    class="ml-2">
                                    <div
                                        class="p-2.5 mt-0 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-black text-black  hover:text-white">
                                        <i class="bi bi-house-fill"></i>
                                        <div class="flex justify-between w-full items-center">
                                            <h1 class="cursor-pointer px-3 text-xl rounded-md mt-1 hover:text-white">
                                                Inicio
                                            </h1>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="flex w-full justify-between text-black cursor-pointer items-center mb-2">
                                <div
                                    class="p-2.5 mt-0 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-black text-black  hover:text-white">
                                    <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m7.171 12.906-2.153 6.411 2.672-.89 1.568 2.34 1.825-5.183m5.73-2.678 2.154 6.411-2.673-.89-1.568 2.34-1.825-5.183M9.165 4.3c.58.068 1.153-.17 1.515-.628a1.681 1.681 0 0 1 2.64 0 1.68 1.68 0 0 0 1.515.628 1.681 1.681 0 0 1 1.866 1.866c-.068.58.17 1.154.628 1.516a1.681 1.681 0 0 1 0 2.639 1.682 1.682 0 0 0-.628 1.515 1.681 1.681 0 0 1-1.866 1.866 1.681 1.681 0 0 0-1.516.628 1.681 1.681 0 0 1-2.639 0 1.681 1.681 0 0 0-1.515-.628 1.681 1.681 0 0 1-1.867-1.866 1.681 1.681 0 0 0-.627-1.515 1.681 1.681 0 0 1 0-2.64c.458-.361.696-.935.627-1.515A1.681 1.681 0 0 1 9.165 4.3ZM14 9a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                                    </svg>

                                    <div class="flex justify-between w-full items-center">
                                        <h1 class="cursor-pointer px-3 text-xl rounded-md mt-1 hover:text-white">
                                            <a href="{{ route('evento') }}" :active="request() - > routeIs('evento')"
                                                class="ml-2">Eventos</a>
                                        </h1>
                                    </div>
                                </div>

                            </li>
                            @can('super-admin')
                                <li
                                    class="w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-2">
                                    <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-black text-black hover:text-white "
                                        onclick="dropdown1()">
                                        <i class="bi bi-gear-fill"></i>
                                        <div class="flex justify-between w-full items-center ">
                                            <h1 class="cursor-pointer px-3 text-xl rounded-md mt-1 hover:text-white">
                                                Administrador
                                            </h1>
                                            <span class="text-sm rotate-180" id="arrow1">
                                                <i class="bi bi-chevron-down"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div hidden class="text-left text-sm mt-2 w-4/5 mx-auto text-black font-bold"
                                        id="submenu1">
                                        <a href="{{ route('banco') }}" :active="request() - > routeIs('banco')">
                                            <h1 class="cursor-pointer p-2 hover:bg-black rounded-md mt-1  hover:text-white">
                                                <i class="bi bi-bank mr-2"></i>
                                                Banco
                                            </h1>
                                        </a>
                                        <a href="{{ route('metodo-pago') }}"
                                            :active="request() - > routeIs('metodo-pago')">
                                            <h1 class="cursor-pointer p-2 hover:bg-black rounded-md mt-1 hover:text-white">
                                                <i class="bi bi-cash-coin mr-2"></i>
                                                Metodo Pago
                                            </h1>
                                        </a>
                                        <a href="{{ route('categoria') }}" :active="request() - > routeIs('categoria')">
                                            <h1 class="cursor-pointer p-2 hover:bg-black rounded-md mt-1 hover:text-white">
                                                <i class="bi bi-tags-fill mr-2"></i>Categoria
                                            </h1>
                                        </a>
                                        <a href="{{ route('grupo') }}" :active="request() - > routeIs('grupo')">
                                            <h1 class="cursor-pointer p-2 hover:bg-black rounded-md mt-1 hover:text-white">
                                                <i class="bi bi-collection-fill mr-2"></i>
                                                Grupo
                                            </h1>
                                        </a>

                                    </div>
                                </li>
                            @endcan
                            <li
                                class="w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-2">
                                <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-black text-black hover:text-white"
                                    onclick="dropdown2()">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-6">
                                        <path
                                            d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                        <path
                                            d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                    </svg>

                                    <div class="flex justify-between w-full items-center">
                                        <h1 class="cursor-pointer px-3 text-xl rounded-md mt-1 hover:text-white">
                                            Registrar
                                        </h1>
                                        <span class="text-sm rotate-180" id="arrow2">
                                            <i class="bi bi-chevron-down"></i>
                                        </span>
                                    </div>
                                </div>
                                <div hidden class="text-left text-sm mt-2 w-4/5 mx-auto text-black font-bold"
                                    id="submenu2">
                                    <a href="{{ route('caminata') }}" :active="request() - > routeIs('caminata')">
                                        <h1
                                            class="flex cursor-pointer p-2 hover:bg-black rounded-md mt-1 hover:text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-person-walking mr-2"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M9.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0M6.44 3.752A.75.75 0 0 1 7 3.5h1.445c.742 0 1.32.643 1.243 1.38l-.43 4.083a1.8 1.8 0 0 1-.088.395l-.318.906.213.242a.8.8 0 0 1 .114.175l2 4.25a.75.75 0 1 1-1.357.638l-1.956-4.154-1.68-1.921A.75.75 0 0 1 6 8.96l.138-2.613-.435.489-.464 2.786a.75.75 0 1 1-1.48-.246l.5-3a.75.75 0 0 1 .18-.375l2-2.25Z" />
                                                <path
                                                    d="M6.25 11.745v-1.418l1.204 1.375.261.524a.8.8 0 0 1-.12.231l-2.5 3.25a.75.75 0 1 1-1.19-.914zm4.22-4.215-.494-.494.205-1.843.006-.067 1.124 1.124h1.44a.75.75 0 0 1 0 1.5H11a.75.75 0 0 1-.531-.22Z" />
                                            </svg>
                                            Caminata
                                        </h1>
                                    </a>
                                    <a href="{{ route('carrera') }}" :active="request() - > routeIs('carrera')">
                                        <h1
                                            class="flex cursor-pointer p-2 rounded-md mt-1 hover:bg-black hover:text-white">
                                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 22V16.9612C14 16.3537 13.7238 15.7791 13.2494 15.3995L11.5 14M11.5 14L13 7.5M11.5 14L10 13M13 7.5L11 7M13 7.5L15.0426 10.7681C15.3345 11.2352 15.8062 11.5612 16.3463 11.6693L18 12M10 13L11 7M10 13L9.40011 16.2994C9.18673 17.473 8.00015 18.2 6.85767 17.8573L4 17M11 7L8.10557 8.44721C7.428 8.786 7 9.47852 7 10.2361V12M14.5 3.5C14.5 4.05228 14.0523 4.5 13.5 4.5C12.9477 4.5 12.5 4.05228 12.5 3.5C12.5 2.94772 12.9477 2.5 13.5 2.5C14.0523 2.5 14.5 2.94772 14.5 3.5Z">
                                                </path>
                                            </svg>
                                            Carrera
                                        </h1>
                                    </a>
                                    <a href="{{ route('mixto') }}" :active="request() - > routeIs('mixto')">
                                        <h1
                                            class="flex cursor-pointer p-2 rounded-md mt-1 hover:bg-black hover:text-white  fill-[#0c0101] hover:fill-white">
                                            <svg class="w-[24px] h-[24px] mr-2" viewBox="0 0 640 512"
                                                xmlns="http://www.w3.org/2000/svg">

                                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path
                                                    d="M72 88a56 56 0 1 1 112 0A56 56 0 1 1 72 88zM64 245.7C54 256.9 48 271.8 48 288s6 31.1 16 42.3V245.7zm144.4-49.3C178.7 222.7 160 261.2 160 304c0 34.3 12 65.8 32 90.5V416c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V389.2C26.2 371.2 0 332.7 0 288c0-61.9 50.1-112 112-112h32c24 0 46.2 7.5 64.4 20.3zM448 416V394.5c20-24.7 32-56.2 32-90.5c0-42.8-18.7-81.3-48.4-107.7C449.8 183.5 472 176 496 176h32c61.9 0 112 50.1 112 112c0 44.7-26.2 83.2-64 101.2V416c0 17.7-14.3 32-32 32H480c-17.7 0-32-14.3-32-32zm8-328a56 56 0 1 1 112 0A56 56 0 1 1 456 88zM576 245.7v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM320 32a64 64 0 1 1 0 128 64 64 0 1 1 0-128zM240 304c0 16.2 6 31 16 42.3V261.7c-10 11.3-16 26.1-16 42.3zm144-42.3v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM448 304c0 44.7-26.2 83.2-64 101.2V448c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V405.2c-37.8-18-64-56.5-64-101.2c0-61.9 50.1-112 112-112h32c61.9 0 112 50.1 112 112z">
                                                </path>

                                            </svg>
                                            Mixto
                                        </h1>
                                    </a>
                                </div>
                            </li>
                            <li
                                class="w-full justify-between text-gray-400 hover:text-gray-300 cursor-pointer items-center mb-2">
                                <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-black text-black hover:text-white"
                                    onclick="dropdown3()">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-6">
                                        <path
                                            d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                                        <path fill-rule="evenodd"
                                            d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z"
                                            clip-rule="evenodd" />
                                    </svg>

                                    <div class="flex justify-between w-full items-center">
                                        <h1 class="cursor-pointer px-3 text-xl rounded-md mt-1 hover:text-white">
                                            Registros
                                        </h1>
                                        <span class="text-sm rotate-180" id="arrow3">
                                            <i class="bi bi-chevron-down"></i>
                                        </span>
                                    </div>
                                </div>
                                <div hidden class="text-left text-md mt-2 w-4/5 mx-auto text-black font-bold"
                                    id="submenu3">
                                    <a href="{{ route('vista_usuarios') }}"
                                        :active="request() - > routeIs('vista_usuarios')">
                                        <h1
                                            class="flex cursor-pointer p-2 rounded-md mt-1 hover:bg-black hover:text-white  fill-[#0c0101] hover:fill-white">
                                            <i class="bi bi-person-lines-fill mr-2"></i>

                                            Participantes
                                        </h1>
                                    </a>
                                    <a href="{{ route('incripcion') }}"
                                        :active="request() - > routeIs('incripcion')">
                                        <h1
                                            class="flex cursor-pointer p-2 rounded-md mt-1 hover:bg-black hover:text-white  fill-[#0c0101] hover:fill-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="size-6 mr-2">
                                                <path fill-rule="evenodd"
                                                    d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"
                                                    clip-rule="evenodd" />
                                                <path fill-rule="evenodd"
                                                    d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Inscripcion
                                        </h1>
                                    </a>
                                    <a href="{{ route('franelas') }}" :active="request() - > routeIs('franelas')">
                                        <h1
                                            class="flex cursor-pointer p-2 rounded-md mt-1 hover:bg-black hover:text-white  fill-[#0c0101] hover:fill-white">
                                            <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" />
                                                <path
                                                    d="M15 4l6 2v5h-3v8a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1v-8h-3v-5l6 -2a3 3 0 0 0 6 0" />
                                            </svg>
                                            Franelas
                                        </h1>
                                    </a>
                                    <a href="{{ route('registro_usuario') }}"
                                        :active="request() - > routeIs('registro_usuario')">
                                        <h1
                                            class="flex cursor-pointer p-2 rounded-md mt-1 hover:bg-black hover:text-white  fill-[#0c0101] hover:fill-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="size-6 mr-2">
                                                <path
                                                    d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
                                            </svg>
                                            Usuarios
                                        </h1>
                                    </a>
                                </div>
                            </li>
                            <li class="flex w-full justify-between text-black cursor-pointer items-center mb-2">
                                <a href="{{ route('reporte') }}" :active="request() - > routeIs('reporte')">
                                    <div
                                        class="mr-2 p-2.5 mt-0 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-black text-black  hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor" class="size-6">
                                            <path
                                                d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                                            <path
                                                d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                                        </svg>

                                        <div class="flex justify-between w-full items-center">
                                            <h1 class="cursor-pointer px-3 text-xl rounded-md mt-1 hover:text-white">
                                                Reportes
                                            </h1>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li
                                class="flex w-full justify-between text-black hover:text-black text-xl cursor-pointer items-center mb-2">
                                <a href="{{ route('tasaDolar') }}" :active="request() - > routeIs('tasaDolar')">
                                    <div
                                        class="mr-2 p-2.5 mt-0 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-black text-black hover:text-white">
                                        <i class="bi bi-currency-dollar"></i>
                                        <div class="flex justify-between w-full items-center">
                                            <h1 class="cursor-pointer px-2 text-xl rounded-md mt-1 hover:text-white">
                                                Tasa del
                                                Dolar</span>
                                            </h1>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </aside>

                <div class="flex-1">
                    @if (isset($header))
                        <header class="shadow bg-slate-200 h-16">
                            <div class="max-w-7xl mx-auto flex justify-between items-center py-3 px-4 sm:px-6 lg:px-8">
                                <div>
                                    {{ $header }}
                                </div>
                                <div class="ms-3 relative">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">

                                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                                <x-button
                                                    class="flex text-sm border-2 border-transparent  capitalize rounded-full focus:outline-none focus:border-gray-300 transition">
                                                    {{ Auth::user()->name }}
                                                </x-button>
                                            @else
                                                <span class="inline-flex rounded-md">
                                                    <button type="button"
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                        {{ Auth::user()->name }}

                                                        <svg class="ms-2 -me-0.5 h-4 w-4"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                        </svg>
                                                    </button>
                                                </span>
                                            @endif
                                        </x-slot>

                                        <x-slot name="content">
                                            <!-- Account Management -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Manage Account') }}
                                            </div>

                                            <x-dropdown-link href="{{ route('profile.show') }}">
                                                {{ __('Profile') }}
                                            </x-dropdown-link>

                                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                                    {{ __('API Tokens') }}
                                                </x-dropdown-link>
                                            @endif

                                            <div class="border-t border-gray-200"></div>

                                            <!-- Authentication -->
                                            <form method="POST" action="{{ route('logout') }}" x-data>
                                                @csrf

                                                <x-dropdown-link href="{{ route('logout') }}"
                                                    @click.prevent="$root.submit();">
                                                    {{ __('Log Out') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </div>
                        </header>
                    @endif
                    <main class="main-content">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </dh-component>
    </div>
    @stack('modals')

    @livewireScripts

    @stack('js')

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
        document.querySelector("#submenu1").classList.toggle("block");
        document.querySelector("#arrow1").classList.toggle("rotate-0");
    }

    function openSidebar() {
        document.querySelector(".sidebar").classList.toggle("hidden");
    }

    function dropdown2() {
        document.querySelector("#submenu2").classList.toggle("block");
        document.querySelector("#arrow2").classList.toggle("rotate-0");
    }

    function dropdown3() {
        document.querySelector("#submenu3").classList.toggle("block");
        document.querySelector("#arrow3").classList.toggle("rotate-0");
    }
</script>

</html>
