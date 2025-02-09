<?php

namespace App\Livewire;

use App\Livewire\Forms\FormCreateOrders;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateUserPosts extends Component
{
    public bool $openModalCrear=false;

    public FormCreateOrders $cform;

    public function render()
    {
        return view('livewire.create-user-posts');
    }

    public function store(){
        $this->cform->fGuardarPost();
        $this->cancelar();
        $this->dispatch('onOrderCreado')->to(ShowUserOrders::class);
        $this->dispatch('mensaje','Pedido realizado con exito');
    }

    public function cancelar(){
        $this->openModalCrear=false;
        $this->cform->formReset();
    }
}
