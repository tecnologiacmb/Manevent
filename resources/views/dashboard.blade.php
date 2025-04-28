<x-sidebar-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-16">
        <div class="max-w-7xl px-8 mx-auto sm:px-6 lg:px-16">

            @livewire('dashboar')


        </div>
    </div>
</x-sidebar-layout>
