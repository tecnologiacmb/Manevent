<div>
    <div class="w-full max-[500px]:w-full mb-2">
        <div
            class="flex group w-full h-24 rounded-lg bg-white shadow transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000] justify-between">
            <div>
                <img src="{{ asset('storage/image/grupo.png') }}" alt="Imagen de dolar almacenada en storage"
                    class="pt-8 group-hover:opacity-100 absolute left-[8%] top-[40%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
            </div>
            <div>
                <p class="text-center text-black text-2xl pt-8 group-hover:text-green-800">Grupos Registrados
                </p>
            </div>
            <div>
                <x-button
                    class=" absolute right-[8%] top-[50%] translate-y-[-50%] shadow hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300"
                    wire:click="crear">
                    Registrar
                </x-button>
            </div>
        </div>
    </div>
    <div
        class="relative flex flex-col w-full h-full overflow-scroll text-black bg-white shadow-md rounded-xl bg-clip-border overflow-x-hidden overflow-y-hidden">
        <div class="p-4 px-8 mb-2 flex items-center justify-between ">

            <input type="text" wire:model.live="query" placeholder="Buscar..."
                class="w-1/2 px-4 mt-2 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-200 transition duration-300 " />
            <x-select wire:model.live="RecorridoId" class="mr-8 mt-2 w-1/4">
                <option value="">Todos los Grupos</option>
                @foreach ($recorridos as $recorrido)
                    <option value="{{ $recorrido->id }}">{{ $recorrido->nombre }}</option>
                @endforeach
            </x-select>
            <div>
                <x-danger-button class="mr-8 mt-1" wire:click="limpiar()" type="reset">Cancelar</x-danger-button>

            </div>

        </div>

        <table class="w-full text-center table-auto min-w-max">
            <thead>
                <tr>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Tipo
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Nombre
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Participantes
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Costo $
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Costo Bs
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Estado
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Acciones
                        </p>
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($posts as $post)
                    @foreach ($recorridos as $recorrido)
                        @if ($post->recorrido_id == $recorrido->id)
                            <tr>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                        {{ $recorrido->nombre }}
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
                                        {{ $post->cantidad }}
                                    </p>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                        {{ $post->precio }} $
                                    </p>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                        {{ $this->calculo($post->precio) }} Bs
                                    </p>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <p
                                        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                        {{ $post->estado }}
                                    </p>
                                </td>
                                <td class="p-4 border-b border-blue-gray-50">
                                    <x-button
                                        class="bg-blue-500 hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300"
                                        wire:click="edit({{ $post->id }})">
                                        <i class="bi bi-pencil-square"></i>
                                    </x-button>

                                    <x-danger-button wire:click="confirm_delete({{ $post->id }})">
                                        <i class="bi bi-trash-fill"></i>
                                    </x-danger-button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $posts->links() }}
        </div>
    </div>
    <form wire:submit="seve">
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                Registrar
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label for="">Categoria </x-label>
                    <x-select class="w-full" wire:model="post_create.recorrido_id">
                        <option value="">Seleccione una categoria</option>
                        @foreach ($recorridos as $post)
                            <option value="{{ $post->id }}">
                                {{ $post->nombre }}</option>
                        @endforeach
                    </x-select>
                    @error('post_create.recorrido_id')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">Nombre</x-label>
                    <x-input class="w-full" wire:model="post_create.nombre" />
                    @error('post_create.nombre')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="h-28 grid grid-cols-3 gap-4 content-start ">
                    <div class="mb-4">
                        <x-label for="">Costo $</x-label>
                        <x-input class="w-full" type="number" step="0.01" wire:model="post_create.precio" />
                        @error('post_create.precio')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Valor</x-label>
                        <x-input class="w-full" type="number" wire:model="post_create.cantidad" />
                        @error('post_create.cantidad')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
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
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-danger-button class="mr-2" wire:click="$set('open',false)">
                        Cancelar
                    </x-danger-button>
                    <x-button wire:click="validar1()">
                        Registrar
                    </x-button>
                </div>
            </x-slot>
        </x-dialog-modal>
    </form>
    <form wire:submit="update">
        <x-dialog-modal wire:model="open_edit">
            <x-slot name="title">
                Actualizar
            </x-slot>

            <x-slot name="content">
                <div class="mb-4">
                    <x-label for="">Categoria </x-label>
                    <x-select class="w-full" wire:model="post_update.recorrido_id">
                        <option value="">Seleccione una categoria</option>
                        @foreach ($recorridos as $post)
                            <option value="{{ $post->id }}">
                                {{ $post->nombre }}</option>
                        @endforeach
                    </x-select>
                    @error('post_update.recorrido_id')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">Nombre</x-label>
                    <x-input class="w-full" wire:model="post_update.nombre" />
                    @error('post_update.nombre')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="h-28 grid grid-cols-3 gap-4 content-start ">
                    <div class="mb-4">
                        <x-label for="">Costo $</x-label>
                        <x-input class="w-full" type="number" step="0.01" wire:model="post_update.precio" />
                        @error('post_update.precio')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="">Valor</x-label>
                        <x-input class="w-full" type="number" wire:model="post_update.cantidad" />
                        @error('post_update.cantidad')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="">Estado</x-label>
                        <x-select class="w-full" wire:model="post_update.estado">
                            <option value="">Seleccione un Estado</option>
                            <option value="0">Deshabilitado</option>
                            <option value="1">Habilitado</option>
                        </x-select>
                        @error('post_update.estado')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
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
