<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight">
            {{ __('Inscricciones/Caminata') }}
        </h2>
    </x-slot>

    <div class="py-6 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <livewire:administrar.admin-banco />
        </div>
    </div>
</x-sidebar-layout>
