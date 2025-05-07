<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight">
            <a href="{{ route('dashboard') }}" class="underline">
                Inicio/
            </a>
            <!-- Barra diagonal y espacio antes de Banco -->
            <a href="{{ route('incripcion') }}" :active="request() - > routeIs('incripcion')"
                class="{{ request()->routeIs('incripcion') ? 'text-blue-500 font-bold' : 'ml-1' }} mx-0 underline capitalize">
                incripciones
            </a>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                @livewire('inscritos')

        </div>
    </div>
</x-sidebar-layout>
