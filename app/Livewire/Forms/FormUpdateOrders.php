<?php

namespace App\Livewire\Forms;

use App\Models\Orders;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormUpdateOrders extends Form
{
    public ?Orders $orders=null;
    
    public string $nombre="";

    #[Validate(['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'])]
    public string $cantidad="";

    #[Validate(['required','in:Procesado,Pendiente'])]
    public string $estado="";

    public function rules(){
        return[
            'nombre'=>['required','string','min:3','max:100','unique:orders,nombre,'.$this->orders->id]
        ];
    }

    public function setOrders(Orders $orders){
        $this->orders=$orders;
        $this->nombre=$orders->nombre;
        $this->cantidad=$orders->cantidad;
        $this->estado=$orders->estado;
    }

    public function fUpdateOrders(){
        $this->validate();
        $this->orders->update([
            'nombre'=>$this->nombre,
            'cantidad'=>$this->cantidad,
            'estado'=>$this->estado,
        ]);
    }

    public function formReset(){
        $this->resetValidation();
        $this->reset();
    }

    
}
