<x-sidebar-layout>

    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight">
            {{ __('Inscripciones/Caminata') }}
        </h2>
    </x-slot>

    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (isset($id) && !is_null($id))
                @livewire('vista-inscripcion', ['id' => $id])
            @endif


        </div>
    </div>
</x-sidebar-layout>
