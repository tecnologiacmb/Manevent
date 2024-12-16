 <div>
     <div class="bg-white shadow rounded-lg p-2 mb-4">
         <h1 class="font-black text-2xl text-gray-800 leading-tight text-normal">
             Agregar el Precio del Dolar
         </h1>
         <hr>
         <form wire:submit="save">


             <div class="flex justify-center space-x-4 py-2">
                 <x-input placeholder="Precio del Dolar" type="number" step="0.01" wire:model="postCreate.precio" />
                 <x-button>
                     agregar
                 </x-button>
             </div>

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
                     <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                         <p
                             class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
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

                         <td class="p-4 border-b border-blue-gray-50">
                             <a href="#"
                                 class="block font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900">
                                 Edit
                             </a>
                         </td>
                 </tr>
                 @endforeach

             </tbody>
         </table>

     </div>
     <div>
         {{ $posts->links() }}
     </div>
 </div>
