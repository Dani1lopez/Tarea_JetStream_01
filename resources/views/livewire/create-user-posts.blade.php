<div>
    <x-button wire:click="$set('openModalCrear',true)">
        <i class="fas fa-plus mr-2"></i>Crear
    </x-button>
    <x-dialog-modal wire:model="openModalCrear">
        <x-slot name="title">
            Nueva Order
        </x-slot>
        <x-slot name="content">
            <h2 class="text-xl font-semibold mb-4 text-center">Formulario</h2>

        <!-- Campo Título -->
        <div class="mb-4">
            <label for="nombre" class="block text-gray-700 font-medium mb-2">
                <i class="fas fa-heading mr-2"></i> Título
            </label>
            <input type="text" id="nombre" name="nombre" wire:model="cform.nombre"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" >
                <x-input-error for="cform.nombre"></x-input-error>
        </div>

        <!-- Campo Cantidad (Decimal) -->
        <div class="mb-4">
            <label for="cantidad" class="block text-gray-700 font-medium mb-2">
                <i class="fas fa-sort-numeric-up-alt mr-2"></i> Cantidad
            </label>
            <input type="number" step="0.01" id="cantidad" name="cantidad" wire:model="cform.cantidad"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" >
                <x-input-error for="cform.cantidad"></x-input-error>
        </div>

        <!-- Campo Estado (Radio Buttons) -->
        <div class="mb-4">
            <span class="block text-gray-700 font-medium mb-2">
                <i class="fas fa-toggle-on mr-2"></i> Estado
            </span>
            <div class="flex items-center space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" wire:model="cform.estado" name="estado" value="Procesado" class="form-radio text-blue-600" >
                    <span class="ml-2">Procesado</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" wire:model="cform.estado" name="estado" value="Pendiente" class="form-radio text-blue-600" >
                    <span class="ml-2">Pendiente</span>
                </label>
            </div>
            <x-input-error for="cform.estado"></x-input-error>
        </div>

        <!-- Botones -->
        <div class="flex justify-between mt-6">
            <button type="button" wire:click="cancelar" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <button type="reset" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                <i class="fas fa-undo"></i> Reset
            </button>
            <button type="submit" wire:click="store" wire:loading.attr="disabled" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                <i class="fas fa-paper-plane"></i> Enviar
            </button>
        </div>
        </x-slot>
        <x-slot name="footer">

        </x-slot>
    </x-dialog-modal>
</div>
