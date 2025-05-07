<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight">
            <!-- Barra diagonal y espacio antes de Banco -->
            <a href="{{ route('dashboard') }}" :active="request() - > routeIs('dashboard')"
                class="{{ request()->routeIs('dashboard') ? 'text-blue-500 font-bold' : 'ml-1' }} mx-0 underline capitalize">
                Inicio
            </a>
        </h2>
    </x-slot>

    <div class="py-16">
        <div class="max-w-7xl px-8 mx-auto sm:px-6 lg:px-16">

            @livewire('dashboar')


        </div>
    </div>
</x-sidebar-layout>
