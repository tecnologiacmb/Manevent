<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight">
            <a href="{{ route('dashboard') }}" class="underline">
                Inicio/
            </a>
            <!-- Barra diagonal y espacio antes de Banco -->
            <a href="{{ route('metodo-pago') }}" :active="request() - > routeIs('metodo-pago')"
                class="{{ request()->routeIs('metodo-pago') ? 'text-blue-500 font-bold' : 'ml-1' }} mx-0 underline ">
                Metodo de pago
            </a>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto m:px-6 lg:px-8">

            {{-- <livewire:administrar.admin-banco-t-pago> --}}
            <livewire:administrar.admin-metodo />

        </div>
    </div>
</x-sidebar-layout>
