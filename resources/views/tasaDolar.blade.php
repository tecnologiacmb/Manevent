<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight">
            <a href="{{ route('dashboard') }}" class="underline">
                Inicio/
            </a>
            <!-- Barra diagonal y espacio antes de Banco -->
            <a href="{{ route('tasaDolar') }}" :active="request() - > routeIs('tasaDolar')"
                class="{{ request()->routeIs('tasaDolar') ? 'text-blue-500 font-bold' : 'ml-1' }} mx-0 underline capitalize">
                Tasa del Dolar
            </a>

        </h2>
    </x-slot>

    <div class="py-6 rounded-lg ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8  ">
            @livewire("tasa-dolar")
        </div>
    </div>
</x-sidebar-layout>
