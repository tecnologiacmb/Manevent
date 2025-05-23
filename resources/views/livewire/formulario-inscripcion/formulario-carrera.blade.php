<div>
    <form wire:submit.prevent="save">
        <div class=" bg-white shadow rounded-lg p-4 mb-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="pl-8">
                    <h1 class="font-black text-2xl text-gray-800 leading-tight text-normal normal-case">
                        Evento: {{ $evento->nombre }}.
                    </h1>
                </div>
                <div class="justify-items-end pr-8">
                    <h1 class="mt-2 font-black text-2xl text-gray-800 leading-tight text-normal normal-case">
                        Grupo: {{ $grupo->nombre }}
                    </h1>
                </div>
            </div>
            <div class="flex items-center justify-start py-0">

                <h1 class="pl-8 font-black text-sm text-black leading-tight text-normal normal-case">
                    Monto: {{ $grupo->precio }} $
                </h1>
                <h1 class="pl-6 font-black text-sm text-black leading-tight text-normal normal-case">
                    Monto: {{ $this->calculo($grupo->precio) }} Bs
                </h1>
                <h1 class="pl-6 font-black text-sm text-black leading-tight text-normal normal-case">
                    Tasa dolar: {{ $dolars->precio }} Bs
                </h1>

            </div>
        </div>
        @for ($i = 0; $i <= $cantidad - 1; $i++)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white rounded-lg p-4 shadow">
                <div class="grid grid-cols-3 gap-4">
                    <div class="mb-4">
                        <x-label for="">Cedula </x-label>
                        <x-input class="w-full" wire:model.change="create_participante.{{ $i }}.cedula"
                            wire:change="buscarCedula" />
                        @error("create_participante.$i.cedula")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Nombre</x-label>
                        <x-input class="w-full" wire:model="create_participante.{{ $i }}.nombre" />
                        @error("create_participante.$i.nombre")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Apellido</x-label>
                        <x-input class="w-full" wire:model="create_participante.{{ $i }}.apellido" />
                        @error("create_participante.$i.apellido")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Telefono</x-label>
                        <x-input class="w-full" wire:model="create_participante.{{ $i }}.telefono" />
                        @error("create_participante.$i.telefono")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Fecha de nacimiento</x-label>
                        <x-input class="w-full" type="date" max="{{ $this->fecha_evento }}"
                            wire:model="create_participante.{{ $i }}.fecha_nacimiento"
                            wire:click="edad(value.fecha_nacimiento)" />
                        @error("create_participante.$i.fecha_nacimiento")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Correo</x-label>
                        <x-input class="w-full" type="email"
                            wire:model="create_participante.{{ $i }}.correo" />
                        @error("create_participante.$i.correo")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Estado</x-label>
                        <x-select class="w-full" wire:model.change="create_participante.{{ $i }}.estado_id">
                            <option value="">Seleccione un estado</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id }}"> {{ $estado->estado }}</option>
                            @endforeach
                        </x-select>
                        @error("create_participante.$i.estado_id")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Ciudad </x-label>
                        <x-select class="w-full" wire:model="create_participante.{{ $i }}.ciudad_id">
                            <option value="">Seleccione la ciudad</option>
                            @if (!empty($create_participante[$i]['ciudades']))
                                @foreach ($create_participante[$i]['ciudades'] as $ciudad)
                                    <option value="{{ $ciudad->id }}">{{ $ciudad->ciudad }}</option>
                                @endforeach
                                {{-- @elseif(isset($this->participante[$i]) && !is_null($this->participante[$i]))
                                @foreach ($this->create_participante[$i]['ciudades'] as $ciudad)
                                    <option value="{{ $ciudad->id }}"
                                        {{ $ciudad->id == $this->participante->ciudad_id ? 'selected' : '' }}>
                                        {{ $ciudad->ciudad }}</option>
                                @endforeach --}}
                            @endif
                        </x-select>
                        @error("create_participante.$i.ciudad_id")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Direccion</x-label>
                        <x-input class="w-full" wire:model="create_participante.{{ $i }}.direccion" />
                        @error("create_participante.$i.direccion")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <x-label for="">Genero</x-label>
                        <x-select class="w-full" wire:model="create_participante.{{ $i }}.genero_id">
                            <option value="">Seleccionar Genero</option>
                            @foreach ($generos as $genero)
                                <option value="{{ $genero->id }}">{{ $genero->genero }}</option>
                            @endforeach
                        </x-select>
                        @error("create_participante.$i.genero_id")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    @if (!str_contains($grupo->nombre, 'sin franela'))
                        <div>
                            <x-label for="">Prendas</x-label>
                            <x-select class="w-full"
                                wire:change="update_prendas({{ $i }},$event.target.value)">
                                <option value="">Seleccionar prenda</option>
                                <option value="1">Masculino</option>
                                <option value="2">Femenino</option>
                            </x-select>
                            @error("create_prendas.$i.prenda_genero")
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        @if ($this->create_prendas[$i]['genero'] == 'Masculino')
                            <div>
                                <x-label for="">Talla</x-label>
                                <x-select class="w-full" wire:model="create_prendas.{{ $i }}.prendas">
                                    <option value="">Seleccione una talla</option>
                                    @foreach ($prendas as $prenda)
                                        <option value="{{ $prenda->id }}"
                                            {{ $prenda->sexo == $this->create_prendas[$i]['genero'] ? 'selected' : '' }}>
                                            {{ $prenda->prenda_categories_nombre }} Talla
                                            {{ $prenda->prenda_talla }}
                                        </option>
                                    @endforeach
                                </x-select>

                            </div>
                        @elseif ($this->create_prendas[$i]['genero'] == 'Femenino')
                            <div>
                                <x-label for="">Talla</x-label>
                                <x-select class="w-full" wire:model="create_prendas.{{ $i }}.prendas">
                                    <option value="">Seleccione una talla</option>
                                    @foreach ($prendas as $prenda)
                                        <option value="{{ $prenda->id }}"
                                            {{ $prenda->sexo == $this->create_prendas[$i]['genero'] ? 'selected' : '' }}>
                                            {{ $prenda->prenda_categories_nombre }} Talla
                                            {{ $prenda->prenda_talla }}
                                        </option>
                                    @endforeach
                                </x-select>
                                @error("create_prendas.$i.prendas")
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    @endif
                </div>



            </div>


            <br>
        @endfor
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white shadow rounded-lg p-4">
            <div class="mb-4">
                <x-label for="">Metodo realizado </x-label>
                <x-select class="w-full" wire:model="seleccionPago" wire:change="update_radio($event.target.value)">
                    <option value="">Seleccione un pago</option>
                    <option value="1">Unico</option>
                    <option value="2">Mixto</option>
                </x-select>
            </div>
            @error('seleccionPago')
                <span class="error text-red-500">{{ $message }}</span>
            @enderror

            @if (isset($this->create_inscripcion['unico']) && $this->create_inscripcion['unico'] == '1')
                <div>
                    <h1 class="font-semibold text-gray-700 leading-tight text-normal">Reporte de pago </h1>
                    <hr class="border-gray-300"><br>
                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <x-label for="">Pagos</x-label>
                            <x-select class="w-full" wire:model="tipoMoneda"
                                wire:click="update_pago($event.target.value)">
                                <option value="">Seleccione un pago</option>
                                <option value="1">Bolivares Bs</option>
                                <option value="2">Dolares $</option>
                            </x-select>
                            @error('tipoMoneda')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <x-label for="">Cuenta</x-label>
                            <x-select class="w-full" wire:model="metodoPago">
                                <option value="">Seleccione la cuenta de pago</option>
                                @foreach ($metodo_pago as $metodo_pagos)
                                    <option value=" {{ $metodo_pagos->id }}">
                                        {{ $metodo_pagos->tipo_pago_nombre }}->{{ $metodo_pagos->banco_nombre }}
                                    </option>
                                @endforeach
                            </x-select>
                            @error('metodoPago')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">

                        @if ($this->create_inscripcion['bolivar'] == '1')
                            <div class="mb-4">
                                <x-label for="">Fecha del pago</x-label>
                                <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                    wire:model="fecha" />
                                @error('fecha')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">N° Referencia</x-label>
                                <x-input class="w-full" min="6" max="6"
                                    placeholder="ultimos 6 digitos" wire:model="referencia" />
                                @error('referencia')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <div class="mb-4">
                                    <x-label for="">Monto pagado Bs</x-label>
                                    <x-input type="number" step="0.01" class="w-full"
                                        wire:model="totalPagoBs" />
                                    @error('totalPagoBs')
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- si pago en bs --}}
                        @elseif($this->create_inscripcion['dolar'] == '2')
                            <div class="mb-4">
                                <x-label for="">Fecha del pago</x-label>
                                <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                    wire:model="fecha" />
                                @error('fecha')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">N° Referencia</x-label>
                                <x-input class="w-full" min="6" max="6"
                                    placeholder="ultimos 6 digitos" wire:model="referencia" />
                                @error('referencia')
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <div class="mb-4">
                                    <x-label for="">Monto pagado $</x-label>
                                    <x-input type="number" step="0.01" class="w-full"
                                        wire:model="totalPagoUsd" />
                                    @error('totalPagoUsd')
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            @elseif (isset($this->create_inscripcion['mixto']) && $this->create_inscripcion['mixto'] == '2')
                {{-- cuando el pago es mixto --}}
                <div>
                    <h1 class="font-semibold text-gray-700 leading-tight text-normal normal-case">Reporte del
                        pago
                        N° 1 </h1>
                    <hr class="border-gray-300"><br>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-label for="">Pagos</x-label>
                            <x-select class="w-full" wire:model="tipoMoneda"
                                wire:change="update_pago($event.target.value)">
                                <option value="">Seleccione un pago</option>
                                <option value="1">Bolivares Bs</option>
                                <option value="2">Dolares $</option>
                            </x-select>
                            @error('tipoMoneda')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <x-label for="">Cuenta</x-label>
                            <x-select class="w-full" wire:model="cuenta">
                                <option value="">Seleccione la cuenta de pago</option>
                                @foreach ($metodo_pago as $metodo_pagos)
                                    <option
                                        value=" {{ $metodo_pagos->tipo_pago_nombre }}->{{ $metodo_pagos->banco_nombre }}">
                                        {{ $metodo_pagos->tipo_pago_nombre }}->{{ $metodo_pagos->banco_nombre }}
                                    </option>
                                @endforeach
                            </x-select>
                            @error('cuenta')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        {{-- si pago en $ --}}
                        @if ($this->create_inscripcion['bolivar'] == '1')
                            <div class="mb-4">
                                <x-label for="">Fecha del pago</x-label>
                                <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                    wire:model="fecha" />

                            </div>
                            <div class="mb-4">
                                <x-label for="">N° Referencia</x-label>
                                <x-input class="w-full" min="6" max="6"
                                    placeholder="ultimos 6 digitos" wire:model="referencia" />
                            </div>
                            <div>
                                <div class="mb-4">
                                    <x-label for="">Monto pagado Bs</x-label>
                                    <x-input type="number" step="0.01" class="w-full"
                                        wire:model="totalPagoBs" />
                                </div>
                            </div>
                            {{-- si pago en bs --}}
                        @elseif($this->create_inscripcion['dolar'] == '2')
                            <div class="mb-4">
                                <x-label for="">Fecha del pago</x-label>
                                <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                    wire:model="fecha" />

                            </div>
                            <div class="mb-4">
                                <x-label for="">N° Referencia</x-label>
                                <x-input class="w-full" min="6" max="6"
                                    placeholder="ultimos 6 digitos" wire:model="referencia" />

                            </div>
                            <div>
                                <div class="mb-4">
                                    <x-label for="">Monto pagado $</x-label>
                                    <x-input type="number" step="0.01" class="w-full"
                                        wire:model="totalPagoUsd" />
                                </div>
                            </div>
                        @endif
                    </div>
                    <h1 class="font-semibold text-gray-700 leading-tight text-normal normal-case">Reporte del
                        pago N° 2
                    </h1>
                    <hr class="border-gray-300"><br>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-label for="">Pagos</x-label>
                            <x-select class="w-full" wire:model="tipoMonedaMixto"
                                wire:change="update_pago_mixto($event.target.value)">
                                <option value="">Seleccione un pago</option>
                                <option value="1">Bolivares Bs</option>
                                <option value="2">Dolares $</option>
                            </x-select>
                            @error('tipoMonedaMixto')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <x-label for="">Cuenta</x-label>
                            <x-select class="w-full" wire:model="cuentaMixto">
                                <option value="">Seleccione la cuenta de pago</option>
                                @foreach ($metodo_pago as $metodo_pagos)
                                    <option
                                        value=" {{ $metodo_pagos->tipo_pago_nombre }}->{{ $metodo_pagos->banco_nombre }}">
                                        {{ $metodo_pagos->tipo_pago_nombre }}->{{ $metodo_pagos->banco_nombre }}
                                    </option>
                                @endforeach
                            </x-select>
                            @error('cuentaMixto')
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- si pago en $ --}}
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        @if ($this->create_inscripcion['bolivar_mixto'] == '1')
                            <div class="mb-4">
                                <x-label for="">Fecha del pago</x-label>
                                <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                    wire:model="fechaMixto" />
                            </div>
                            <div class="mb-4">
                                <x-label for="">N° Referencia</x-label>
                                <x-input class="w-full" min="6" max="6"
                                    placeholder="ultimos 6 digitos" wire:model="referenciaMixto" />

                            </div>
                            <div>
                                <div class="mb-4">
                                    <x-label for="">Monto pagado Bs</x-label>
                                    <x-input type="number" step="0.01" class="w-full"
                                        wire:model="totalPagoMixtoBs" />
                                </div>
                            </div>
                            {{-- si pago en bs --}}
                        @elseif($this->create_inscripcion['dolar_mixto'] == '2')
                            <div class="mb-4">
                                <x-label for="">Fecha del pago</x-label>
                                <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                    wire:model="fechaMixto" />
                            </div>
                            <div class="mb-4">
                                <x-label for="">N° Referencia</x-label>
                                <x-input class="w-full" min="6" max="6"
                                    placeholder="ultimos 6 digitos" wire:model="referenciaMixto" />
                            </div>
                            <div>
                                <div class="mb-4">
                                    <x-label for="">Monto pagado $</x-label>
                                    <x-input type="number" step="0.01" class="w-full"
                                        wire:model="totalPagoMixtoUsd" />

                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        <div class="flex justify-end">
            <x-button type="submit" class="hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300">
                Agregar
            </x-button>
        </div>

    </form>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Livewire.on('existe', (event) => {
                const cedula = event[0].valor;
                console.log('Evento existe disparado:', cedula);
                Swal.fire({
                    title: "Advertencia!",
                    text: `El participante con cédula ${cedula} ya se encuentra inscrito!`,
                    icon: "warning"
                });
            })

            Livewire.on('alert', function() {
                Swal.fire({
                    title: "Éxito!",
                    text: "El registro ha sido exitoso!",
                    icon: "success"
                });
            })

            function showOnChange(e, posicion) {
                console.log('entre a la funcion')
                document.getElementById('unico_' + posicion).style.display = "none";
                document.getElementById('mixto_' + posicion).style.display = "none";
                var elem = document.getElementById("metodo_pagos_" + posicion);
                var value = elem.options[elem.selectedIndex].value;
                let valor_posicion = value + '_' + posicion

                if (valor_posicion == "unico_" + posicion) {
                    document.getElementById('unico_' + posicion).style.display = "block";
                    document.getElementById('mixto_' + posicion).style.display = "none";

                } else if (valor_posicion == "mixto_" + posicion) {
                    document.getElementById('unico_' + posicion).style.display = "none";
                    document.getElementById('mixto_' + posicion).style.display = "block";

                }

            }

            function tipo_pago(e, posicion) {
                document.getElementById('bolivar_' + posicion).style.display = "block";
                document.getElementById('dolar_' + posicion).style.display = "none";
                var elem = document.getElementById("tipo_pago_" + posicion);
                var value = elem.options[elem.selectedIndex].value;
                let valor_posicion = value + '_' + posicion

                if (valor_posicion == "bolivar_" + posicion) {
                    document.getElementById('bolivar_' + posicion).style.display = "block";
                    document.getElementById('dolar_' + posicion).style.display = "none";

                } else if (valor_posicion == "dolar_" + posicion) {
                    document.getElementById('bolivar_' + posicion).style.display = "none";
                    document.getElementById('dolar_' + posicion).style.display = "block";

                }

            }
        </script>
    @endpush

</div>
