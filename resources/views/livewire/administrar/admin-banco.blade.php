<div>
    <div class="w-full max-[500px]:w-full mb-2">
        <div
            class="flex group w-full h-24 rounded-lg bg-white shadow transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000] justify-between">
            <div>
                <img src="{{ asset('storage/image/banco.png') }}" alt="Imagen de dolar almacenada en storage"
                    class="pt-8 group-hover:opacity-100 absolute left-[8%] top-[40%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
            </div>
            <div>
                <p class="text-center  text-black text-2xl pt-8 group-hover:text-green-800">Bancos Registrados</p>
            </div>

            <div>
                <x-button
                    class=" absolute right-[8%] top-[50%] translate-y-[-50%] shadow hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300"
                    wire:click="crear">
                    Registar
                </x-button>
            </div>
        </div>
    </div>

    <div
        class="relative flex flex-col w-full h-full overflow-scroll text-black bg-white shadow-md rounded-xl bg-clip-border overflow-x-auto overflow-y-hidden">
        <div class="p-4 pl-2 mb-2 flex items-center justify-between ">
            <input type="text" wire:model.live="query" placeholder="Buscar..."
                class="w-9/12 px-4 mt-2 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-200 transition duration-300 ml-4" />
            <div>
                <x-danger-button class="mr-16 mt-1" wire:click="limpiar()" type="reset">Limpiar</x-danger-button>

            </div>
        </div>
        <table class=" w-full text-center table-auto min-w-max ">
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
                            Opciones
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

                        <td class="p-4 border-b border-blue-gray-50">
                            <x-button class="bg-blue-500 hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300"
                                wire:click="edit({{ $post->id }})">
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
        <div class="text-black font-bold text-xl">
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

                        <x-button wire:click="validar1()">
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
                        <x-input class="w-full" wire:model="post_update.nombre" />
                        <!-- Asegúrate que el campo existe -->
                    </div>
                    <div class="mb-4">
                        <x-label for="">Código</x-label>
                        <x-input type="number" class="w-full" wire:model="post_update.codigo" />
                    </div>
                    <div class="mb-4">
                        <x-label for="">Logo</x-label>
                        <x-input type="file" class="w-full" wire:model="post_update.logo" />
                    </div>

                    <!-- Asegúrate de que esto apunta correctamente -->
                    <img src="{{ $this->logoUrl }}" alt="Logo" />
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

                        <x-button wire:click="validar2()">
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
