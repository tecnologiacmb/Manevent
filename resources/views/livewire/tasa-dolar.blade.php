 <div>

     <div class="w-full max-[500px]:w-full mb-2">
         <div
             class="flex group w-full h-24 rounded-lg bg-white shadow transition relative duration-300 cursor-pointer hover:translate-y-[3px] hover:shadow-[0_-8px_0px_0px_#000000] items-center justify-between">
             <div>
                 <img src="{{ asset('storage/image/dolar.png') }}" alt="Imagen de dolar almacenada en storage"
                     class="pt-8 group-hover:opacity-100 absolute left-[8%] top-[30%] translate-y-[-50%] opacity-50 transition group-hover:scale-110 duration-300 w-20">
             </div>
             <div class="pr-24">
                 <form wire:submit="save">
                     <div class="flex space-x-4 ">
                         <h1 class="mt-2 font-black text-2xl text-gray-800 leading-tight text-normal">
                             Registrar Precio del Dolar
                         </h1>
                         <x-input placeholder="Precio del Dolar" type="number" step="0.01"
                             wire:model.live="post_create.precio" />

                         <x-button class="ml-2 hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300"
                             wire:click="validar_registro()">
                             Registrar
                         </x-button>

                     </div>
                     <div class="flex justify-center mr-32">
                         @error('post_create.precio')
                             <span class="text-center error text-red-500">{{ $message }}</span>
                         @enderror
                     </div>
                 </form>
             </div>

         </div>
     </div>
     <div
         class="relative flex flex-col w-full h-full overflow-scroll text-black bg-white shadow-md rounded-xl bg-clip-border overflow-x-hidden overflow-y-hidden">
         <table class="w-full text-center table-auto min-w-max">
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
                             <td class="p-4 border-b border-blue-gray-50 mx-2">
                                 <x-button class="bg-blue-500 hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300"
                                     wire:click="edit({{ $post->id }})">
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
     <form wire:submit="update">
         <x-dialog-modal wire:model="open_edit">
             <x-slot name="title">
                 Actualizar Dolar
             </x-slot>
             <x-slot name="content">
                 <div class="mb-4">
                     <x-label for="">Precio del dolar </x-label>
                     <x-input class="w-full" placeholder="Precio del Dolar" type="number" step="0.01"
                         wire:model="post_update.precio" />
                 </div>
             </x-slot>
             <x-slot name="footer">
                 <div class="flex justify-end">
                     <x-danger-button class="mr-2" wire:click="$set('open_edit',false)">
                         Cancelar
                     </x-danger-button>
                     <x-button class="hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300"
                         wire:click="validar_actualizacion()">
                         Actualizar
                     </x-button>
                 </div>
             </x-slot>
         </x-dialog-modal>
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
