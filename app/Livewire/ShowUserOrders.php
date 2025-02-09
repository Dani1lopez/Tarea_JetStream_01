<?php

namespace App\Livewire;

use App\Livewire\Forms\FormUpdateOrders;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ShowUserOrders extends Component
{
    use WithPagination;

    public string $campo = "id", $orden="desc";
    public string $buscar="";

    public FormUpdateOrders $uform;
    public bool $openUpdate=false;

    #[On('onOrderCreado')]
    public function render()
    {
        $orders=Orders::where('user_id',Auth::user()->id)
        ->where(function($query){
            $query->where('nombre','like',"%{$this->buscar}%")
            ->orWhere('estado','like',"%{$this->buscar}%")
            ->orWhere('cantidad','like',"%{$this->buscar}%");
        })
        ->orderBy($this->campo,$this->orden)
        ->paginate(2);
        return view('livewire.show-user-orders',compact('orders'));
    }

    //Metodo para hacer funcionar lo de buscar en todas las paginas esto lo hacemos si paginamos
    public function updatingBuscar(){
        $this->resetPage();
    }

    //Metodo para ordenar
    public function ordenar(string $campo){
        $this->orden=($this->orden=='desc') ? 'asc' : 'desc';
        $this->campo=$campo;
    }

    //Metodo para modificar el estado con un boton
    public function modificarEstado(Orders $orders){
        
        $this->authorize('update',$orders);
        $estado=($orders->estado=='Procesado') ? 'Pendiente' : 'Procesado';
        $orders->update([
            'estado'=>$estado,
        ]);
    }

    //Metodos para borrar las orders
    public function confirmarDelete(Orders $orders){
        $this->authorize('delete',$orders);
        $this->dispatch('onBorrarPost',$orders->id);
    }

    #[On('borrar')]
    public function delete(Orders $orders){
        $this->authorize('delete',$orders);
        $orders->delete();
        $this->dispatch('mensaje','Pedido eliminado con exito');
    }

    //Metodos para editar order
    public function edit(Orders $orders){
        $this->authorize('update',$orders);
        $this->uform->setOrders($orders);
        $this->openUpdate=true;
    }

    public function update(){
        $this->authorize('update',$this->uform->orders);
        $this->uform->fUpdateOrders();
        $this->cancelar();
        $this->dispatch('mensaje','Pedido actualizado con exito');
    }

    public function cancelar(){
        $this->openUpdate=false;
        $this->uform->formReset();
    }
}
