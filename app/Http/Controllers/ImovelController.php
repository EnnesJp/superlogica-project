<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Throwable;

class ImovelController extends Controller
{
    private const ALUGADO = 2;
    private const VENDIDO = 3;

    public function exibirImoveis () {
        return Inertia::render('Dashboard', [
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
            return Redirect::route('dashboard')->with('error', 'Erro ao tentar atualizar imóvel!');
        }

        return Redirect::route('dashboard')->with('message', 'Imóvel adicionado com sucesso!');
    }

    public function detalhesImovel ($id) {
        try {
            $imovel = Imovel::find($id);
        } catch (Throwable $e) {
            return Redirect::route('dashboard')->with('error', 'Imóvel não encontrado!');
        }

        return Inertia::render('ImovelView', [
            'imovel' => $imovel
        ]);
    }

    public function edit ($id) {
        try {
            $imovel = Imovel::find($id);
        } catch (Throwable $e) {
            return Redirect::route('dashboard')->with('error', 'Imóvel não encontrado!');
        }

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
            return Redirect::route('dashboard')->with('error', 'Erro ao tentar atualizar imóvel!');
        }

        return Redirect::route('dashboard')->with('message', 'Informações atualizadas com sucesso!');
    }

    public function removerImovel ($id) {
        try {
            $imovel = Imovel::find($id);
            $imovel->delete();
        } catch (Throwable $e) {
            return Redirect::route('dashboard')->with('error', 'Erro ao tentar remover imóvel!');
        }

        return Redirect::route('dashboard')->with('message', 'Imóvel removido com sucesso!');
    }

    public function alugaImovel ($id) {
        try {
            $imovel = Imovel::find($id);
            $imovel->status = self::ALUGADO;
            $imovel->save();
        } catch (Throwable $e) {
            return Redirect::route('dashboard')->with('error', 'Erro ao tentar alugar imóvel!');
        }

        return Redirect::route('dashboard')->with('message', 'Imóvel alugado com sucesso!');
    }

    public function vendeImovel ($id) {
        try {
            $imovel = Imovel::find($id);
            $imovel->status = self::VENDIDO;
            $imovel->save();
        } catch (Throwable $e) {
            return Redirect::route('dashboard')->with('error', 'Erro ao tentar comprar imóvel!');
        }

        return Redirect::route('dashboard')->with('message', 'Imóvel comprado com sucesso!');
    }
}
