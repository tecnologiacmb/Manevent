<div>
    <div class="bg-white shadow rounded-lg p-2 mb-4 flex items-center justify-between">
        <h1 class="font-black text-2xl text-gray-800 leading-tight text-normal">
            Lista de los Metodos de Pagos Registrados
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
                            ID
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Banco
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Metodo Pago
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
                @foreach ($banco as $ban)
                    @foreach ($tipo_pago as $pago)
                        @foreach ($posts as $post)
                            @if ($post->banco_id == $ban->id && $post->tipo_pago_id == $pago->id)
                                <tr>
                                    <td class="p-4 border-b border-blue-gray-50">
                                        <p
                                            class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                            {{ $pago->id }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-blue-gray-50">
                                        <p
                                            class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                            {{ $pago->nombre }}
                                        </p>
                                    </td>

                                    <td class="p-4 border-b border-blue-gray-50">
                                        <p
                                            class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                            {{ $ban->nombre }} Bs
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
                            @endif
                        @endforeach
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
                Actualizar Post
            </x-slot>
            <x-slot name="content">
                <div class="mb-4">
                    <x-label for="">Metodo</x-label>
                    <x-select class="w-full" wire:model="post_create.tipo_pago_id"
                        wire:click="changeEvent($event.target.value)">
                        <option value=""> Metodo pago</option>
                        @foreach ($tipo_pago as $pago)
                            <option value="{{ $pago->id }}">{{ $pago->nombre }}</option>
                        @endforeach
                    </x-select>
                    @error('post_create.tipo_pago_id')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    @if ($metodo == 1)
                        <div class="mb-4">
                            <x-label for="">Banco</x-label>
                            <x-select class="w-full" wire:model="post_create.banco_id">
                                <option value="" disabled>Seleccione un Banco</option>
                                @foreach ($banco as $post)
                                    <option value="{{ $post->id }}">{{ $post->nombre }}</option>
                                @endforeach
                            </x-select>
                            @error('post_create.banco_id')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @elseif ($metodo == 2)
                        <div class="mb-4">
                            <x-label for="">N° Cuenta</x-label>
                            <x-input type="number" class="w-full" wire:model="post_create.N°_cuenta" />
                            @error('post_create.N°_cuenta')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <x-label for="">Propietario</x-label>
                            <x-input class="w-full" wire:model="post_create.propietario" />
                            @error('post_create.propietario')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">ABA</x-label>
                            <x-input type="number" class="w-full" wire:model="post_create.ABA" />
                            @error('post_create.ABA')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">SWIT</x-label>
                            <x-input class="w-full" wire:model="post_create.SWIT" />
                            @error('post_create.SWIT')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Correo</x-label>
                            <x-input type="email" class="w-full" wire:model="post_create.correo" />
                            @error('post_create.correo')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Banco</x-label>
                            <x-select class="w-full" wire:model="post_create.banco_id">
                                <option value="" disabled>Seleccione un Banco</option>
                                @foreach ($banco as $post)
                                    <option value="{{ $post->id }}">{{ $post->nombre }}</option>
                                @endforeach
                            </x-select>
                            @error('post_create.banco_id')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @elseif ($metodo == 3)
                        <div class="mb-4">
                            <x-label for="">Cedula</x-label>
                            <x-input type="number" class="w-full" wire:model="post_create.cedula" />
                            @error('post_create.cedula')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Telefono</x-label>
                            <x-input type="number" class="w-full" wire:model="post_create.telefono" />
                            @error('post_create.telefono')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Propietario</x-label>
                            <x-input class="w-full" wire:model="post_create.propietario" />
                            @error('post_create.propietario')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Banco</x-label>
                            <x-select class="w-full" wire:model="post_create.banco_id">
                                <option value="" disabled>Seleccione un Banco</option>
                                @foreach ($banco as $post)
                                    <option value="{{ $post->id }}">{{ $post->nombre }}</option>
                                @endforeach
                            </x-select>
                            @error('post_create.banco_id')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @elseif ($metodo == 4)
                        <div class="mb-4">
                            <x-label for="">N° Cuenta</x-label>
                            <x-input type="number" class="w-full" wire:model="post_create.N°_cuenta" />
                            @error('post_create.N°_cuenta')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Cedula</x-label>
                            <x-input type="number" class="w-full" wire:model="post_create.cedula" />
                            @error('post_create.cedula')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Propietario</x-label>
                            <x-input class="w-full" wire:model="post_create.propietario" />
                            @error('post_create.propietario')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Banco</x-label>
                            <x-select class="w-full" wire:model="post_create.banco_id">
                                <option value="" disabled>Seleccione un Banco</option>
                                @foreach ($banco as $post)
                                    <option value="{{ $post->id }}">{{ $post->nombre }}</option>
                                @endforeach
                            </x-select>
                            @error('post_create.banco_id')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @elseif ($metodo == 5)
                        <div class="mb-4">
                            <x-label for="">Banco</x-label>
                            <x-select class="w-full" wire:model="post_create.banco_id">
                                <option value="">Seleccione un Banco</option>
                                @foreach ($banco as $post)
                                    <option value="{{ $post->id }}">{{ $post->nombre }}</option>
                                @endforeach
                            </x-select>
                            @error('post_create.banco_id')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
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
                    <x-label for="">Metodo</x-label>
                    <x-select class="w-full" wire:model="post_update.tipo_pago_id"
                        wire:click="changeEvent($event.target.value)">
                        <option value="" disabled> Metodo pago</option>

                        @foreach ($tipo_pago as $pago)
                            <option value="{{ $pago->id }}">{{ $pago->nombre }}</option>
                        @endforeach

                    </x-select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    @if ($metodo == 1)
                        <div class="mb-4">
                            <x-label for="">Banco</x-label>
                            <x-select class="w-full" wire:model="post_update.banco_id">
                                <option value="" disabled>Seleccione un Banco</option>

                                @foreach ($banco as $post)
                                    <option value="{{ $post->id }}">{{ $post->nombre }}</option>
                                @endforeach

                            </x-select>
                        </div>
                    @elseif ($metodo == 2)
                        <div class="mb-4">
                            <x-label for="">N° Cuenta</x-label>
                            <x-input type="number" class="w-full" wire:model="post_update.N°_cuenta" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">Propietario</x-label>
                            <x-input class="w-full" wire:model="post_update.propietario" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">ABA</x-label>
                            <x-input type="number" class="w-full" wire:model="post_update.ABA" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">SWIT</x-label>
                            <x-input class="w-full" wire:model="post_update.SWIT" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">Correo</x-label>
                            <x-input type="email" class="w-full" wire:model="post_update.correo" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">Banco</x-label>
                            <x-select class="w-full" wire:model="post_update.banco_id">
                                <option value="" disabled>Seleccione un Banco</option>

                                @foreach ($banco as $post)
                                    <option value="{{ $post->id }}">{{ $post->nombre }}</option>
                                @endforeach

                            </x-select>
                        </div>
                    @elseif ($metodo == 3)
                        <div class="mb-4">
                            <x-label for="">Cedula</x-label>
                            <x-input type="number" class="w-full" wire:model="post_update.cedula" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">Telefono</x-label>
                            <x-input type="number" class="w-full" wire:model="post_update.telefono" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">Propietario</x-label>
                            <x-input class="w-full" wire:model="post_update.propietario" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">Banco</x-label>
                            <x-select class="w-full" wire:model="post_update.banco_id">
                                <option value="" disabled>Seleccione un Banco</option>

                                @foreach ($banco as $post)
                                    <option value="{{ $post->id }}">{{ $post->nombre }}</option>
                                @endforeach

                            </x-select>
                        </div>
                    @elseif ($metodo == 4)
                        <div class="mb-4">
                            <x-label for="">N° Cuenta</x-label>
                            <x-input type="number" class="w-full" wire:model="post_update.N°_cuenta" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">Cedula</x-label>
                            <x-input type="number" class="w-full" wire:model="post_update.cedula" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">Propietario</x-label>
                            <x-input class="w-full" wire:model="post_update.propietario" />
                        </div>

                        <div class="mb-4">
                            <x-label for="">Banco</x-label>
                            <x-select class="w-full" wire:model="post_update.banco_id">
                                <option value="" disabled>Seleccione un Banco</option>

                                @foreach ($banco as $post)
                                    <option value="{{ $post->id }}">{{ $post->nombre }}</option>
                                @endforeach

                            </x-select>
                        </div>
                    @elseif ($metodo == 5)
                        <div class="mb-4">
                            <x-label for="">Banco</x-label>
                            <x-select class="w-full" wire:model="post_create.banco_id">
                                <option value="">Seleccione un Banco</option>
                                @foreach ($banco as $post)
                                    <option value="{{ $post->id }}">{{ $post->nombre }}</option>
                                @endforeach
                            </x-select>
                            @error('post_create.banco_id')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
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
