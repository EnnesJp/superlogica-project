<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Throwable;

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

        try {
            Imovel::create($validated);
        } catch (Throwable $e) {
            return Redirect::route('imoveis.index')->with('error', 'Erro ao tentar atualizar imóvel!');
        }

        return Redirect::route('imoveis.index')->with('message', 'Imóvel adicionado com sucesso!');
    }

    public function edit (Imovel $imovel) {
        return Inertia::render('ImovelForm', [
            'imovel' => $imovel
        ]);
    }

    public function atualizarImovel(Request $request, $id) {
        $validated = self::validateFields($request);

        try {
            $imovel = Imovel::find($id);
            $imovel->update($validated);
        } catch (Throwable $e) {
            return Redirect::route('imoveis.index')->with('error', 'Erro ao tentar atualizar imóvel!');
        }

        return Redirect::route('imoveis.index')->with('message', 'Informações atualizadas com sucesso!');
    }

    public function removerImovel ($id) {
        try {
            $imovel = Imovel::find($id);
            $imovel->delete();
        } catch (Throwable $e) {
            return Redirect::route('imoveis.index')->with('error', 'Erro ao tentar remover imóvel!');
        }

        return Redirect::route('imoveis.index')->with('message', 'Imóvel removido com sucesso!');
    }
}
