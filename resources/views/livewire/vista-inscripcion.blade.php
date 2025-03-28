<div>
    <form wire:submit.prevent="update">

        <div class=" bg-white shadow rounded-lg p-4 mb-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="pl-8">
                    <h1 class="font-black text-2xl text-gray-800 leading-tight text-normal normal-case">
                        Evento: {{ $this->post_update['evento_id'] }}.
                    </h1>
                </div>
                <div class="justify-items-end pr-8">
                    <h1 class=" font-black text-2xl text-gray-800 leading-tight text-normal normal-case">
                        Codigo Inscripción: {{ $this->post_update['nomenclatura'] }}
                    </h1>
                </div>

            </div>
            <div class="flex items-center justify-end pr-8">
                <h1 class="pl-56 font-black text-md text-black leading-tight text-normal normal-case">
                    Dirección IP: {{ $this->post_update['ip'] }}
                </h1>
            </div>
            <div class="flex items-center justify-start py-0">

                <h1 class="pl-8 font-black text-sm text-black leading-tight text-normal normal-case">
                    Monto Total: {{ $this->post_update['grupo_precio'] }} $
                </h1>
                <h1 class="pl-6 font-black text-sm text-black leading-tight text-normal normal-case">
                    Monto Total: {{ $this->post_update['monto_pagado_bs'] }} Bs
                </h1>
                <h1 class="pl-6 font-black text-sm text-black leading-tight text-normal normal-case">
                    Tasa dolar: {{ $this->post_update['dolar_id'] }} Bs
                </h1>
            </div>

        </div>
        <div class="bg-white shadow-md rounded-xl p-6">

            <div class="grid grid-cols-3 gap-4">
                <div class="mb-4">
                    <x-label for="">Cedula</x-label>
                    <x-input class="w-full" wire:model="post_update.participante_id" disabled />
                    @error('post_update.participante_id')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">Clasificacion: </x-label>
                    <x-select class="w-full" wire:model="post_update.recorrido_id">
                        <option value="">Seleccione un recorrido</option>
                        @if ($clasificacions)
                            @foreach ($clasificacions as $clasificacion)
                                <option value="{{ $clasificacion->id }}">{{ $clasificacion->nombre }}</option>
                            @endforeach
                        @endif
                    </x-select>
                    @error('post_update.recorrido_id')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">Recorrido: </x-label>
                    <x-select class="w-full" wire:model="post_update.recorrido_id_grupos"
                        wire:change="update_grupos($event.target.value)">
                        <option value="">Seleccione un recorrido</option>
                        @if ($recorridos)
                            @foreach ($recorridos as $recorrido)
                                <option value="{{ $recorrido->id }}">{{ $recorrido->nombre }}</option>
                            @endforeach
                        @endif
                    </x-select>
                    @error('post_update.recorrido_id_grupos')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">Grupo: </x-label>
                    <x-select class="w-full" wire:model="post_update.grupo_id">
                        <option value="">Seleccione un grupo</option>
                        @if ($grupos)
                            @foreach ($grupos as $grupo)
                                <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                            @endforeach
                        @endif
                    </x-select>
                    @error('post_update.grupo_id')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>


                <div class="mb-4">
                    <x-label for="">categoria: </x-label>
                    <x-select class="w-full" wire:model="post_update.categoria_habilitada_id">
                        @if ($categoria_habilitada)
                            @foreach ($categoria_habilitada as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        @endif
                    </x-select>
                    @error('post_update.categoria_habilitada_id')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">Mesa: </x-label>
                    <x-select class="w-full" wire:model="post_update.mesa_id">
                        @if ($mesas)
                            @foreach ($mesas as $mesa)
                                <option value="{{ $mesa->id }}">{{ $mesa->nombre }}</option>
                            @endforeach
                        @endif
                    </x-select>
                    @error('post_update.mesa_id')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">N° del competidor </x-label>
                    <x-select class="w-full" wire:model="post_update.numero_id">
                        <option value="{{ $post_update['numero'] }}">{{ $post_update['numero'] }}</option>
                        @if ($numeros)
                            @foreach ($numeros as $numero)
                                <option value="{{ $numero->id }}">{{ $numero->numero }}</option>
                            @endforeach
                        @endif
                    </x-select>
                    @error('post_update.numero_id')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">Fecha de inscripcion</x-label>
                    <x-input type="date" class="w-full" wire:model="post_update.created_at" />
                    @error('post_update.created_at')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <x-label for="">Prendas</x-label>
                    <x-select class="w-full" wire:model="post_update.prenda_id">
                        <option value="">Seleccionar prenda</option>
                        @foreach ($prendas as $prenda)
                            <option value="{{ $prenda->id }}">{{ $prenda->categoria }} {{ $prenda->sexo }}
                                Talla
                                {{ $prenda->talla }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
            </div>
            @if (!isset($post_update['datos']['fecha_mixto']))
                <div class="grid grid-cols-4 gap-4">

                    <div class="mb-4">
                        <x-label for="">Metodo pago</x-label>
                        <x-select class="w-full" wire:model="post_update.metodo_pago_id">
                            @foreach ($metodo_pago as $metodo_pagos)
                                <option value="{{ $metodo_pagos->id }}">
                                    {{ $metodo_pagos->tipo_pago_nombre }}->{{ $metodo_pagos->banco_nombre }}
                                </option>
                            @endforeach
                        </x-select>
                        @error('post_update.metodo_pago_id')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Fecha pago</x-label>
                        <x-input type="date" class="w-full" wire:model="post_update.datos.fecha" />
                        @error('post_update.datos.fecha')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    @if (isset($post_update['datos']['monto_Bs']))
                        <div class="mb-4">
                            <x-label for="">Monto Bs</x-label>
                            <x-input class="w-full" wire:model="post_update.datos.monto_Bs" />
                            @error('post_update.datos.monto_Bs')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @else
                        <div class="mb-4">
                            <x-label for="">Monto $</x-label>
                            <x-input class="w-full" wire:model="post_update.datos.monto_$" />
                            @error('post_update.datos.monto_$')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                    <div class="mb-4">
                        <x-label for="">Referencia</x-label>
                        <x-input class="w-full" wire:model="post_update.datos.referencia" />
                        @error('post_update.datos.referencia')
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @else
                <div class="grid grid-cols-4 gap-4">

                    @if (isset($post_update['datos']['monto_mixto_Bs']))
                        <div class="mb-4">
                            <x-label for="">Cuenta </x-label>
                            <x-select class="w-full" wire:model="post_update.datos.cuenta_mixto_2">
                                @foreach ($metodo_pago as $metodo_pagos)
                                    <option value="{{ $metodo_pagos->id }}">
                                        {{ $metodo_pagos->tipo_pago_nombre }}->{{ $metodo_pagos->banco_nombre }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="mb-4">
                            <x-label for="">Fecha pago</x-label>
                            <x-input type="date" class="w-full" wire:model="post_update.datos.fecha_mixto" />
                            @error('post_update.datos.fecha_mixto')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <x-label for="">Monto Bs</x-label>
                            <x-input class="w-full" wire:model="post_update.datos.monto_mixto_Bs" />
                            @error('post_update.datos.monto_mixto_Bs')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <x-label for="">Referencia</x-label>
                            <x-input class="w-full" wire:model="post_update.datos.referencia_mixto" />
                            @error('post_update.datos.referencia_mixto')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        @if (isset($post_update['datos']['monto_Bs']))

                            <div class="mb-4">
                                <x-label for="">Cuenta </x-label>
                                <x-select class="w-full" wire:model="post_update.datos.cuenta_mixto_1">
                                    @foreach ($metodo_pago as $metodo_pagos)
                                        <option value="{{ $metodo_pagos->id }}">
                                            {{ $metodo_pagos->tipo_pago_nombre }}--/--{{ $metodo_pagos->banco_nombre }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div class="mb-4">
                                <x-label for="">Fecha pago</x-label>
                                <x-input type="date" class="w-full" wire:model="post_update.datos.fecha" />
                                @error('post_update.datos.fecha')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">Monto Bs</x-label>
                                <x-input class="w-full" wire:model="post_update.datos.monto_Bs" />
                                @error('post_update.datos.monto_Bs')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">Referencia</x-label>
                                <x-input class="w-full" wire:model="post_update.datos.referencia" />
                                @error('post_update.datos.referencia')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        @else
                            <div class="mb-4">
                                <x-label for="">Cuenta </x-label>
                                <x-select class="w-full" wire:model="post_update.datos.cuenta_mixto_1">
                                    @foreach ($metodo_pago as $metodo_pagos)
                                        <option value="{{ $metodo_pagos->id }}">
                                            {{ $metodo_pagos->tipo_pago_nombre }}--/--{{ $metodo_pagos->banco_nombre }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div class="mb-4">
                                <x-label for="">Fecha pago</x-label>
                                <x-input type="date" class="w-full" wire:model="post_update.datos.fecha" />
                                @error('post_update.datos.fecha')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">Monto $</x-label>
                                <x-input class="w-full" wire:model="post_update.datos.monto_$" />
                                @error('post_update.datos.monto_$')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">Referencia</x-label>
                                <x-input class="w-full" wire:model="post_update.datos.referencia" />
                                @error('post_update.datos.referencia')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    @else
                        <div class="mb-4">
                            <x-label for="">Cuenta </x-label>
                            <x-select class="w-full" wire:model="post_update.datos.cuenta_mixto_2">
                                @foreach ($metodo_pago as $metodo_pagos)
                                    <option value="{{ $metodo_pagos->id }}">
                                        {{ $metodo_pagos->tipo_pago_nombre }}->{{ $metodo_pagos->banco_nombre }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="mb-4">
                            <x-label for="">Fecha pago</x-label>
                            <x-input type="date" class="w-full" wire:model="post_update.datos.fecha_mixto" />
                            @error('post_update.datos.fecha_mixto')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <x-label for="">Monto $</x-label>
                            <x-input class="w-full" wire:model="post_update.datos.monto_mixto_$" />
                            @error('post_update.datos.monto_mixto_$')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <x-label for="">Referencia</x-label>
                            <x-input class="w-full" wire:model="post_update.datos.referencia_mixto" />
                            @error('post_update.datos.referencia_mixto')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        @if (isset($post_update['datos']['monto_Bs']))
                            <div class="mb-4">
                                <x-label for="">Cuenta </x-label>
                                <x-select class="w-full" wire:model="post_update.datos.cuenta_mixto_1">
                                    @foreach ($metodo_pago as $metodo_pagos)
                                        <option value="{{ $metodo_pagos->id }}">
                                            {{ $metodo_pagos->tipo_pago_nombre }}--/--{{ $metodo_pagos->banco_nombre }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div class="mb-4">
                                <x-label for="">Fecha pago</x-label>
                                <x-input type="date" class="w-full" wire:model="post_update.datos.fecha" />
                                @error('post_update.datos.fecha')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">Monto Bs</x-label>
                                <x-input class="w-full" wire:model="post_update.datos.monto_Bs" />
                                @error('post_update.datos.monto_Bs')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">Referencia</x-label>
                                <x-input class="w-full" wire:model="post_update.datos.referencia" />
                                @error('post_update.datos.referencia')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        @else
                            <div class="mb-4">
                                <x-label for="">Cuenta </x-label>
                                <x-select class="w-full" wire:model="post_update.datos.cuenta_mixto_1">
                                    @foreach ($metodo_pago as $metodo_pagos)
                                        <option value="{{ $metodo_pagos->id }}">
                                            {{ $metodo_pagos->tipo_pago_nombre }}--/--{{ $metodo_pagos->banco_nombre }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div class="mb-4">
                                <x-label for="">Fecha pago</x-label>
                                <x-input type="date" class="w-full" wire:model="post_update.datos.fecha" />
                                @error('post_update.datos.fecha')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">Monto $</x-label>
                                <x-input class="w-full" wire:model="post_update.datos.monto_$" />
                                @error('post_update.datos.monto_$')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">Referencia</x-label>
                                <x-input class="w-full" wire:model="post_update.datos.referencia" />
                                @error('post_update.datos.referencia')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                        @endif

                    @endif
                </div>

            @endif

            <div class="flex justify-end">
                <x-danger-button wire:click="confirm_delete({{ $this->post_edit_id }})">
                    <i class="bi bi-trash-fill"></i>
                </x-danger-button>

                <x-button>
                    Actualizar
                </x-button>
            </div>
    </form>
    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Livewire.on('alert_update', function() {
                Swal.fire({
                    title: "Éxito!",
                    text: "Los datos han sido actualizados!",
                    icon: "success",
                    didClose: () => {
                        // Obtener la URL de la ruta con nombre usando una variable JavaScript
                        const url =
                            "{{ route('incripcion') }}"; // Esta línea se procesa en el servidor
                        window.location.href = url; // Redirección en el cliente (navegador)
                    }
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
                            icon: "success",
                            didClose: () => {
                                // Obtener la URL de la ruta con nombre usando una variable JavaScript
                                const url =
                                    "{{ route('incripcion') }}"; // Esta línea se procesa en el servidor
                                window.location.href = url; // Redirección en el cliente (navegador)
                            }
                        });
                    }
                });

            })
        </script>
    @endpush
</div>
</div>
