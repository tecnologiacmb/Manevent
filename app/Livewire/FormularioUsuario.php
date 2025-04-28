<?php

namespace App\Livewire;

use App\Enum\Mesas_enum;
use App\Models\ciudad;
use App\Models\estado;
use App\Models\evento;
use App\Models\participante;
use App\Models\categoriaHabilitada;
use App\Models\genero;
use App\Models\inscripcion;
use App\Models\numero;
use Livewire\Component;
use Carbon\Carbon;

class FormularioUsuario extends Component
{
    public $post_edit_id;
    public $post_update = [
        'nombre' => "",
        'apellido' => "",
        'cedula' => "",
        'telefono' => "",
        'correo' => "",
        'direccion' => "",
        'ciudad_id' => null,
        'estado_id' => null,
        'fecha_nacimiento' => "",
        'ciudades' => [],
        'genero_id' => null,
    ];
    public $post_update_categoria = [
        'categoria_habilitada_id' => null,
    ];
    public $participantes = null;
    public $estados;
    public $ciudad;
    public $categoria_habilitada;
    public $evento;
    public $fecha_evento;
    public $generos;
    protected $listeners = ['delete'];

    public function mount($id = null)
    {
        if (!is_null($id)) {
            $this->estados = estado::all();
            $this->generos = genero::all();
            $this->evento = evento::select('id', 'nombre', 'fecha_evento')->where('estado', true)->orderBy('id', 'desc')->first();
            $this->subtractYears();

            $this->categoria_habilitada = categoriaHabilitada::all();
            $this->post_edit_id = $id;
            $post = participante::join('generos', 'participantes.genero_id', '=', 'generos.id')->find($this->post_edit_id);
            $this->post_update["nombre"] = $post->nombre;
            $this->post_update["apellido"] = $post->apellido;
            $this->post_update["cedula"] = $post->cedula;
            $this->post_update["telefono"] = $post->telefono;
            $this->post_update["correo"] = $post->correo;
            $this->post_update["direccion"] = $post->direccion;
            $this->post_update["genero_id"] = $post->genero_id;
            $this->post_update["fecha_nacimiento"] = $post->fecha_nacimiento;
            $ciudad = ciudad::find($post->ciudad_id);
            if ($ciudad) {
                $this->post_update["estado_id"] = $ciudad->estado_id;
                $this->post_update['ciudades'] = ciudad::where('estado_id', $ciudad->estado_id)->get();
                $this->post_update["ciudad_id"] = $ciudad->id;
            }
        }
    }

    public function subtractYears()
    {
        $this->fecha_evento = Carbon::parse($this->evento->fecha_evento)->subYears(15)->format('Y-m-d');
    }
    public function edad($fecha_nacimiento)
    {
        $fecha_nacimiento = Carbon::parse($fecha_nacimiento)->format('Y-m-d');
        $ahora = Carbon::parse($this->evento->fecha_evento)->format('Y-m-d');
        $edad = Carbon::parse($ahora)->diffInYears(Carbon::parse($fecha_nacimiento));
        foreach ($this->categoria_habilitada as $categoria_habilitadas) {
            if ($edad >= $categoria_habilitadas->edad_min && $edad <= $categoria_habilitadas->edad_max) {
                return $categoria_habilitadas->id;
            }
        }
        return null;
    }
    public function updatedPostUpdate($value, $name)
    {
        $parts = explode('.', $name);
        $field = $parts[0];
        if ($field === 'estado_id') {
            $this->post_update['ciudades'] = ciudad::where('estado_id', $value)->get();
            $this->post_update['ciudad_id'] = null;
        }
    }
    public function rules(): array
    {
        return [
            "post_update.nombre" => 'required|string|max:49|regex:/^[a-zA-Z\s]+$/',
            "post_update.apellido" => 'required|string|max:49|regex:/^[a-zA-Z\s]+$/',
            "post_update.cedula" => 'required|string|digits:8|regex:/^[0-9]+$/',
            "post_update.telefono" => 'required|string|digits:11|regex:/^[0-9]+$/',
            "post_update.correo" => 'required|email|max:60',
            "post_update.direccion" => 'required|string|max:100',
            "post_update.ciudad_id" => 'required|integer',
            "post_update.estado_id" => 'required|integer',
            "post_update.fecha_nacimiento" => 'required|date|before_or_equal:' . $this->fecha_evento,
            "post_update.genero_id" => 'required|integer',
        ];
    }
    public function messages(): array
    {
        return [
            "post_update.nombre.required" => __('El campo nombre es obligatorio.'),
            "post_update.nombre.string" => __('El campo nombre debe ser una cadena de texto.'),
            "post_update.nombre.max" => __('El campo nombre no debe ser mayor a 49 letras.'),
            "post_update.nombre.regex" => __('El campo nombre solo acepta letras.'),

            "post_update.apellido.required" => __('El campo apellido es obligatorio.'),
            "post_update.apellido.string" => __('El campo apellido debe ser una cadena de texto.'),
            "post_update.apellido.max" => __('El campo apellido no debe ser mayor a 49 letras.'),
            "post_update.apellido.regex" => __('El campo apellido solo acepta letras.'),

            "post_update.cedula.required" => __('El campo cedula es obligatorio.'),
            "post_update.cedula.string" => __('El campo cedula debe ser una cadena de texto.'),
            "post_update.cedula.regex" => __('Este campo solo acepta numeros.'),
            "post_update.cedula.max" => __('El campo cedula no debe ser mayor a 8 digitos.'),

            "post_update.telefono.required" => __('El campo telefono es obligatorio.'),
            "post_update.telefono.string" => __('El campo telefono debe ser una cadena de texto.'),
            "post_update.telefono.regex" => __('Este campo solo acepta numeros.'),
            "post_update.telefono.max" => __('El campo telefono no debe ser mayor a 11 digitos.'),

            "post_update.correo.required" => __('El campo correo es obligatorio.'),
            "post_update.correo.email" => __('El campo correo debe tener la sintaxis correcta.'),
            "post_update.correo.max" => __('El campo correo no debe ser mayor a 60 letras.'),

            "post_update.direccion.required" => __('El campo direccion es obligatorio.'),
            "post_update.direccion.string" => __('El campo direccion debe ser una cadena de texto.'),
            "post_update.direccion.max" => __('El campo direccion no debe ser mayor a 100 letras.'),

            "post_update.ciudad_id.required" => __('El campo ciudad es obligatorio.'),
            "post_update.ciudad_id.integer" => __('El campo ciudad debe ser un numero.'),

            "post_update.estado_id.required" => __('El campo estado es obligatorio.'),
            "post_update.estado_id.integer" => __('El campo estado debe ser un numero.'),

            "post_update.fecha_nacimiento.required" => __('El campo fecha de nacimiento es obligatorio.'),
            "post_update.fecha_nacimiento.date" => __('El campo fecha de nacimiento debe tener el formato correcto.'),
            "post_update.fecha_nacimiento.before_or_equal" => __('El campo fecha de nacimiento debe ser menor o igual a ' . Carbon::parse($this->fecha_evento)->format('d-m-Y')),
            "post_update.genero_id.required" => __('El campo genero es obligatorio.'),
            "post_update.genero_id.integer" => __('El campo genero debe ser un numero.'),
        ];
    }
    public function asignar_num_mesa_caminata($inscripcion_id, $cedula)
    {
        $ultimo_digito = substr($cedula, -1);

        $inscripcion = inscripcion::find($inscripcion_id);
        if ($ultimo_digito == '0' || $ultimo_digito == '1' || $ultimo_digito == '2' || $ultimo_digito == '3' || $ultimo_digito == '4') {

            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [701, 850])->orderBy('id', 'asc')->first();

            if (!is_null($numero_id)) {

                $inscripcion->numero_id = $numero_id->id;
                $inscripcion->mesa_id = Mesas_enum::Mesa_6;
                $inscripcion->save();
                /* update numero asignado */
                $numero = numero::find($numero_id->id);
                $numero->disponible = false;
                $numero->save();
            } else {
                $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [501, 700])->orderBy('id', 'asc')->first();
                $inscripcion->numero_id = $numero_id->id;
                $inscripcion->mesa_id = Mesas_enum::Mesa_8;
                $inscripcion->save();
                /* update numero asignado */
                $numero = numero::find($numero_id->id);
                $numero->disponible =
                $numero->save();
            }


            /* logica asignacion de numeros y mesa*/
        } else if ($ultimo_digito == '5' || $ultimo_digito == '6' || $ultimo_digito == '7' || $ultimo_digito == '8' || $ultimo_digito == '9') {
            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [851, 999])->orderBy('id', 'asc')->first();
            if (!is_null($numero_id)) {
                $inscripcion->numero_id = $numero_id->id;
                $inscripcion->mesa_id = Mesas_enum::Mesa_7;
                $inscripcion->save();
                /* update numero asignado */
                $numero = numero::find($numero_id->id);
                $numero->disponible = false;
                $numero->save();
            } else {
                $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [501, 700])->orderBy('id', 'asc')->first();
                $inscripcion->numero_id = $numero_id->id;
                $inscripcion->mesa_id = Mesas_enum::Mesa_8;
                $inscripcion->save();
                /* update numero asignado */
                $numero = numero::find($numero_id->id);
                $numero->disponible = false;
                $numero->save();
            }

            /* logica asignacion de numeros y mesa*/
        }
    }
    public function asignar_num_mesa_carrera($inscripcion_id, $cedula)
    {

        $ultimo_digito = substr($cedula, -1);

        $inscripcion = inscripcion::find($inscripcion_id);
        if ($ultimo_digito == '0' || $ultimo_digito == '1') {
            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [1, 100])->orderBy('id', 'asc')->first();

            /* logica asignacion de numeros y mesa*/

            if (!is_null($numero_id)) {
                $inscripcion->numero_id = $numero_id->id;
                $inscripcion->mesa_id = Mesas_enum::Mesa_1;
                $inscripcion->save();
                /* update numero asignado */
                $numero = numero::find($numero_id->id);
                $numero->disponible = false;
                $numero->save();
            } else {
                $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [501, 700])->orderBy('id', 'asc')->first();
                $inscripcion->numero_id = $numero_id->id;
                $inscripcion->mesa_id = Mesas_enum::Mesa_8;
                $inscripcion->save();
                /* update numero asignado */
                $numero = numero::find($numero_id->id);
                $numero->disponible = false;
                $numero->save();
            }
        } else if ($ultimo_digito == '2' || $ultimo_digito == '3') {
            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [101, 200])->orderBy('id', 'asc')->first();

            /* logica asignacion de numeros y mesa*/
            if (!is_null($numero_id)) {
                $inscripcion->numero_id = $numero_id->id;
                $inscripcion->mesa_id = Mesas_enum::Mesa_2;
                $inscripcion->save();
                /* update numero asignado */
                $numero = numero::find($numero_id->id);
                $numero->disponible = false;
                $numero->save();
            } else {
                $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [501, 700])->orderBy('id', 'asc')->first();
                $inscripcion->numero_id = $numero_id->id;
                $inscripcion->mesa_id = Mesas_enum::Mesa_8;
                $inscripcion->save();
                /* update numero asignado */
                $numero = numero::find($numero_id->id);
                $numero->disponible = false;
                $numero->save();
            }
        } else if ($ultimo_digito == '4' || $ultimo_digito == '5') {
            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [201, 300])->orderBy('id', 'asc')->first();

            if (!is_null($numero_id)) {
                $inscripcion->numero_id = $numero_id->id;
                $inscripcion->mesa_id = Mesas_enum::Mesa_3;
                $inscripcion->save();
                /* update numero asignado */
                $numero = numero::find($numero_id->id);
                $numero->disponible = false;
                $numero->save();
            } else {
                $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [501, 700])->orderBy('id', 'asc')->first();
                $inscripcion->numero_id = $numero_id->id;
                $inscripcion->mesa_id = Mesas_enum::Mesa_8;
                $inscripcion->save();
                /* update numero asignado */
                $numero = numero::find($numero_id->id);
                $numero->disponible = false;
                $numero->save();
            }
            /* logica asignacion de numeros y mesa*/
        } else if ($ultimo_digito == '6' || $ultimo_digito == '7') {
            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [301, 400])->orderBy('id', 'asc')->first();

            /* logica asignacion de numeros y mesa*/
            if (!is_null($numero_id)) {
                $inscripcion->numero_id = $numero_id->id;
                $inscripcion->mesa_id = Mesas_enum::Mesa_4;
                $inscripcion->save();
                /* update numero asignado */
                $numero = numero::find($numero_id->id);
                $numero->disponible = false;
                $numero->save();
            } else {
                $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [501, 700])->orderBy('id', 'asc')->first();
                $inscripcion->numero_id = $numero_id->id;
                $inscripcion->mesa_id = Mesas_enum::Mesa_8;
                $inscripcion->save();
                /* update numero asignado */
                $numero = numero::find($numero_id->id);
                $numero->disponible = false;
                $numero->save();
            }
        } else if ($ultimo_digito == '8' || $ultimo_digito == '9') {
            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [401, 500])->orderBy('id', 'asc')->first();

            /* logica asignacion de numeros y mesa*/
            if (!is_null($numero_id)) {
                $inscripcion->numero_id = $numero_id->id;
                $inscripcion->mesa_id = Mesas_enum::Mesa_5;
                $inscripcion->save();
                /* update numero asignado */
                $numero = numero::find($numero_id->id);
                $numero->disponible = false;
                $numero->save();
            } else {
                $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [501, 700])->orderBy('id', 'asc')->first();
                $inscripcion->numero_id = $numero_id->id;
                $inscripcion->mesa_id = Mesas_enum::Mesa_8;
                $inscripcion->save();
                /* update numero asignado */
                $numero = numero::find($numero_id->id);
                $numero->disponible = false;
                $numero->save();
            }
        }
    }
    public function update()
    {
        $this->validate();
        $posts = participante::find($this->post_edit_id);
        $this->post_update['fecha_nacimiento'] = Carbon::parse($this->post_update['fecha_nacimiento'])->format('Y-m-d');
        $posts->update([
            'cedula' => $this->post_update['cedula'],
            'nombre' => $this->post_update['nombre'],
            'apellido' => $this->post_update['apellido'],
            'correo' => $this->post_update['correo'],
            'direccion' => $this->post_update['direccion'],
            'telefono' => $this->post_update['telefono'],
            'genero_id' => $this->post_update['genero_id'],
            'fecha_nacimiento' => $this->post_update['fecha_nacimiento'],
            'ciudad_id' => $this->post_update['ciudad_id'],
        ]);
        $categoria_id = $this->edad($posts->fecha_nacimiento);
        $this->post_update_categoria['categoria_habilitada_id'] = $categoria_id;
        // Verifica si hay inscripciones para el participante específico
        $inscripcion_recorrido = inscripcion::where('participante_id', $posts->id)
            ->whereIn('recorrido_id', [1, 2]) // Busca inscripciones con recorrido_id 1 o 2
            ->latest('id') // Ordena por ID más reciente
            ->first(); // Obtiene la más reciente

        if ($inscripcion_recorrido) {
            if ($inscripcion_recorrido->recorrido_id == 1) {
                $this->asignar_num_mesa_caminata($inscripcion_recorrido->id, $this->post_update['cedula']);
            } elseif ($inscripcion_recorrido->recorrido_id == 2) {
                $this->asignar_num_mesa_carrera($inscripcion_recorrido->id, $this->post_update['cedula']);
            }
        } else {
            echo "No se encontró ninguna inscripción para el participante.";
        }

        $inscripcion = inscripcion::where('participante_id', $posts->id)->first();
        $inscripcion->update([
            'categoria_habilitada_id' => $this->post_update_categoria['categoria_habilitada_id']
        ]);
        $this->dispatch('alert_update');
    }
    public function confirm_delete($delete_id)
    {
        $this->dispatch('alert_delete', $delete_id);
    }
    public function delete($delete_id)
    {
        $post = participante::find($delete_id);
        $post->delete();
    }
    public function render()
    {
        return view('livewire.formulario-usuario');
    }
}
