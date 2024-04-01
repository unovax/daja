<div
    class="p-2 flex-1 overflow-hidden flex flex-col items-start">
    <x-filters-component>
        <x-search-component wire:model.debounce.500ms="search"/>
    </x-filters-component>
    <div class="overflow-auto flex-1 w-full my-2">
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Unidad de medida</th>
                    <th>Ubicacion</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stocks as $s)
                    <tr>
                        <td>{{ $s->product?->name }}</td>
                        <td>{{ $s->quantity }}</td>
                        <td>{{ $s->unit?->name }}</td>
                        <td>{{ $s->inventory?->ubication->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            {{ $search ? 'No hay resultados para la busqueda' : 'No hay stock de ningun producto registrado' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <x-paginator-component>
        <x-paginator-select-component wire:model="size_page" />
        {{ $stocks->links() }}
    </x-paginator-component>
</div>
