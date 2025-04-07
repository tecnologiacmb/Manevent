 <div>
     <div class="bg-white shadow rounded-lg p-2 mb-4">

         <form wire:submit="save">
             <div class="flex space-x-4 py-2">
                <h1 class="mt-2 font-black text-2xl text-gray-800 leading-tight text-normal">
                    Agregar el Precio del Dolar
                </h1>
                 <x-input placeholder="Precio del Dolar" type="number" step="0.01" wire:model="post_create.precio" />
                 <x-button>
                     agregar
                 </x-button>
             </div>
         </form>

         <form wire:submit="update">
             <x-dialog-modal wire:model="open_edit">
                 <x-slot name="title">
                     Actualizar Post
                 </x-slot>

                 <x-slot name="content">
                     <div class="mb-4" style="display: flex; justify-content: center; align-items: center;">
                         <x-label for="">Precio del dolar </x-label>
                         <x-input placeholder="Precio del Dolar" type="number" step="0.01"
                             wire:model="post_update.precio" />
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

     <div
         class="relative flex flex-col w-full h-full overflow-scroll text-black bg-white shadow-md rounded-xl bg-clip-border overflow-x-hidden overflow-y-hidden">


         <table class="w-full text-left table-auto min-w-max">
             <thead>
                 <tr>
                     <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                         <p
                             class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                             Id
                         </p>
                     </th>
                     <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                         <p
                             class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                             Precio del Dolar
                         </p>
                     </th>
                     <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                         <p
                             class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                             Fecha
                         </p>
                     </th>
                     @can('ver-admin')
                         <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                             <p
                                 class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                                 Acciones
                             </p>
                         </th>
                     @endcan

                 </tr>
             </thead>

             <tbody>
                 <tr>
                     @foreach ($posts as $post)
                         <td class="p-4 border-b border-blue-gray-50">
                             <p
                                 class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                 {{ $post->id }}
                             </p>
                         </td>

                         <td class="p-4 border-b border-blue-gray-50">
                             <p
                                 class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                 {{ $post->precio }} Bs
                             </p>
                         </td>
                         <td class="p-4 border-b border-blue-gray-50">
                             <p
                                 class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                 {{ $post->created_at }}
                             </p>
                         </td>
                         @can('ver-admin')
                             <td class="p-4 border-b border-blue-gray-50 space-x-8">
                                 <x-button class="bg-blue-500" wire:click="edit({{ $post->id }})">
                                     <i class="bi bi-pencil-square"></i>
                                 </x-button>


                                 <x-danger-button wire:click="confirm_delete({{ $post->id }})">
                                     <i class="bi bi-trash-fill"></i>
                                 </x-danger-button>

                             </td>
                         @endcan
                 </tr>
                 @endforeach
             </tbody>
         </table>
     </div>

     <div>
         {{ $posts->links() }}
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
