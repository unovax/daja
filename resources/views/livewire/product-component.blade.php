<div
    class="p-2 flex-1 overflow-hidden flex flex-col items-start">
    <x-filters-component>
        <x-primary-button wire:click="$toggle('productModal')">
            Crear nuevo producto
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
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Categoria</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $p)
                    <tr>
                        <td>
                            <x-icons-container-component>
                                <x-icons.edit wire:click="setProductToEdit({{ $p->id }})" class="icon__pointer "/>
                                <x-icons.delete wire:click="setProductToDelete({{ $p->id }})" class="icon__pointer "/>
                            </x-icons-container-component>
                        </td>
                        <td>{{ $p->code }}</td>
                        <td>
                            <div class="flex gap-2 items-center">
                                @if ($p->image)
                                    <img src="{{ Storage::url($p->image) }}" alt="Imagen del producto" class="w-8 h-8 object-cover rounded-full">
                                @endif
                                {{ $p->name }}
                            </div>
                        </td>
                        <td>{{ $p->description }}</td>
                        <td>${{ number_format($p->price, 2) }}</td>
                        <td>{{ $p->category->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay productos registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <x-paginator-component>
        <x-paginator-select-component wire:model="size_page" />
        {{ $products->links() }}
    </x-paginator-component>
    <x-dialog-modal wire:model="productModal">
        <x-slot name="title">{{ $product['id'] ? 'Editar producto' : 'Crear producto' }}</x-slot>
        <x-slot name="content">
            <x-file-input-component inputId="product-img" wire:model="productImage" image="{{ $productImage }}">
                <x-slot name="imageSlot">
                    @if ($productImage)
                        <img src="{{ gettype($productImage) == 'object' ? $productImage->temporaryUrl() : Storage::url($product['image']) }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover">
                    @endif
                </x-slot>
            </x-file-input-component>
            <x-input type="text" wire:model.defer="product.code" for="product.code" label="Código" />
            <x-input type="text" wire:model.defer="product.name" for="product.name" label="Nombre" />
            <x-input type="text" wire:model.defer="product.description" for="product.description" label="Descripción" />
            <x-input type="text" wire:model.defer="product.price" for="product.price" label="Precio" />
            <x-select-component wire:model.defer="product.category_id" for="product.category_id" :items="$categories" label="Selecciona una categoria">
                <x-slot name="buttonSlot">
                    <x-icons.add class="icon__pointer" wire:click="$toggle('categoryModal')" />
                </x-slot>
            </x-select-component>
        </x-slot>
        <x-slot name="footer">
            <x-primary-button wire:click="saveProduct">Aceptar</x-primary-button>
            <x-danger-button wire:click="erase">Cancelar</x-danger-button>
        </x-slot>
    </x-dialog-modal>
    <x-dialog-modal wire:model="categoryModal">
        <x-slot name="title">{{ $category['id'] ? 'Editar categoria' : 'Crear categoria' }}</x-slot>
        <x-slot name="content">
            <x-input type="text" wire:model.defer="category.code" for="category.code" label="Código" />
            <x-input type="text" wire:model.defer="category.name" for="category.name" label="Nombre" />
        </x-slot>
        <x-slot name="footer">
            <x-primary-button wire:click="createCategory">Aceptar</x-primary-button>
            <x-danger-button wire:click="eraseCategoryData">Cancelar</x-danger-button>
        </x-slot>
    </x-dialog-modal>
    <x-confirmation-modal wire:model="deleteProductModal">
        <x-slot name="title">Eliminar producto</x-slot>
        <x-slot name="content">¿Está seguro que desea eliminar este producto?</x-slot>
        <x-slot name="footer">
            <x-danger-button wire:click="deleteProduct">Aceptar</x-danger-button>
            <x-primary-button wire:click="erase">Cancelar</x-primary-button>
        </x-slot>
    </x-confirmation-modal>
</div>
