<div>
    <div class="bg-white shadow rounded-lg p-2 mb-4 flex items-center justify-between">
        <h1 class="font-black text-2xl text-gray-800 leading-tight text-normal">
            Lista de Categorias Registradas
        </h1>
        <x-button class="shadow" wire:click="crear">
            Agregar
        </x-button>
    </div>

    <div
        class="relative flex flex-col w-full h-full overflow-scroll text-black bg-white shadow-md rounded-xl bg-clip-border overflow-x-hidden overflow-y-hidden">


        <table class="w-full text-left table-auto min-w-max">
            <thead>
                <tr>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Name
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Edad Minima
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Edad Maxima
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                        </p>
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $post->id }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $post->nombre }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $post->edad_min }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $post->edad_max }}
                            </p>
                        </td>

                        <td class="p-4 border-b border-blue-gray-50 space-x-8">
                            <x-button class="bg-blue-500" wire:click="edit({{ $post->id }})">
                                <i class="bi bi-pencil-square"></i>
                            </x-button>

                            <x-danger-button wire:click="confirm_delete({{ $post->id }})">
                                <i class="bi bi-trash-fill"></i>
                            </x-danger-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $posts->links() }}
        </div>
    </div>

    <form wire:submit="save">
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                Actualizar Post
            </x-slot>

            <x-slot name="content">
                <div class="mb-4">
                    <x-label for="">Nombre</x-label>
                    <x-input class="w-full" wire:model="post_create.nombre" />
                </div>

                <div class="h-28 grid grid-cols-3 gap-4 content-start ">
                    <div class="mb-4">
                        <x-label for="">Edad Minima</x-label>
                        <x-input type="number" class="w-full" wire:model="post_create.edad_min" />
                    </div>

                    <div class="mb-4">
                        <x-label for="">Edad Maxima</x-label>
                        <x-input type="number" class="w-full" wire:model="post_create.edad_max" />
                    </div>
                </div>

            </x-slot>

            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-danger-button class="mr-2" wire:click="$set('open',false)">
                        Cancelar
                    </x-danger-button>

                    <x-button>
                        Agregar
                    </x-button>
                </div>
            </x-slot>
        </x-dialog-modal>
    </form>

    <form wire:submit="update">
        <x-dialog-modal wire:model="open_edit">
            <x-slot name="title">
                Actualizar Post
            </x-slot>

            <x-slot name="content">
                <div class="mb-4">
                    <x-label for="">Nombre</x-label>
                    <x-input class="w-full" wire:model="post_update.nombre" />
                </div>

                <div class="h-28 grid grid-cols-3 gap-4 content-start ">
                    <div class="mb-4">
                        <x-label for="">Edad Minima</x-label>
                        <x-input type="number" class="w-full" wire:model="post_update.edad_min" />
                    </div>

                    <div class="mb-4">
                        <x-label for="">Edad Maxima</x-label>
                        <x-input type="number" class="w-full" wire:model="post_update.edad_max" />
                    </div>
                </div>

            </x-slot>

            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-danger-button class="mr-2" wire:click="$set('open_edit',false)">
                        Cancelar
                    </x-danger-button>

                    <x-button>
                        Agregar
                    </x-button>
                </div>
            </x-slot>
        </x-dialog-modal>
    </form>

</div>
@push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Livewire.on('alert', function() {
                Swal.fire({
                    title: "Éxito!",
                    text: "El registro ha sido exitoso!",
                    icon: "success"
                });
            })
            Livewire.on('alert_update', function() {
                Swal.fire({
                    title: "Éxito!",
                    text: "Los datos han sido actualizados!",
                    icon: "success"
                });
            })
            Livewire.on('alert_delete', post_id => {
                Swal.fire({
                    title: "¿Estas seguro?",
                    text: "¡No podras revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "¿Si, eliminalo!"
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.dispatch('delete',post_id)
                        Swal.fire({
                            title: "Borrado!",
                            text: "Eliminacion exitosa.",
                            icon: "success"
                        });
                    }
                });

            })
        </script>
    @endpush
</div>
