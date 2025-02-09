<x-self.base>
    <div class="container mx-auto px-4 py-8">
        <!-- Barra de búsqueda y botón de creación -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <div class="flex items-center mb-4 sm:mb-0">
                <x-input placeholder="Buscar..." wire:model.live="buscar">
                    <i class="ml-2 fas fa-search text-gray-500"></i>
                </x-input>
            </div>
            <div>
                @livewire('create-user-posts')
            </div>
        </div>
        <!-- Tabla con diseño espectacular -->
        @if ($orders->count())
            <div class="relative overflow-x-auto shadow-2xl rounded-xl bg-white dark:bg-gray-900">
                <table class="min-w-full divide-y divide-gray-200">
                    <!-- Encabezado de la tabla con un degradado llamativo -->
                    <thead class="bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 text-white">
                        <tr>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider cursor-pointer"
                                wire:click="ordenar('nombre')">
                                Nombre <i class="ml-2 fas fa-sort"></i></th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider cursor-pointer"
                                wire:click="ordenar('cantidad')">
                                Cantidad <i class="ml-2 fas fa-sort"></i></th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider cursor-pointer"
                                wire:click="ordenar('estado')">
                                Estado <i class="ml-2 fas fa-sort"></i></th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Acciones</th>
                        </tr>
                    </thead>
                    <!-- Cuerpo de la tabla -->
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        <!-- Fila 1 -->
                        @foreach ($orders as $item)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-white">
                                    {{ $item->nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-white">{{ $item->cantidad }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button @class([
                                        'p-2 rounded-xl text-white font-bold',
                                        'bg-red-500 hover:bg-red-600' => $item->estado == 'Pendiente',
                                        'bg-green-500 hover:bg-green-600' => $item->estado == 'Procesado',
                                    ])
                                        wire:click="modificarEstado({{ $item->id }})">
                                        {{ $item->estado }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button wire:click="edit({{$item->id}})"
                                        class="text-blue-500 hover:text-blue-700 mr-2 transition-colors duration-200">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="confirmarDelete({{ $item->id }})"
                                        class="text-red-500 hover:text-red-700 transition-colors duration-200">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
    <div class="mt-2">
        {{ $orders->links() }}
    </div>
@else
    <div class="bg-green-400 text-center text-white p-2 rounded-xl font-bold mt-2">
        No se ha encontrado ningun pedido o no has escrito ninguno.
    </div>
    @endif
    <!---------------------------Modal para editar orders------------------------->
    @isset($uform->orders)
    <x-dialog-modal wire:model="openUpdate">
        <x-slot name="title">
            Editar Orders
        </x-slot>
        <x-slot name="content">
            <h2 class="text-xl font-semibold mb-4 text-center">Formulario</h2>

            <!-- Campo Título -->
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-heading mr-2"></i> Título
                </label>
                <input type="text" id="nombre" name="nombre" wire:model="uform.nombre"
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <x-input-error for="uform.nombre"></x-input-error>
            </div>

            <!-- Campo Cantidad (Decimal) -->
            <div class="mb-4">
                <label for="cantidad" class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-sort-numeric-up-alt mr-2"></i> Cantidad
                </label>
                <input type="number" step="0.01" id="cantidad" name="cantidad" wire:model="uform.cantidad"
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <x-input-error for="uform.cantidad"></x-input-error>
            </div>

            <!-- Campo Estado (Radio Buttons) -->
            <div class="mb-4">
                <span class="block text-gray-700 font-medium mb-2">
                    <i class="fas fa-toggle-on mr-2"></i> Estado
                </span>
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="uform.estado" name="estado" value="Procesado"
                            class="form-radio text-blue-600">
                        <span class="ml-2">Procesado</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="uform.estado" name="estado" value="Pendiente"
                            class="form-radio text-blue-600">
                        <span class="ml-2">Pendiente</span>
                    </label>
                </div>
                <x-input-error for="uform.estado"></x-input-error>
            </div>

            <!-- Botones -->
            <div class="flex justify-between mt-6">
                <button type="button" wire:click="cancelar()"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="submit" wire:click="update" wire:loading.attr="disabled"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    <i class="fas fa-paper-plane"></i> Enviar
                </button>
            </div>
        </x-slot>
        <x-slot name="footer">

        </x-slot>
    </x-dialog-modal>
    @endisset
</x-self.base>
