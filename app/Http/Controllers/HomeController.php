<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Users;
use App\Models\Venta;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $empresa = Empresa::first();
        $usuarios = Users::count();
        $clientes = Cliente::count();
        $total = Venta::sum('total');
        $cantidadVentas = Venta::count();
        return view('home', compact('empresa','usuarios','clientes','total','cantidadVentas'));
    }
}
