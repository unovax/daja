<div
    class="p-2 flex-1 overflow-hidden flex flex-col items-start"
    x-data="{
        nextInput(id) {
            setTimeout(() => {
                document.getElementById(id).focus()
            }, 300)
        }
    }"
    x-init="
        $wire.on('nextInput', (index) => {
           nextInput('inventory_details.'+index+'.quantity');
        })
    ">
    <x-filters-component>
        <x-primary-button class="w-full md:w-auto" wire:click="$toggle('inventoryModal')">
            Crear nuevo inventario
        </x-primary-button>
        <x-search-component wire:model.debounce.500ms="search"/>
    </x-filters-component>
    <div class="overflow-auto flex-1 w-full my-2">
        <table>
            <thead>
                <tr>
                    <th class="w-1/12 text-center">Acciones</th>
                    <th class="w-[10%]">Folio</th>
                    <th class="w-[10%]">Fecha</th>
                    <th>Ubicacion</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($inventories as $i)
                    <tr>
                        <td>
                            <x-icons-container-component>
                                <x-icons.edit wire:click="setInventoryToEdit({{ $i->id }})" class="icon__pointer "/>
                                <x-icons.delete wire:click="setInventoryToDelete({{ $i->id }})" class="icon__pointer "/>
                            </x-icons-container-component>
                        </td>
                        <td>{{ $i->folio }}</td>
                        <td>{{ $i->date }}</td>
                        <td>{{ $i->ubication?->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            {{ $search ? 'No se encontraron resultados' : 'No hay inventarios registrados' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <x-paginator-component>
        <x-paginator-select-component wire:model="size_page" />
        {{ $inventories->links() }}
    </x-paginator-component>
    <x-dialog-modal maxWidth="3xl" wire:model="inventoryModal">
        <x-slot name="title">{{ $inventory['id'] ? 'Editar inventario' : 'Crear inventario' }}</x-slot>
        <x-slot name="content">
            <div class="flex flex-col md:flex-row items-center gap-2 mb-2">
                <x-select-component
                    for="inventory.ubication_id"
                    label="Seleccione una ubicación"
                    wire:model.defer="inventory.ubication_id"
                    :items="$ubications"
                >
                    <x-slot name="buttonSlot">
                        <x-icons.add wire:click="$toggle('ubicationModal')" class="icon__pointer"/>
                    </x-slot>
                </x-select-component>
                <x-input
                    for="inventory.date"
                    label="Fecha"
                    wire:model.defer="inventory.date"
                    type="datetime-local"
                />
            </div>
            <x-divider-component>Agregar productos</x-divider-component>
            <x-search-list-component
                wire:keyup.debounce.500ms="searchProducts"
                wire:model.defer="product_name"
                :items="$products"
                input_id="product_search_input"
                for="inventory_details"
                placeholder="Buscar producto"
                event="addProduct"
            />
            @if ($inventory_details)
                <div class="w-full overflow-auto">
                    <table class="mt-2">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th class="hidden md:table-cell">Cantidad</th>
                                <th class="hidden md:table-cell">Unidad</th>
                                <th class="hidden md:table-cell">Color</th>
                                <th colspan="3" class="md:hidden">
                                    Informacion
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventory_details as $key => $detail)
                                <tr>
                                    <td>{{ $detail['product']['name'] }}</td>
                                    <td class="block md:table-cell">
                                        <x-input
                                            label="Cantidad"
                                            label_class="md:hidden"
                                            input_id="inventory_details.{{ $key }}.quantity"
                                            wire:model.defer="inventory_details.{{ $key }}.quantity"
                                            x-on:keydown.enter="nextInput('inventory_details.{{ $key }}.unit_id')"
                                        />
                                    </td>
                                    <td class="block md:table-cell">
                                        <x-select-component
                                            label="Unidad"
                                            label_class="md:hidden"
                                            input_id="inventory_details.{{ $key }}.unit_id"
                                            wire:model.defer="inventory_details.{{ $key }}.unit_id"
                                            x-on:keydown.enter="nextInput('inventory_details.{{ $key }}.color')"
                                            :items="$units"
                                        />
                                    </td>
                                    <td class="block md:table-cell">
                                        <x-input
                                            label="Color"
                                            label_class="md:hidden"
                                            input_id="inventory_details.{{ $key }}.color"
                                            wire:model.defer="inventory_details.{{ $key }}.color"
                                            x-on:keydown.enter="nextInput('product_search_input')"
                                        />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-primary-button wire:click="saveInventory">Aceptar</x-primary-button>
            <x-danger-button wire:click="erase">Cancelar</x-danger-button>
        </x-slot>
    </x-dialog-modal>
    <x-confirmation-modal wire:model="deleteInventoryModal">
        <x-slot name="title">Eliminar inventario</x-slot>
        <x-slot name="content">¿Está seguro que desea eliminar esta inventario?</x-slot>
        <x-slot name="footer">
            <x-danger-button wire:click="deleteInventory">Aceptar</x-danger-button>
            <x-primary-button wire:click="erase">Cancelar</x-primary-button>
        </x-slot>
    </x-confirmation-modal>
    <x-dialog-modal wire:model="ubicationModal">
        <x-slot name="title">Crear ubicación</x-slot>
        <x-slot name="content">
            <x-input type="text" wire:model.defer="ubication.code" for="ubication.code" label="Código" />
            <x-input type="text" wire:model.defer="ubication.name" for="ubication.name" label="Nombre" />
        </x-slot>
        <x-slot name="footer">
            <x-primary-button wire:click="createUbication">Aceptar</x-primary-button>
            <x-danger-button wire:click="eraseUbicationData">Cancelar</x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
