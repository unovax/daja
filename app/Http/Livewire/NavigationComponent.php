<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NavigationComponent extends Component
{
    public $links = [
        [
            'name' => 'Clientes',
            'href' => '/clientes',
            'icon' => 'icons.clients',
        ],
        [
            'name' => 'Productos',
            'href' => '/productos',
            'icon' => 'icons.clients',
        ],
        [
            'name' => 'Trabajos',
            'href' => '/trabajos',
            'icon' => 'icons.clients',
        ],
    ];

    public function render()
    {
        return view('livewire.navigation-component');
    }
}
