<?php

namespace App\Livewire\Forms;

use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormCreateOrders extends Form
{
    #[Validate(['required','string','min:3','max:100','unique:orders,nombre'])]
    public string $nombre="";

    #[Validate(['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'])]
    public string $cantidad="";

    #[Validate(['required','in:Procesado,Pendiente'])]
    public string $estado="";

    public function fGuardarPost(){
        $this->validate();
        Orders::create([
            'nombre'=>$this->nombre,
            'cantidad'=>$this->cantidad,
            'estado'=>$this->estado,
            'user_id'=>Auth::user()->id
        ]);
    }

    public function formReset(){
        $this->resetValidation();
        $this->reset();
    }
}
