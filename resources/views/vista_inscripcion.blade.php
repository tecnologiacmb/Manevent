<x-sidebar-layout>

    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight">
            <!-- Enlace a Inicio -->
            <a href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'text-blue-500 font-bold underline' : 'underline' }}">
                Inicio/
            </a>

            <a href="{{ route('incripcion') }}"
                class="{{ request()->routeIs('incripcion') ? 'text-blue-500 font-bold underline' : 'underline' }}">
                Inscripciones/
            </a>
            @if (isset($id))
                <a href="{{ route('incripcion.vista_inscripcion', ['id' => $id]) }}"
                    class="{{ request()->routeIs('incripcion.vista_inscripcion') ? 'text-blue-500 font-bold underline' : 'underline' }}">
                    Detalles
                </a>
            @endif
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (isset($id) && !is_null($id))
                @livewire('vista-inscripcion', ['id' => $id])
            @endif


        </div>
    </div>
</x-sidebar-layout>
