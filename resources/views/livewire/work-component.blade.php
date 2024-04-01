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
           nextInput('work_details.'+index+'.description');
        })
    ">
    <x-filters-component>
        <x-primary-button wire:click="$toggle('workModal')">
            Crear nuevo trabajo
        </x-primary-button>
        <x-search-component wire:model.debounce.500ms="search"/>
    </x-filters-component>
    <div class="overflow-auto flex-1 w-full my-2">
        <table>
            <thead>
                <tr>
                    <th class="w-1/12 text-center">Acciones</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Importe</th>
                    <th>Fecha de entrega</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($work_detail_list as $wd)
                    <tr>
                        <td>
                            <x-icons-container-component>
                                <x-icons.edit wire:click="setWorkToEdit({{ $wd->id }})" class="icon__pointer "/>
                                <x-icons.delete wire:click="setWorkToDelete({{ $wd->id }})" class="icon__pointer "/>
                            </x-icons-container-component>
                        </td>
                        <td>{{ $wd->work?->client?->name }}</td>
                        <td>{{ $wd->product?->name }}</td>
                        <td>{{ $wd->quantity }}</td>
                        <td>{{ $wd->price }}</td>
                        <td>{{ $wd->total }}</td>
                        <td>{{ $wd->date ?? $wd->work?->date }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            {{ $search ? 'No hay resultados para la búsqueda' : 'No hay trabajos registrados' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <x-paginator-component>
        <x-paginator-select-component wire:model="size_page" />
        {{ $work_detail_list->links() }}
    </x-paginator-component>
    <x-dialog-modal maxWidth="4xl" wire:model="workModal">
        <x-slot name="title">{{ $work['id'] ? 'Editar trabajo' : 'Crear trabajo' }}</x-slot>
        <x-slot name="content">
            <x-divider-component>Información del trabajo</x-divider-component>
            @if ($work['client_id'])
                <div class="bg-gray-900 p-2 rounded-md text-gray-100 flex items-center justify-between">
                    <span>{{ $work['client_name'] }}</span>
                    <x-icons.close wire:click="setClientToNull" class="icon__pointer" />
                </div>
            @else
                <x-search-list-component
                    wire:keyup.debounce.500ms="searchClients"
                    wire:model.defer="client_name"
                    :items="$clients"
                    input_id="client_search_input"
                    for="work.client_id"
                    placeholder="Buscar cliente"
                    event="setClient"
                    label="Cliente"
                />
            @endif
            <x-area
                wire:model.defer="work.description"
                input_id="work.description"
                label="Detalle del trabajo"
                for="work.description"
                rows="3"
            />
            <x-input
                wire:model.defer="work.date"
                input_id="work.date"
                label="Fecha de entrega"
                for="work.date"
                type="datetime-local"
                disabled_input="{{ $individual_dates }}"
            />
            <x-check-box-component
                input_id="individual_dates"
                label="Activar fechas de entrega individualmente"
                for="individual_dates"
                wire:model="individual_dates"
            />
            <x-divider-component>Agregar productos</x-divider-component>
            <x-search-list-component
                wire:keyup.debounce.500ms="searchProducts"
                wire:model.defer="product_name"
                :items="$products"
                input_id="product_search_input"
                for="work_details"
                placeholder="Buscar producto"
                event="addProduct"
            />

            @if ($work_details)
                <div class="w-full overflow-auto">
                    <table class="mt-2">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th class="hidden md:table-cell">Descripción</th>
                                <th class="hidden md:table-cell">Cantidad</th>
                                <th class="hidden md:table-cell">Precio</th>
                                @if ($individual_dates)
                                <th class="hidden md:table-cell">Fecha de entrega</th>
                                @endif
                                <th class="hidden md:table-cell">Importe</th>
                                <th colspan="{{ $individual_dates ? '5' : '4' }}" class="md:hidden">
                                    Informacion
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($work_details as $key => $detail)
                                <tr>
                                    <td>{{ $detail['product']['name'] }}</td>
                                    <td class="block md:table-cell">
                                        <x-area
                                            label="Descripción"
                                            label_class="md:hidden"
                                            input_id="work_details.{{ $key }}.description"
                                            wire:model.defer="work_details.{{ $key }}.description"
                                            for="work_details.{{ $key }}.description"
                                            x-on:keydown.enter="nextInput('work_details.{{ $key }}.quantity')"
                                            rows="1"
                                            />
                                        </td>
                                        <td class="block md:table-cell w-[150px] min-w-[150px] max-w-[150px]">
                                            <x-input
                                            label="Cantidad"
                                            label_class="md:hidden"
                                            input_id="work_details.{{ $key }}.quantity"
                                            wire:model.lazy="work_details.{{ $key }}.quantity"
                                            for="work_details.{{ $key }}.quantity"
                                            x-on:keydown.enter="nextInput('work_details.{{ $key }}.price')"
                                        />
                                    </td>
                                    <td class="block md:table-cell w-[150px] min-w-[150px] max-w-[150px]">
                                        <x-input
                                            label="Precio"
                                            label_class="md:hidden"
                                            input_id="work_details.{{ $key }}.price"
                                            for="work_details.{{ $key }}.price"
                                            wire:model.lazy="work_details.{{ $key }}.price"
                                            x-on:keydown.enter="nextInput('product_search_input')"
                                        />
                                    </td>
                                    @if ($individual_dates)
                                        <td class="block md:table-cell">
                                            <x-input
                                                label="Fecha de entrega"
                                                label_class="md:hidden"
                                                input_id="work_details.{{ $key }}.date"
                                                wire:model.defer="work_details.{{ $key }}.date"
                                                for="work_details.{{ $key }}.date"
                                                type="datetime-local"
                                            />
                                        </td>
                                    @endif
                                    <td class="block md:table-cell text-rigth">${{ number_format( floatval($detail['quantity']) * floatval($detail['price']), 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-primary-button wire:click="saveWork">Aceptar</x-primary-button>
            <x-danger-button wire:click="erase">Cancelar</x-danger-button>
        </x-slot>
    </x-dialog-modal>
    <x-confirmation-modal wire:model="deleteWorkModal">
        <x-slot name="title">Eliminar trabajo</x-slot>
        <x-slot name="content">¿Está seguro que desea eliminar esta trabajo?</x-slot>
        <x-slot name="footer">
            <x-danger-button wire:click="deleteWork">Aceptar</x-danger-button>
            <x-primary-button wire:click="erase">Cancelar</x-primary-button>
        </x-slot>
    </x-confirmation-modal>
</div>
