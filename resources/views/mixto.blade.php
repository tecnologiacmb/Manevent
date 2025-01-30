<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight">
            {{ __('Inscricciones/Mixto') }}
        </h2>
    </x-slot>

    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:Inscripciones.inscrip-mixto />

        </div>
    </div>
</x-sidebar-layout>
