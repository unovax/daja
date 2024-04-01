<div
    class="p-2 flex-1 overflow-hidden flex flex-col items-start">
    <x-filters-component>
        <x-primary-button wire:click="$toggle('measureModal')">
            Crear nueva medida
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
                @forelse ($measures as $u)
                    <tr>
                        <td>
                            <x-icons-container-component>
                                <x-icons.edit wire:click="setMeasureToEdit({{ $u->id }})" class="icon__pointer "/>
                                <x-icons.delete wire:click="setMeasureToDelete({{ $u->id }})" class="icon__pointer "/>
                            </x-icons-container-component>
                        </td>
                        <td>{{ $u->code }}</td>
                        <td>{{ $u->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            {{ $search ? 'No hay resultados para la búsqueda' : 'No hay medidas registradas' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <x-paginator-component>
        <x-paginator-select-component wire:model="size_page" />
        {{ $measures->links() }}
    </x-paginator-component>
    <x-dialog-modal wire:model="measureModal">
        <x-slot name="title">{{ $measure['id'] ? 'Editar medida' : 'Crear medida' }}</x-slot>
        <x-slot name="content">
            <x-input type="text" wire:model.defer="measure.code" for="measure.code" label="Código" />
            <x-input type="text" wire:model.defer="measure.name" for="measure.name" label="Nombre" />
        </x-slot>
        <x-slot name="footer">
            <x-primary-button wire:click="saveMeasure">Aceptar</x-primary-button>
            <x-danger-button wire:click="erase">Cancelar</x-danger-button>
        </x-slot>
    </x-dialog-modal>
    <x-confirmation-modal wire:model="deleteMeasureModal">
        <x-slot name="title">Eliminar medida</x-slot>
        <x-slot name="content">¿Está seguro que desea eliminar esta medida?</x-slot>
        <x-slot name="footer">
            <x-danger-button wire:click="deleteMeasure">Aceptar</x-danger-button>
            <x-primary-button wire:click="erase">Cancelar</x-primary-button>
        </x-slot>
    </x-confirmation-modal>
</div>
