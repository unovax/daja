<div
    class="p-2 flex-1 overflow-hidden flex flex-col items-start">
    <x-filters-component>
        <x-primary-button wire:click="$toggle('unitModal')">
            Crear nueva unidad de medida
        </x-primary-button>
        <x-search-component wire:model.debounce.500ms="search"/>
    </x-filters-component>
    <div class="overflow-auto flex-1 w-full my-2">
        <table>
            <thead>
                <tr>
                    <th class="w-1/12 text-center">Acciones</th>
                    <th>Código</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($units as $u)
                    <tr>
                        <td>
                            <x-icons-container-component>
                                <x-icons.edit wire:click="setUnitToEdit({{ $u->id }})" class="icon__pointer "/>
                                <x-icons.delete wire:click="setUnitToDelete({{ $u->id }})" class="icon__pointer "/>
                            </x-icons-container-component>
                        </td>
                        <td>{{ $u->code }}</td>
                        <td>{{ $u->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No hay unidades de medida registradas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <x-paginator-component>
        <x-paginator-select-component wire:model="size_page" />
        {{ $units->links() }}
    </x-paginator-component>
    <x-dialog-modal wire:model="unitModal">
        <x-slot name="title">{{ $unit['id'] ? 'Editar unidad de medida' : 'Crear unidad de medida' }}</x-slot>
        <x-slot name="content">
            <x-input type="text" wire:model.defer="unit.code" for="unit.code" label="Código" />
            <x-input type="text" wire:model.defer="unit.name" for="unit.name" label="Nombre" />
        </x-slot>
        <x-slot name="footer">
            <x-primary-button wire:click="saveUnit">Aceptar</x-primary-button>
            <x-danger-button wire:click="erase">Cancelar</x-danger-button>
        </x-slot>
    </x-dialog-modal>
    <x-confirmation-modal wire:model="deleteUnitModal">
        <x-slot name="title">Eliminar unidad de medida</x-slot>
        <x-slot name="content">¿Está seguro que desea eliminar esta unidad de medida?</x-slot>
        <x-slot name="footer">
            <x-danger-button wire:click="deleteUnit">Aceptar</x-danger-button>
            <x-primary-button wire:click="erase">Cancelar</x-primary-button>
        </x-slot>
    </x-confirmation-modal>
</div>
