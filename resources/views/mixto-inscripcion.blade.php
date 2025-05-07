<x-sidebar-layout>

    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight">
            <!-- Enlace a Inicio -->
            <a href="{{ route('dashboard') }}" class="underline">Inicio</a>
            <span class="mx-0 underline">/</span>

            <!-- Enlace a Caminata -->
            <a href="{{ route('mixto') }}"
                class="{{ request()->routeIs('mixto') ? 'text-blue-500 font-bold' : 'underline' }}">
                Mixto
            </a>
            <span class="mx-0 underline">/</span>

            <!-- Enlace a Inscripción, solo si existe el ID -->
            @if (isset($id, $cantidad_caminata, $cantidad_carrera))
                <a href="{{ route('mixto.inscripcion', ['id' => $id, 'cantidad_carrera' => $cantidad_carrera, 'cantidad_caminata' => $cantidad_caminata]) }}"
                    class="{{ request()->routeIs('mixto.inscripcion') ? 'text-blue-500 font-bold underline' : 'underline' }}">
                    Inscripción/ {{ $id }}
                </a>
            @endif
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (isset($id) && !is_null($id))
                @livewire('formulario-inscripcion.formulario-mixto', compact('id', 'cantidad_carrera', 'cantidad_caminata'))
            @endif

        </div>
    </div>
</x-sidebar-layout>
