<div
    class="p-2 flex-1 overflow-hidden flex flex-col items-start">
    <x-filters-component>
        <x-primary-button wire:click="$toggle('categoryModal')">
            Crear nueva categoria
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
                @forelse ($categories as $c)
                    <tr>
                        <td>
                            <x-icons-container-component>
                                <x-icons.edit wire:click="setCategoryToEdit({{ $c->id }})" class="icon__pointer "/>
                                <x-icons.delete wire:click="setCategoryToDelete({{ $c->id }})" class="icon__pointer "/>
                            </x-icons-container-component>
                        </td>
                        <td>{{ $c->code }}</td>
                        <td>{{ $c->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No hay categorias registradas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <x-paginator-component>
        <x-paginator-select-component wire:model="size_page" />
        {{ $categories->links() }}
    </x-paginator-component>
    <x-dialog-modal wire:model="categoryModal">
        <x-slot name="title">{{ $category['id'] ? 'Editar categoria' : 'Crear categoria' }}</x-slot>
        <x-slot name="content">
            <x-input type="text" wire:model.defer="category.code" for="category.code" label="Código" />
            <x-input type="text" wire:model.defer="category.name" for="category.name" label="Nombre" />
        </x-slot>
        <x-slot name="footer">
            <x-primary-button wire:click="saveCategory">Aceptar</x-primary-button>
            <x-danger-button wire:click="erase">Cancelar</x-danger-button>
        </x-slot>
    </x-dialog-modal>
    <x-confirmation-modal wire:model="deleteCategoryModal">
        <x-slot name="title">Eliminar categoria</x-slot>
        <x-slot name="content">¿Está seguro que desea eliminar esta categoria?</x-slot>
        <x-slot name="footer">
            <x-danger-button wire:click="deleteCategory">Aceptar</x-danger-button>
            <x-primary-button wire:click="erase">Cancelar</x-primary-button>
        </x-slot>
    </x-confirmation-modal>
</div>
