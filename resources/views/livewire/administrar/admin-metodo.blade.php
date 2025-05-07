<div>
    <div class="w-full max-[500px]:w-full mb-2">
        <div
            class="flex group w-full h-24 rounded-lg bg-white shadow transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000] justify-between">
            <div>
                <img src="{{ asset('storage/image/metodo.png') }}" alt="Imagen de dolar almacenada en storage"
                    class="pt-8 group-hover:opacity-100 absolute left-[8%] top-[40%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-16">
            </div>
            <div>
                <p class="text-center px-64 text-black text-2xl pt-8 group-hover:text-green-800">Metodos de Pagos</p>
            </div>
            <div>
                <x-button class=" absolute right-[8%] top-[50%] translate-y-[-50%] shadow hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300" wire:click="crear">
                    Agregar
                </x-button>
            </div>
            <br>
        </div>
    </div>

    <div
        class="relative flex flex-col w-full h-full overflow-scroll text-black bg-white shadow-md rounded-xl bg-clip-border overflow-x-auto overflow-y-hidden">
        <table class="w-full text-center table-auto min-w-max">
            <thead>
                <tr>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Logo
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Tipo
                        </p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Cuenta
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
                @foreach ($posts as $metodo_pago)
                    <tr>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                <img src="data:image/jpeg;base64,{{ base64_encode($metodo_pago->logo) }}"
                                    alt="Logo de {{ $metodo_pago->banco }}" width="90">
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $metodo_pago->tipo_pago }} -
                                {{ $metodo_pago->banco }}
                            </p>

                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            @if ($metodo_pago->tipo_pago_id == 1 || $metodo_pago->tipo_pago_id == 5 || $metodo_pago->tipo_pago_id == 6)
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{ $metodo_pago->propietario }}
                                </p>
                            @elseif ($metodo_pago->tipo_pago_id == 2)
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    N°-C: {{ $metodo_pago->n°_cuenta }}
                                </p>
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    ABA: {{ $metodo_pago->ABA }}
                                </p>
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    SWIT: {{ $metodo_pago->SWIT }}
                                </p>
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{ $metodo_pago->propietario }}
                                </p>
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{ $metodo_pago->correo }}
                                </p>
                            @elseif ($metodo_pago->tipo_pago_id == 3)
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{ $metodo_pago->telefono }}
                                </p>
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    C.I: {{ $metodo_pago->cedula }}
                                </p>
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{ $metodo_pago->propietario }}
                                </p>
                            @elseif ($metodo_pago->tipo_pago_id == 4)
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    N°-C: {{ $metodo_pago->n°_cuenta }}
                                </p>
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    C.I: {{ $metodo_pago->cedula }}
                                </p>
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{ $metodo_pago->propietario }}
                                </p>
                            @endif
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                {{ $metodo_pago->estado }}
                            </p>
                        </td>

                        <td class="p-4 border-b border-blue-gray-50">
                            <x-button class="bg-blue-500 hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300"
                                wire:click="edit({{ $metodo_pago->id }})">
                                <i class="bi bi-pencil-square"></i>
                            </x-button>

                            <x-danger-button wire:click="confirm_delete({{ $metodo_pago->id }})">
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

    <form wire:submit="seve">
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                Registrar
            </x-slot>
            <x-slot name="content">
                <div class="grid grid-cols-2 gap-4">
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
                        <div class="mb-4">
                            <x-label for="">Propietario</x-label>
                            <x-input class="w-full" wire:model="post_create.propietario" />
                            @error('post_create.propietario')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @elseif ($metodo == 2)
                        <div class="mb-4">
                            <x-label for="">N° Cuenta</x-label>
                            <x-input type="number" class="w-full" wire:model="post_create.n°_cuenta" />
                            @error('post_create.n°_cuenta')
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
                            <x-input type="number" class="w-full" wire:model="post_create.n°_cuenta" />
                            @error('post_create.n°_cuenta')
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
                    @elseif ($metodo == 5 || $metodo == 6)
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
                        <div class="mb-4">
                            <x-label for="">Propietario</x-label>
                            <x-input class="w-full" wire:model="post_create.propietario" />
                            @error('post_create.propietario')
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
                    <x-label for="">Metodo</x-label>
                    <x-select class="w-full" wire:model="post_update.tipo_pago_id"
                        wire:click="changeEvent($event.target.value)">
                        <option value=""> Metodo pago</option>
                        @foreach ($tipo_pago as $pago)
                            <option value="{{ $pago->id }}">{{ $pago->nombre }}</option>
                        @endforeach
                    </x-select>
                    @error('post_update.tipo_pago_id')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    @if ($post_update['tipo_pago_id'] == 1)
                        <div class="mb-4">
                            <x-label for="">Banco</x-label>
                            <x-select class="w-full" wire:model="post_update.banco_id">
                                <option value="" disabled>Seleccione un Banco</option>
                                @foreach ($banco as $post)
                                    <option value="{{ $post->id }}">{{ $post->nombre }}</option>
                                @endforeach
                            </x-select>
                            @error('post_update.banco_id')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <x-label for="">Propietario</x-label>
                            <x-input class="w-full" wire:model="post_update.propietario" />
                            @error('post_update.propietario')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @elseif ($post_update['tipo_pago_id'] == 2)
                        <div class="mb-4">
                            <x-label for="">N° Cuenta</x-label>
                            <x-input type="number" class="w-full" wire:model="post_update.n°_cuenta" />
                            @error('post_update.n°_cuenta')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Propietario</x-label>
                            <x-input class="w-full" wire:model="post_update.propietario" />
                            @error('post_update.propietario')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">ABA</x-label>
                            <x-input type="number" class="w-full" wire:model="post_update.ABA" />
                            @error('post_update.ABA')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">SWIT</x-label>
                            <x-input class="w-full" wire:model="post_update." />
                            @error('post_update.SWIT')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Correo</x-label>
                            <x-input type="email" class="w-full" wire:model="post_update.correo" />
                            @error('post_update.correo')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Banco</x-label>
                            <x-select class="w-full" wire:model="post_update.banco_id">
                                <option value="" disabled>Seleccione un Banco</option>
                                @foreach ($banco as $post)
                                    <option value="{{ $post->id }}">{{ $post->nombre }}</option>
                                @endforeach
                            </x-select>
                            @error('post_update.banco_id')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @elseif ($post_update['tipo_pago_id'] == 3)
                        <div class="mb-4">
                            <x-label for="">Cedula</x-label>
                            <x-input type="number" class="w-full" wire:model="post_update.cedula" />
                            @error('post_update.cedula')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Telefono</x-label>
                            <x-input type="number" class="w-full" wire:model="post_update.telefono" />
                            @error('post_update.telefono')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Propietario</x-label>
                            <x-input class="w-full" wire:model="post_update.propietario" />
                            @error('post_update.propietario')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Banco</x-label>
                            <x-select class="w-full" wire:model="post_update.banco_id">
                                <option value="" disabled>Seleccione un Banco</option>
                                @foreach ($banco as $post)
                                    <option value="{{ $post->id }}">{{ $post->nombre }}</option>
                                @endforeach
                            </x-select>
                            @error('post_update.banco_id')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @elseif ($post_update['tipo_pago_id'] == 4)
                        <div class="mb-4">
                            <x-label for="">N° Cuenta</x-label>
                            <x-input type="number" class="w-full" wire:model="post_update.n°_cuenta" />
                            @error('post_update.n°_cuenta')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Cedula</x-label>
                            <x-input type="number" class="w-full" wire:model="post_update.cedula" />
                            @error('post_update.cedula')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Propietario</x-label>
                            <x-input class="w-full" wire:model="post_update.propietario" />
                            @error('post_update.propietario')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="">Banco</x-label>
                            <x-select class="w-full" wire:model="post_update.banco_id">
                                <option value="" disabled>Seleccione un Banco</option>

                                @foreach ($banco as $post)
                                    <option value="{{ $post->id }}">{{ $post->nombre }}</option>
                                @endforeach

                            </x-select>
                            @error('post_update.banco_id')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @elseif ($post_update['tipo_pago_id'] == 5 || $post_update['tipo_pago_id'] == 6)
                        <div class="mb-4">
                            <x-label for="">Banco</x-label>
                            <x-select class="w-full" wire:model="post_update.banco_id">
                                <option value="">Seleccione un Banco</option>
                                @foreach ($banco as $post)
                                    <option value="{{ $post->id }}">{{ $post->nombre }}</option>
                                @endforeach
                            </x-select>
                            @error('post_update.banco_id')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <x-label for="">Propietario</x-label>
                            <x-input class="w-full" wire:model="post_update.propietario" />
                            @error('post_update.propietario')
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
                        </x-select> @error('post_update.estado')
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
