<div>

    <style>
        #card1 {
            display: block;
        }

        #card2,
        #card3 {
            display: none;
        }
    </style>
    <div>
        <div class="bg-white shadow rounded-lg p-4 mb-4">
            <h1 class="font-black text-xl text-gray-800 leading-tight text-normal">
                Selecione un Grupo para la Caminata
            </h1>

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
                            </p>

                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                1
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                asd
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                50
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                20 $
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <p
                                class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                1600 Bs
                            </p>
                        </td>

                        <td class="p-4 border-b border-blue-gray-50">
                            <x-button class="bg-blue-500"><a href="#"
                                    class="block font-sans text-sm antialiased font-medium leading-normal text-blue-gray-900">
                                    Seleccionar
                                </a></x-button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
    <select name="" id="slct" onchange="showOnChange(event)">
        <option value="card1">card1</option>
        <option value="card2">card2</option>
        <option value="card3">card3</option>
    </select>
    <div id="card1">card1</div>
    <div id="card2">card2</div>
    <div id="card3">card3</div>
</div>



<script>
    function showOnChange(e) {
        var elem = document.getElementById("slct");
        var value = elem.options[elem.selectedIndex].value;
        if (value == "card1") {
            document.getElementById('card1').style.display = "block";
            document.getElementById('card2').style.display = "none";
            document.getElementById('card3').style.display = "none";
        } else if (value == "card2") {
            document.getElementById('card1').style.display = "none";
            document.getElementById('card2').style.display = "block";
            document.getElementById('card3').style.display = "none";
        } else if (value == "card3") {
            document.getElementById('card1').style.display = "none";
            document.getElementById('card2').style.display = "none";
            document.getElementById('card3').style.display = "block";
        }

    }
</script>

</div>
