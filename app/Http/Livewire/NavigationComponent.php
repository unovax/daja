<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NavigationComponent extends Component
{
    public $links = [
        [
            'name' => 'General',
            'submenu' => [
                [
                    'name' => 'Trabajos',
                    'href' => '/trabajos',
                    'icon' => 'icons.clients',
                ],
                [
                    'name' => 'Inventario',
                    'href' => '/inventario',
                    'icon' => 'icons.clients',
                ],
                [
                    'name' => 'Stock',
                    'href' => '/stock',
                    'icon' => 'icons.clients',
                ],
            ]
        ],
        [
            'name' => 'Catalogos',
            'submenu' => [
                [
                    'name' => 'Clientes',
                    'href' => '/clientes',
                    'icon' => 'icons.clients',
                ],
                [
                    'name' => 'Unidades',
                    'href' => '/unidades',
                    'icon' => 'icons.clients',
                ],
                [
                    'name' => 'Ubicaciones',
                    'href' => '/ubicaciones',
                    'icon' => 'icons.clients',
                ],
                [
                    'name' => 'Categorias',
                    'href' => '/categorias',
                    'icon' => 'icons.clients',
                ],
                [
                    'name' => 'Productos',
                    'href' => '/productos',
                    'icon' => 'icons.clients',
                ],
                [
                    'name' => 'Medidas',
                    'href' => '/medidas',
                    'icon' => 'icons.clients',
                ],
            ]
        ]
    ];

    public function render()
    {
        return view('livewire.navigation-component');
    }
}
