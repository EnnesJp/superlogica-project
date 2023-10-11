<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ImovelController extends Controller
{
    public function index () {

    }

    public function create () {
        return Inertia::render('ImovelForm');
    }

    public function store (Request $request) {
        $validate = $request->validate([
            'endereco' => 'required',
            'preco' => 'required',
            'tipo' => 'required',
            'status' => 'required'
        ]);

        Imovel::create($validate);

        return Redirect::route('imoveis.index');
    }
}
