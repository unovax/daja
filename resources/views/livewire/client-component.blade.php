<div
    class="p-2">
    <x-primary-button wire:click="$set('clientModal', true)">Crear nuevo cliente</x-primary-button>
    <table>
        <thead>
            <tr>
                <th>Acciones</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Dirección</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>
                        <x-icons-container-component>
                            <x-icons.edit class="icon__pointer "/>
                            <x-icons.delete class="icon__pointer "/>
                        </x-icons-container-component>
                    </td>
                    <td>{{ $client->code }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->address }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <x-dialog-modal wire:model="clientModal">
        <x-slot name="title">{{ $client ? 'Editar cliente' : 'Crear cliente' }}</x-slot>
        <x-slot name="content">
            <x-input type="text" wire:model.defer="client.code" for="client.code" label="Código" />
            <x-input type="text" wire:model.defer="client.name" for="client.name" label="Nombre" />
            <x-input type="text" wire:model.defer="client.phone" for="client.phone" label="Telefono" />
            <x-input type="text" wire:model.defer="client.address" for="client.address" label="Dirección" />
        </x-slot>
        <x-slot name="footer">
            <x-primary-button wire:click="saveClient">Aceptar</x-primary-button>
            <x-danger-button>Cancelar</x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
