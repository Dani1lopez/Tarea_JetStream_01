<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index(){
        $orders=Orders::with('user')->where('estado','Pendiente')->orderBy('id','desc')->paginate(6);
        return view('welcome',compact('orders'));
    }
}
