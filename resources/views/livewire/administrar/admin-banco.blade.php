<div>
    <div class="bg-white shadow rounded-lg p-2 mb-2 flex items-center justify-between">
        <h1 class="font-black text-2xl text-gray-800 leading-tight text-normal">
            Lista de Bancos Registrados
        </h1>
        <x-button class="shadow" wire:click="crear">
            Agregar
        </x-button>
    </div>
    <div class="bg-white shadow rounded-lg p-2 mb-2 px-8">
        <input type="text" wire:model.live="query" placeholder="Buscar..."
            class="w-2/4 px-8 mt-2 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-200 transition duration-300" />
        <x-button class="ml-6 bg-red-700 hover:bg-slate-300 " wire:click="limpiar()" type="reset">Cancelar</x-button>
    </div>
    <div
        class="relative flex flex-col w-full h-full overflow-scroll text-black bg-white shadow-md rounded-xl bg-clip-border overflow-x-auto overflow-y-hidden">


        <table class="w-full text-center table-auto min-w-max ">
            <thead>
                <tr>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            logo
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            nombre
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Codigo
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            estado
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
                <tr>
                    @foreach ($posts as $post)
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">

                                <img src="data:image/jpeg;base64,{{ base64_encode($post->logo) }}"
                                    alt="Logo de {{ $post->nombre }}" width="90">

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
                                {{ $post->codigo }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $post->estado }}
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

        <form wire:submit="save">
            <x-dialog-modal wire:model="open">
                <x-slot name="title">
                    Actualizar Datos
                </x-slot>

                <x-slot name="content">
                    <div class="mb-4">
                        <x-label for="">Banco</x-label>
                        <x-input class="w-full" wire:model="post_create.nombre" />
                        @error('post_create.nombre')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Codigo</x-label>
                        <x-input type="number" class="w-full" wire:model="post_create.codigo" />
                        @error('post_create.codigo')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">logo</x-label>
                        <x-input type="file" class="w-full" wire:model="post_create.logo" accept="image/*"
                            required />
                    </div>
                    @if ($post_create['logo'])
                        <div>
                            <h4>Vista Previa del Logo:</h4>
                            <img src="{{ $post_create['logo']->temporaryUrl() }}" alt="Vista previa" width="100">
                        </div>
                    @endif
                    <div class="mb-4">
                        <x-label for="">Estado</x-label>
                        <x-select class="w-full" wire:model="post_create.estado">
                            <option value="">Seleccione un Estado</option>
                            <option value="0">Deshabilitado</option>
                            <option value="1">Habilitado</option>
                        </x-select>
                        @error('post_create.estado')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
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

        <form wire:submit.prevent="update"> <!-- Cambiado a prevent para evitar la recarga de la página -->
            <x-dialog-modal wire:model="open_edit">
                <x-slot name="title">
                    Actualizar Post
                </x-slot>

                <x-slot name="content">
                    <div class="mb-4">
                        <x-label for="">Banco</x-label>
                        <x-input class="w-full" wire:model="post_update.nombre" /> <!-- Asegúrate que el campo existe -->
                    </div>
                    <div class="mb-4">
                        <x-label for="">Código</x-label>
                        <x-input type="number" class="w-full" wire:model="post_update.codigo" />
                    </div>
                    <div class="mb-4">
                        <x-label for="">Logo</x-label>
                        <x-input type="file" class="w-full" wire:model="post_update.logo" accept="image/*"
                            required />
                    </div>
                    @if ($post_update['logo'])
                        <!-- Asegúrate de que esto apunta correctamente -->
                        <div>
                            <h4>Vista Previa del Logo:</h4>
                            <img src="{{ $post_update['logo']->temporaryUrl() }}" alt="Vista previa" width="100">
                        </div>
                    @endif
                    <div class="mb-4">
                        <x-label for="">Estado</x-label>
                        <x-select class="w-full" wire:model="post_update.estado">
                            <option value="">Seleccione un Estado</option>
                            <option value="0">Deshabilitado</option>
                            <option value="1">Habilitado</option>
                        </x-select>
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <div class="flex justify-end">
                        <x-danger-button class="mr-2" wire:click="$set('open_edit',false)">
                            Cancelar
                        </x-danger-button>

                        <x-button>
                            Actualizar
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

                        Livewire.dispatch('delete', post_id)
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
