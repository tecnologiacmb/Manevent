<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight">
            <a href="{{ route('dashboard') }}" class="underline">
                Inicio/
            </a>
            <!-- Barra diagonal y espacio antes de Banco -->
            <a href="{{ route('caminata') }}" :active="request() - > routeIs('caminata')"
                class="{{ request()->routeIs('caminata') ? 'text-blue-500 font-bold' : 'ml-1' }} mx-0 underline capitalize">
                caminata
            </a>

        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <livewire:Inscripciones.inscrip-caminata />
        </div>
    </div>
</x-sidebar-layout>
