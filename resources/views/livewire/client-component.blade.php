<div
    x-data="{
        nextInput(id) {
            setTimeout(() => {
                document.getElementById(id).focus()
            }, 400)
        }
    }"
    x-init="
        $wire.on('nextInput', (id) => {
        nextInput(id);
        })
    "
    class="p-2 flex-1 overflow-hidden flex flex-col items-start">
    <x-filters-component>
        <x-primary-button wire:click="$toggle('clientModal')">
            Crear nuevo cliente
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
                    <th>Telefono</th>
                    <th>Dirección</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($clients as $c)
                    <tr>
                        <td>
                            <x-icons-container-component>
                                <x-icons.edit wire:click="setClientToEdit({{ $c->id }})" class="icon__pointer "/>
                                <x-icons.delete wire:click="setClientToDelete({{ $c->id }})" class="icon__pointer "/>
                            </x-icons-container-component>
                        </td>
                        <td>{{ $c->code }}</td>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->phone }}</td>
                        <td>{{ $c->address }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay clientes registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <x-paginator-component>
        <x-paginator-select-component wire:model="size_page" />
        {{ $clients->links() }}
    </x-paginator-component>
    <x-dialog-modal wire:model="clientModal">
        <x-slot name="title">{{ $client['id'] ? 'Editar cliente' : 'Crear cliente' }}</x-slot>
        <x-slot name="content">
            <x-input type="text" wire:model.defer="client.code" for="client.code" label="Código" />
            <x-input type="text" wire:model.defer="client.name" for="client.name" label="Nombre" />
            <x-input type="text" wire:model.defer="client.phone" for="client.phone" label="Telefono" />
            <x-input type="text" wire:model.defer="client.address" for="client.address" label="Dirección" />
            <x-divider-component>Medidas del cliente</x-divider-component>
            <div class="flex gap-2 items-center">
                <x-search-list-component
                    wire:keyup.debounce.500ms="searchMeasures"
                    wire:model.defer="measure_name"
                    :items="$measures"
                    input_id="measure_search_input"
                    for="client_measures"
                    placeholder="Buscar medida"
                />
                <x-icons.add class="icon__pointer" wire:click="$toggle('measureModal')" />
            </div>
            @if ($client_measures)
                <div class="w-full overflow-auto">
                    <table class="mt-2">
                        <thead>
                            <tr>
                                <th>Medida</th>
                                <th class="hidden md:table-cell">Cantidad</th>
                                <th class="hidden md:table-cell">Unidad</th>
                                <th colspan="2" class="md:hidden">
                                    Informacion
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($client_measures as $key => $cm)
                                <tr>
                                    <td>{{ $cm['measure']['name'] }}</td>
                                    <td class="block md:table-cell">
                                        <x-input
                                            label="Cantidad"
                                            label_class="md:hidden"
                                            input_id="client_measures.{{ $key }}.quantity"
                                            wire:model.defer="client_measures.{{ $key }}.quantity"
                                            x-on:keydown.enter="nextInput('client_measures.{{ $key }}.unit_id')"
                                            for="client_measures.{{ $key }}.quantity"

                                        />
                                    </td>
                                    <td class="block md:table-cell">
                                        <x-select-component
                                            label="Unidad"
                                            label_class="md:hidden"
                                            input_id="client_measures.{{ $key }}.unit_id"
                                            for="client_measures.{{ $key }}.unit_id"
                                            wire:model.defer="client_measures.{{ $key }}.unit_id"
                                            x-on:keydown.enter="nextInput('measure_search_input')"
                                            :items="$units"
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
            <x-primary-button wire:click="saveClient">Aceptar</x-primary-button>
            <x-danger-button wire:click="erase">Cancelar</x-danger-button>
        </x-slot>
    </x-dialog-modal>
    <x-dialog-modal wire:model="measureModal">
        <x-slot name="title">Crear medida</x-slot>
        <x-slot name="content">
            <x-input type="text" wire:model.defer="measure.code" for="measure.code" label="Código" />
            <x-input type="text" wire:model.defer="measure.name" for="measure.name" label="Nombre" />
        </x-slot>
        <x-slot name="footer">
            <x-primary-button wire:click="createMeasure">Aceptar</x-primary-button>
            <x-danger-button wire:click="eraseMeasureData">Cancelar</x-danger-button>
        </x-slot>
    </x-dialog-modal>
    <x-confirmation-modal wire:model="deleteClientModal">
        <x-slot name="title">Eliminar cliente</x-slot>
        <x-slot name="content">¿Está seguro que desea eliminar el cliente?</x-slot>
        <x-slot name="footer">
            <x-danger-button wire:click="deleteClient">Aceptar</x-danger-button>
            <x-primary-button wire:click="erase">Cancelar</x-primary-button>
        </x-slot>
    </x-confirmation-modal>
</div>
