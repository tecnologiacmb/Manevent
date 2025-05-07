<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight">
            <a href="{{ route('dashboard') }}" class="underline">
                Inicio/
            </a>
            <!-- Barra diagonal y espacio antes de Banco -->
            <a href="{{ route('mixto') }}" :active="request() - > routeIs('mixto')"
                class="{{ request()->routeIs('mixto') ? 'text-blue-500 font-bold' : 'ml-1' }} mx-0 underline capitalize">
                mixto
            </a>

        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:Inscripciones.inscrip-mixto />

        </div>
    </div>
</x-sidebar-layout>
