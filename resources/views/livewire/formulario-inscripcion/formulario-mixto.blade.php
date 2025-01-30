<div>

    <form wire:submit.prevent="save">

        <div class=" bg-white shadow rounded-lg p-4 mb-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="pl-8">
                    <h1 class="font-black text-2xl text-gray-800 leading-tight text-normal normal-case
">
                        Evento: {{ $evento->nombre }}.
                    </h1>
                </div>
                <div class="justify-items-end pr-8">
                    <h1 class="mt-2 font-black text-2xl text-gray-800 leading-tight text-normal normal-case
">
                        Grupo: {{ $grupo->nombre }}
                    </h1>
                </div>
            </div>
            <div class="flex items-center justify-start py-0">

                <h1 class="pl-8 font-black text-sm text-black leading-tight text-normal normal-case
">
                    Monto: {{ $grupo->precio }} $
                </h1>
                <h1 class="pl-6 font-black text-sm text-black leading-tight text-normal normal-case
">
                    Monto: {{ $this->calculo($grupo->precio) }} Bs
                </h1>
                <h1 class="pl-6 font-black text-sm text-black leading-tight text-normal normal-case
">
                    Tasa dolar: {{ $dolars->precio }} Bs
                </h1>

            </div>
        </div>

        @for ($j = 0; $j <= $cantidad_caminata - 1; $j++)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white rounded-lg p-4 shadow">
                <div class="grid grid-cols-2 gap-4">

                    <div class="mb-4">
                        <x-label for="">Cedula </x-label>
                        <x-input class="w-full" wire:model.change="participante_caminata.{{ $j }}.cedula"
                            wire:change="buscarCedula_caminata" />
                        @error("participante_caminata.$j.cedula")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="">Nombre</x-label>
                        <x-input class="w-full" wire:model="participante_caminata.{{ $j }}.nombre" />
                        @error("participante_caminata.$j.nombre")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="">Apellido</x-label>
                        <x-input class="w-full" wire:model="participante_caminata.{{ $j }}.apellido" />
                        @error("participante_caminata.$j.apellido")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="">Telefono</x-label>
                        <x-input class="w-full" wire:model="participante_caminata.{{ $j }}.telefono" />
                        @error("participante_caminata.$j.telefono")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Fecha de nacimiento</x-label>
                        <x-input class="w-full" type="date" max="{{ $this->fecha_evento }}"
                            wire:model="participante_caminata.{{ $j }}.fecha_nacimiento"
                            wire:click="edad(value.fecha_nacimiento)" />
                        @error("participante_caminata.$j.fecha_nacimiento")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Correo</x-label>
                        <x-input class="w-full" type="email"
                            wire:model="participante_caminata.{{ $j }}.correo" />
                        @error("participante_caminata.$j.correo")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Estado</x-label>
                        <x-select class="w-full"
                            wire:model.change="participante_caminata.{{ $j }}.estado_id">
                            <option value="">Seleccione un estado</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id }}"> {{ $estado->estado }}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <div class="mb-4">
                        <x-label for="">Ciudad </x-label>
                        <x-select class="w-full" wire:model="participante_caminata.{{ $j }}.ciudad_id">
                            <option value="">Seleccione la ciudad</option>
                            @if (!empty($participante_caminata[$j]['ciudades']))
                                @foreach ($participante_caminata[$j]['ciudades'] as $ciudad)
                                    <option value="{{ $ciudad->id }}">{{ $ciudad->ciudad }}</option>
                                @endforeach
                            {{-- @elseif(isset($this->participante[$j]) && !is_null($this->participante[$j]))
                                @foreach ($participante_caminata[$j]['ciudades'] as $ciudad)
                                    <option value="{{ $ciudad->id }}"
                                        {{ $ciudad->id == $this->participante->ciudad_id ? 'selected' : '' }}>
                                        {{ $ciudad->ciudad }}</option>
                                @endforeach
                            @else --}}
                            @endif

                        </x-select>
                        @error("participante_caminata.$j.ciudad_id")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="">Direccion</x-label>
                        <x-input class="w-full" wire:model="participante_caminata.{{ $j }}.direccion" />
                        @error("participante_caminata.$j.direccion")
                            <span class="error text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="">Metodo realizado </x-label>
                        <x-select class="w-full"
                            wire:click="update_radio_caminata({{ $j }},$event.target.value)">
                            <option value="">Seleccione un pago</option>
                            <option value="1">Unico</option>
                            <option value="2">Mixto</option>
                        </x-select>
                    </div>

                </div>
                {{-- cuando el pago es unico --}}
                @if (isset($this->inscripcion_caminata[$j]) && $this->inscripcion_caminata[$j]['unico'] == '1')
                    <div>
                        <h1 class="font-semibold text-gray-700 leading-tight text-normal">Reporte de pago </h1>
                        <hr class="border-gray-300"><br>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-label for="">Pagos</x-label>
                                <x-select class="w-full"
                                    wire:click="update_pago_caminata({{ $j }},$event.target.value)">
                                    <option value="">Seleccione un pago</option>
                                    <option value="1">Bolivares Bs</option>
                                    <option value="2">Dolares $</option>
                                </x-select>
                            </div>
                            <div class="mb-4">
                                <x-label for="">Cuenta</x-label>
                                <x-select class="w-full"
                                    wire:model="inscripcion_caminata.{{ $j }}.metodo_pago_id">
                                    <option value="">Seleccione la cuenta de pago</option>
                                    @foreach ($metodo_pago as $metodo_pagos)
                                        <option value="{{ $metodo_pagos->id }}">
                                            {{ $metodo_pagos->tipo_pago_nombre }}--/--{{ $metodo_pagos->banco_nombre }}
                                        </option>
                                    @endforeach
                                </x-select>
                                @error("inscripcion_caminata.$j.metodo_pago_id")
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            {{-- si pago en $ --}}
                            @if ($this->inscripcion_caminata[$j]['bolivar'] == '1')
                                <div class="mb-4">
                                    <x-label for="">Fecha del pago</x-label>
                                    <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                        wire:model="inscripcion_caminata.{{ $j }}.fecha" />
                                    @error("inscripcion_caminata.$j.fecha")
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <x-label for="">N° Referencia</x-label>
                                    <x-input class="w-full" min="6" max="6"
                                        placeholder="ultimos 6 digitos"
                                        wire:model="inscripcion_caminata.{{ $j }}.referencia" />
                                    @error("inscripcion_caminata.$j.referencia")
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <div class="mb-4">
                                        <x-label for="">Monto pagado Bs</x-label>
                                        <x-input type="number" step="0.01" class="w-full"
                                            wire:model="inscripcion_caminata.{{ $j }}.monto" />
                                        @error("inscripcion_caminata.$j.monto")
                                            <span class="error text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- si pago en bs --}}
                            @elseif($this->inscripcion_caminata[$j]['dolar'] == '2')
                                <div class="mb-4">
                                    <x-label for="">Fecha del pago</x-label>
                                    <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                        wire:model="inscripcion_caminata.{{ $j }}.fecha" />
                                    @error("inscripcion_caminata.$j.fecha")
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <x-label for="">N° Referencia</x-label>
                                    <x-input class="w-full" min="6" max="6"
                                        placeholder="ultimos 6 digitos"
                                        wire:model="inscripcion_caminata.{{ $j }}.referencia" />
                                    @error("inscripcion_caminata.$j.referencia")
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <div class="mb-4">
                                        <x-label for="">Monto pagado $</x-label>
                                        <x-input type="number" step="0.01" class="w-full"
                                            wire:model="inscripcion_caminata.{{ $j }}.monto" />
                                        @error("inscripcion_caminata.$j.monto")
                                            <span class="error text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif


                        </div>
                    </div>
                @endif

                @if (isset($this->inscripcion_caminata[$j]) && $this->inscripcion_caminata[$j]['mixto'] == '2')
                    {{-- cuando el pago es mixto --}}
                    <div>
                        <h1 class="font-semibold text-gray-700 leading-tight text-normal normal-case">Reporte del pago
                            N° 1 </h1>
                        <hr class="border-gray-300"><br>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-label for="">Pagos</x-label>
                                <x-select class="w-full"
                                    wire:click="update_pago_caminata({{ $j }},$event.target.value)">
                                    <option value="">Seleccione un pago</option>
                                    <option value="1">Bolivares Bs</option>
                                    <option value="2">Dolares $</option>
                                </x-select>
                            </div>
                            <div class="mb-4">
                                <x-label for="">Cuenta</x-label>
                                <x-select class="w-full"
                                    wire:model="inscripcion_caminata.{{ $j }}.cuenta_mixto_1">
                                    <option value="">Seleccione la cuenta de pago</option>
                                    @foreach ($metodo_pago as $metodo_pagos)
                                        <option value="{{ $metodo_pagos->tipo_pago_nombre }}">
                                            {{ $metodo_pagos->tipo_pago_nombre }}
                                        </option>
                                    @endforeach
                                </x-select>
                                @error("inscripcion_caminata.$j.cuenta_mixto_1")
                                    <span class="error text-red-500 ">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            {{-- si pago en $ --}}
                            @if ($this->inscripcion_caminata[$j]['bolivar'] == '1')
                                <div class="mb-4">
                                    <x-label for="">Fecha del pago</x-label>
                                    <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                        wire:model="inscripcion_caminata.{{ $j }}.fecha" />
                                    @error("inscripcion_caminata.$j.fecha")
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <x-label for="">N° Referencia</x-label>
                                    <x-input class="w-full" min="6" max="6"
                                        placeholder="ultimos 6 digitos"
                                        wire:model="inscripcion_caminata.{{ $j }}.referencia" />
                                    @error("inscripcion_caminata.$j.referencia")
                                        <span class="error text-red-500 ">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <div class="mb-4">
                                        <x-label for="">Monto pagado Bs</x-label>
                                        <x-input type="number" step="0.01" class="w-full"
                                            wire:model="inscripcion_caminata.{{ $j }}.monto" />
                                        @error("inscripcion_caminata.$j.monto")
                                            <span class="error text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- si pago en bs --}}
                            @elseif($this->inscripcion_caminata[$j]['dolar'] == '2')
                                <div class="mb-4">
                                    <x-label for="">Fecha del pago</x-label>
                                    <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                        wire:model="inscripcion_caminata.{{ $j }}.fecha" />
                                    @error("inscripcion_caminata.$j.fecha")
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <x-label for="">N° Referencia</x-label>
                                    <x-input class="w-full" min="6" max="6"
                                        placeholder="ultimos 6 digitos"
                                        wire:model="inscripcion_caminata.{{ $j }}.referencia" />
                                    @error("inscripcion_caminata.$j.referencia")
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <div class="mb-4">
                                        <x-label for="">Monto pagado $</x-label>
                                        <x-input type="number" step="0.01" class="w-full"
                                            wire:model="inscripcion_caminata.{{ $j }}.monto" />
                                        @error("inscripcion_caminata.$j.monto")
                                            <span class="error text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        </div>
                        <h1 class="font-semibold text-gray-700 leading-tight text-normal normal-case">Reporte del pago
                            N° 2 </h1>
                        <hr class="border-gray-300"><br>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-label for="">Pagos</x-label>
                                <x-select class="w-full"
                                    wire:click="update_pago_mixto_caminata({{ $j }},$event.target.value)">
                                    <option value="">Seleccione un pago</option>
                                    <option value="1">Bolivares Bs</option>
                                    <option value="2">Dolares $</option>
                                </x-select>
                            </div>
                            <div class="mb-4">
                                <x-label for="">Cuenta</x-label>
                                <x-select class="w-full"
                                    wire:model="inscripcion_caminata.{{ $j }}.cuenta_mixto_2">
                                    <option value="">Seleccione la cuenta de pago</option>
                                    @foreach ($metodo_pago as $metodo_pagos)
                                        <option value="{{ $metodo_pagos->tipo_pago_nombre }}">
                                            {{ $metodo_pagos->tipo_pago_nombre }}
                                        </option>
                                    @endforeach
                                </x-select>
                                @error("inscripcion_caminata.$j.cuenta_mixto_2")
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- si pago en $ --}}
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            @if ($this->inscripcion_caminata[$j]['bolivar_mixto'] == '1')
                                <div class="mb-4">
                                    <x-label for="">Fecha del pago</x-label>
                                    <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                        wire:model="inscripcion_caminata.{{ $j }}.fecha_mixto" />
                                    @error("inscripcion_caminata.$j.fecha_mixto")
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <x-label for="">N° Referencia</x-label>
                                    <x-input class="w-full" min="6" max="6"
                                        placeholder="ultimos 6 digitos"
                                        wire:model="inscripcion_caminata.{{ $j }}.referencia_mixto" />
                                    @error("inscripcion_caminata.$j.referencia_mixto")
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <div class="mb-4">
                                        <x-label for="">Monto pagado Bs</x-label>
                                        <x-input type="number" step="0.01" class="w-full"
                                            wire:model="inscripcion_caminata.{{ $j }}.monto_mixto" />
                                        @error("inscripcion_caminata.$j.monto_mixto")
                                            <span class="error text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- si pago en bs --}}
                            @elseif($this->inscripcion_caminata[$j]['dolar_mixto'] == '2')
                                <div class="mb-4">
                                    <x-label for="">Fecha del pago</x-label>
                                    <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                        wire:model="inscripcion_caminata.{{ $j }}.fecha_mixto" />
                                    @error("inscripcion_caminata.$j.fecha_mixto")
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <x-label for="">N° Referencia</x-label>
                                    <x-input class="w-full" min="6" max="6"
                                        placeholder="ultimos 6 digitos"
                                        wire:model="inscripcion_caminata.{{ $j }}.referencia_mixto" />
                                    @error("inscripcion_caminata.$j.referencia_mixto")
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <div class="mb-4">
                                        <x-label for="">Monto pagado $</x-label>
                                        <x-input type="number" step="0.01" class="w-full"
                                            wire:model="inscripcion_caminata.{{ $j }}.monto_mixto" />
                                        @error("inscripcion_caminata.$j.monto_mixto")
                                            <span class="error text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
            <br>
        @endfor

        @for ($i = 0; $i <= $cantidad_carrera - 1; $i++)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white rounded-lg p-4 shadow">
            <div class="grid grid-cols-2 gap-4">

                <div class="mb-4">
                    <x-label for="">Cedula </x-label>
                    <x-input class="w-full" wire:model.change="participante_carrera.{{ $i }}.cedula"
                        wire:change="buscarCedula_carrera" />
                    @error("participante_carrera.$i.cedula")
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-label for="">Nombre</x-label>
                    <x-input class="w-full" wire:model="participante_carrera.{{ $i }}.nombre" />
                    @error("participante_carrera.$i.nombre")
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-label for="">Apellido</x-label>
                    <x-input class="w-full" wire:model="participante_carrera.{{ $i }}.apellido" />
                    @error("participante_carrera.$i.apellido")
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-label for="">Telefono</x-label>
                    <x-input class="w-full" wire:model="participante_carrera.{{ $i }}.telefono" />
                    @error("participante_carrera.$i.telefono")
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">Fecha de nacimiento</x-label>
                    <x-input class="w-full" type="date" max="{{ $this->fecha_evento }}"
                        wire:model="participante_carrera.{{ $i }}.fecha_nacimiento"
                        wire:click="edad(value.fecha_nacimiento)" />
                    @error("participante_carrera.$i.fecha_nacimiento")
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">Correo</x-label>
                    <x-input class="w-full" type="email"
                        wire:model="participante_carrera.{{ $i }}.correo" />
                    @error("participante_carrera.$i.correo")
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">Estado</x-label>
                    <x-select class="w-full"
                        wire:model.change="participante_carrera.{{ $i }}.estado_id">
                        <option value="">Seleccione un estado</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}"> {{ $estado->estado }}</option>
                        @endforeach
                    </x-select>
                </div>
                <div class="mb-4">
                    <x-label for="">Ciudad </x-label>
                    <x-select class="w-full" wire:model="participante_carrera.{{ $i }}.ciudad_id">
                        <option value="">Seleccione la ciudad</option>
                        @if (!empty($participante_carrera[$i]['ciudades']))
                            @foreach ($participante_carrera[$i]['ciudades'] as $ciudad)
                                <option value="{{ $ciudad->id }}">{{ $ciudad->ciudad }}</option>
                            @endforeach
                        @elseif(isset($this->participante[$i]) && !is_null($this->participante[$i]))
                            @foreach ($participante_carrera[$i]['ciudades'] as $ciudad)
                                <option value="{{ $ciudad->id }}"
                                    {{ $ciudad->id == $this->participante->ciudad_id ? 'selected' : '' }}>
                                    {{ $ciudad->ciudad }}</option>
                            @endforeach
                        @else
                        @endif

                    </x-select>
                    @error("participante_carrera.$i.ciudad_id")
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <x-label for="">Direccion</x-label>
                    <x-input class="w-full" wire:model="participante_carrera.{{ $i }}.direccion" />
                    @error("participante_carrera.$i.direccion")
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-label for="">Metodo realizado </x-label>
                    <x-select class="w-full"
                        wire:click="update_radio_carrera({{ $i }},$event.target.value)">
                        <option value="">Seleccione un pago</option>
                        <option value="1">Unico</option>
                        <option value="2">Mixto</option>
                    </x-select>
                </div>

            </div>
            {{-- cuando el pago es unico --}}
            @if (isset($this->inscripcion_carrera[$i]) && $this->inscripcion_carrera[$i]['unico'] == '1')
                <div>
                    <h1 class="font-semibold text-gray-700 leading-tight text-normal">Reporte de pago </h1>
                    <hr class="border-gray-300"><br>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-label for="">Pagos</x-label>
                            <x-select class="w-full"
                                wire:click="update_pago_carrera({{ $i }},$event.target.value)">
                                <option value="">Seleccione un pago</option>
                                <option value="1">Bolivares Bs</option>
                                <option value="2">Dolares $</option>
                            </x-select>
                        </div>
                        <div class="mb-4">
                            <x-label for="">Cuenta</x-label>
                            <x-select class="w-full"
                                wire:model="inscripcion_carrera.{{ $i }}.metodo_pago_id">
                                <option value="">Seleccione la cuenta de pago</option>
                                @foreach ($metodo_pago as $metodo_pagos)
                                    <option value="{{ $metodo_pagos->id }}">
                                        {{ $metodo_pagos->tipo_pago_nombre }}--/--{{ $metodo_pagos->banco_nombre }}
                                    </option>
                                @endforeach
                            </x-select>
                            @error("inscripcion_carrera.$i.metodo_pago_id")
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        {{-- si pago en $ --}}
                        @if ($this->inscripcion_carrera[$i]['bolivar'] == '1')
                            <div class="mb-4">
                                <x-label for="">Fecha del pago</x-label>
                                <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                    wire:model="inscripcion_carrera.{{ $i }}.fecha" />
                                @error("inscripcion_carrera.$i.fecha")
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">N° Referencia</x-label>
                                <x-input class="w-full" min="6" max="6"
                                    placeholder="ultimos 6 digitos"
                                    wire:model="inscripcion_carrera.{{ $i }}.referencia" />
                                @error("inscripcion_carrera.$i.referencia")
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <div class="mb-4">
                                    <x-label for="">Monto pagado Bs</x-label>
                                    <x-input type="number" step="0.01" class="w-full"
                                        wire:model="inscripcion_carrera.{{ $i }}.monto" />
                                    @error("inscripcion_carrera.$i.monto")
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- si pago en bs --}}
                        @elseif($this->inscripcion_carrera[$i]['dolar'] == '2')
                            <div class="mb-4">
                                <x-label for="">Fecha del pago</x-label>
                                <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                    wire:model="inscripcion_carrera.{{ $i }}.fecha" />
                                @error("inscripcion_carrera.$i.fecha")
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">N° Referencia</x-label>
                                <x-input class="w-full" min="6" max="6"
                                    placeholder="ultimos 6 digitos"
                                    wire:model="inscripcion_carrera.{{ $i }}.referencia" />
                                @error("inscripcion_carrera.$i.referencia")
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <div class="mb-4">
                                    <x-label for="">Monto pagado $</x-label>
                                    <x-input type="number" step="0.01" class="w-full"
                                        wire:model="inscripcion_carrera.{{ $i }}.monto" />
                                    @error("inscripcion_carrera.$i.monto")
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endif


                    </div>
                </div>
            @endif

            @if (isset($this->inscripcion_carrera[$i]) && $this->inscripcion_carrera[$i]['mixto'] == '2')
                {{-- cuando el pago es mixto --}}
                <div>
                    <h1 class="font-semibold text-gray-700 leading-tight text-normal normal-case">Reporte del pago
                        N° 1 </h1>
                    <hr class="border-gray-300"><br>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-label for="">Pagos</x-label>
                            <x-select class="w-full"
                                wire:click="update_pago_carrera({{ $i }},$event.target.value)">
                                <option value="">Seleccione un pago</option>
                                <option value="1">Bolivares Bs</option>
                                <option value="2">Dolares $</option>
                            </x-select>
                        </div>
                        <div class="mb-4">
                            <x-label for="">Cuenta</x-label>
                            <x-select class="w-full"
                                wire:model="inscripcion_carrera.{{ $i }}.cuenta_mixto_1">
                                <option value="">Seleccione la cuenta de pago</option>
                                @foreach ($metodo_pago as $metodo_pagos)
                                    <option value="{{ $metodo_pagos->tipo_pago_nombre }}">
                                        {{ $metodo_pagos->tipo_pago_nombre }}
                                    </option>
                                @endforeach
                            </x-select>
                            @error("inscripcion_carrera.$i.cuenta_mixto_1")
                                <span class="error text-red-500 ">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        {{-- si pago en $ --}}
                        @if ($this->inscripcion_carrera[$i]['bolivar'] == '1')
                            <div class="mb-4">
                                <x-label for="">Fecha del pago</x-label>
                                <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                    wire:model="inscripcion_carrera.{{ $i }}.fecha" />
                                @error("inscripcion_carrera.$i.fecha")
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">N° Referencia</x-label>
                                <x-input class="w-full" min="6" max="6"
                                    placeholder="ultimos 6 digitos"
                                    wire:model="inscripcion_carrera.{{ $i }}.referencia" />
                                @error("inscripcion_carrera.$i.referencia")
                                    <span class="error text-red-500 ">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <div class="mb-4">
                                    <x-label for="">Monto pagado Bs</x-label>
                                    <x-input type="number" step="0.01" class="w-full"
                                        wire:model="inscripcion_carrera.{{ $i }}.monto" />
                                    @error("inscripcion_carrera.$i.monto")
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- si pago en bs --}}
                        @elseif($this->inscripcion_carrera[$i]['dolar'] == '2')
                            <div class="mb-4">
                                <x-label for="">Fecha del pago</x-label>
                                <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                    wire:model="inscripcion_carrera.{{ $i }}.fecha" />
                                @error("inscripcion_carrera.$i.fecha")
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">N° Referencia</x-label>
                                <x-input class="w-full" min="6" max="6"
                                    placeholder="ultimos 6 digitos"
                                    wire:model="inscripcion_carrera.{{ $i }}.referencia" />
                                @error("inscripcion_carrera.$i.referencia")
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <div class="mb-4">
                                    <x-label for="">Monto pagado $</x-label>
                                    <x-input type="number" step="0.01" class="w-full"
                                        wire:model="inscripcion_carrera.{{ $i }}.monto" />
                                    @error("inscripcion_carrera.$i.monto")
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    </div>
                    <h1 class="font-semibold text-gray-700 leading-tight text-normal normal-case">Reporte del pago
                        N° 2 </h1>
                    <hr class="border-gray-300"><br>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-label for="">Pagos</x-label>
                            <x-select class="w-full"
                                wire:click="update_pago_mixto_carrera({{ $i }},$event.target.value)">
                                <option value="">Seleccione un pago</option>
                                <option value="1">Bolivares Bs</option>
                                <option value="2">Dolares $</option>
                            </x-select>
                        </div>
                        <div class="mb-4">
                            <x-label for="">Cuenta</x-label>
                            <x-select class="w-full"
                                wire:model="inscripcion_carrera.{{ $i }}.cuenta_mixto_2">
                                <option value="">Seleccione la cuenta de pago</option>
                                @foreach ($metodo_pago as $metodo_pagos)
                                    <option value="{{ $metodo_pagos->tipo_pago_nombre }}">
                                        {{ $metodo_pagos->tipo_pago_nombre }}
                                    </option>
                                @endforeach
                            </x-select>
                            @error("inscripcion_carrera.$i.cuenta_mixto_2")
                                <span class="error text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- si pago en $ --}}
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        @if ($this->inscripcion_carrera[$i]['bolivar_mixto'] == '1')
                            <div class="mb-4">
                                <x-label for="">Fecha del pago</x-label>
                                <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                    wire:model="inscripcion_carrera.{{ $i }}.fecha_mixto" />
                                @error("inscripcion_carrera.$i.fecha_mixto")
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">N° Referencia</x-label>
                                <x-input class="w-full" min="6" max="6"
                                    placeholder="ultimos 6 digitos"
                                    wire:model="inscripcion_carrera.{{ $i }}.referencia_mixto" />
                                @error("inscripcion_carrera.$i.referencia_mixto")
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <div class="mb-4">
                                    <x-label for="">Monto pagado Bs</x-label>
                                    <x-input type="number" step="0.01" class="w-full"
                                        wire:model="inscripcion_carrera.{{ $i }}.monto_mixto" />
                                    @error("inscripcion_carrera.$i.monto_mixto")
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- si pago en bs --}}
                        @elseif($this->inscripcion_carrera[$i]['dolar_mixto'] == '2')
                            <div class="mb-4">
                                <x-label for="">Fecha del pago</x-label>
                                <x-input type="date" class="w-full" max="{{ $this->fecha_actual }}"
                                    wire:model="inscripcion_carrera.{{ $i }}.fecha_mixto" />
                                @error("inscripcion_carrera.$i.fecha_mixto")
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-label for="">N° Referencia</x-label>
                                <x-input class="w-full" min="6" max="6"
                                    placeholder="ultimos 6 digitos"
                                    wire:model="inscripcion_carrera.{{ $i }}.referencia_mixto" />
                                @error("inscripcion_carrera.$i.referencia_mixto")
                                    <span class="error text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <div class="mb-4">
                                    <x-label for="">Monto pagado $</x-label>
                                    <x-input type="number" step="0.01" class="w-full"
                                        wire:model="inscripcion_carrera.{{ $i }}.monto_mixto" />
                                    @error("inscripcion_carrera.$i.monto_mixto")
                                        <span class="error text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
        <br>
    @endfor
        <div class="flex justify-end">
            <x-button>
                Agregar
            </x-button>
        </div>
    </form>

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
            Livewire.on('existe', (event) => {
                const cedula = event[0].cedula;
                const nombre= event[1].nombre;
                const apellido = event[2].apellido;
                console.log(cedula);
                console.log('Evento existe disparado:', cedula);
                Swal.fire({
                    title: "Advertencia!",
                    text: `El participante ${nombre} ${apellido} con cédula ${cedula} ya se encuentra inscrito!`,
                    icon: "warning"
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
