<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NotificationComponent extends Component
{
    protected $listeners = ['showNotification'];
    public $message = 'This is a notification message';
    public $colors = [
        'success' => '#4F8A10',
        'fail' => '#D8000C',
        'warning' => '#9F6000',
        'info' => '#00529B',
    ];
    public $type = 'success';
    public function render()
    {
        return view('livewire.notification-component');
    }

    public function showNotification($message, $type){
        $this->message = $message;
        $this->type = $type;
        $this->emit('notify');
    }
}
