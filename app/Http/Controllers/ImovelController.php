<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ImovelController extends Controller
{
    public function exibirImoveis () {
        return Inertia::render('ImoveisList', [
            'imoveis' => Imovel::all()->map(function ($imovel) {
                return [
                    'id' => $imovel->id,
                    'endereco' => $imovel->endereco,
                    'preco' => $imovel->preco,
                    'tipo' => $imovel->tipo,
                    'status' => $imovel->status
                ];
            })
        ]);
    }

    public function validateFields ($request) {
        $validate = $request->validate([
            'endereco' => 'required',
            'preco' => 'required',
            'tipo' => 'required',
            'status' => 'required'
        ]);

        return $validate;
    }

    public function create () {
        return Inertia::render('ImovelForm');
    }

    public function criarImovel (Request $request) {
        $validated = self::validateFields($request);
        Imovel::create($validated);

        return Redirect::route('imoveis.index')->with('message', 'Imóvel adicionado com sucesso!');
    }

    public function edit (Imovel $imovel) {
        return Inertia::render('ImovelForm', [
            'imovel' => $imovel
        ]);
    }

    public function atualizarImovel(Request $request, Imovel $imovel) {
        $validated = self::validateFields($request);
        $imovel->update($validated);

        return Redirect::route('imoveis.index')->with('message', 'Informações atualizadas com sucesso!');
    }

    public function removerImovel (Imovel $imovel) {
        $imovel->delete();

        return Redirect::route('imoveis.index')->with('message', 'Imóvel removido com sucesso!');
    }
}
