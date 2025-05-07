<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight">
            <a href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'text-blue-500 font-bold underline' : 'underline' }}">
                Inicio/
            </a>
            <a href="{{ route('caminata') }}"
                class="{{ request()->routeIs('caminata') ? 'text-blue-500 font-bold underline' : 'underline' }}">
                Caminata/
            </a>
            @if (isset($id))
                <a href="{{ route('caminata.inscripcion', ['id' => $id]) }}"
                    class="{{ request()->routeIs('caminata.inscripcion') ? 'text-blue-500 font-bold underline' : 'underline' }}">
                    Inscripción
                </a>
            @endif
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (isset($id))
                @livewire('formulario-inscripcion.formulario-caminata', ['id' => $id])
            @endif

        </div>
    </div>
</x-sidebar-layout>
