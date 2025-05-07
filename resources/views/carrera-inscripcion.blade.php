<x-sidebar-layout>

    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight">
            <!-- Enlace a Inicio -->
            <a href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'text-blue-500 font-bold underline' : 'underline' }}">
                Inicio/
            </a>

            <a href="{{ route('carrera') }}"
                class="{{ request()->routeIs('carrera') ? 'text-blue-500 font-bold underline' : 'underline' }}">
                Carrera/
            </a>
            @if (isset($id))
                <a href="{{ route('carrera.inscripcion', ['id' => $id]) }}"
                    class="{{ request()->routeIs('carrera.inscripcion') ? 'text-blue-500 font-bold underline' : 'underline' }}">
                    Inscripción
                </a>
            @endif
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (isset($id) && !is_null($id))
                @livewire('formulario-inscripcion.formulario-carrera', ['id' => $id])
            @endif

        </div>
    </div>
</x-sidebar-layout>
