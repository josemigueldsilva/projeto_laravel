<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Torneio;

class TorneioController extends Controller
{
    public function create()
    {
        return view('torneios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'quantidade_times' => 'required|integer',
            'times' => 'required|array',
            'formato' => 'required|string',
            'times_por_grupo' => 'nullable|integer',
        ]);

        $torneio = new Torneio();
        $torneio->nome = $request->nome;
        $torneio->user_id = auth()->id();
        $torneio->descricao = $request->descricao;
        $torneio->quantidade_times = $request->quantidade_times;
        $torneio->times = json_encode($request->times);
        $torneio->formato = $request->formato;
        $torneio->times_por_grupo = $request->times_por_grupo;

        // Gerar grupos apenas na criação
        if ($torneio->formato == 'fase_grupos') {
            $times = $request->times;
            shuffle($times);
            $quantidadeGrupos = ceil($request->quantidade_times / $request->times_por_grupo);
            $grupos = [];

            for ($i = 0; $i < $quantidadeGrupos; $i++) {
                $grupos[$i + 1] = array_slice($times, $i * $request->times_por_grupo, $request->times_por_grupo);
            }

            $torneio->grupos = json_encode($grupos);
        }

        $torneio->save();

        return redirect()->route('torneios.show', ['id' => $torneio->id])->with('success', 'Torneio criado com sucesso!');
    }

    public function show($id)
    {
        $torneio = Torneio::findOrFail($id);
        $torneio->times = json_decode($torneio->times);
        
        // Modifique esta linha
        $torneio->pontuacoes = json_decode($torneio->pontuacoes, true) ?? []; // Isso evitará o erro se for um array
    
        $grupos = [];
        $confrontos = [];
        
        if ($torneio->formato == 'fase_grupos') {
            $times = $torneio->times;
            $grupos = json_decode($torneio->grupos, true); // Recupera os grupos do torneio

            // Cria partidas para fase de grupos
            foreach ($grupos as $grupo) {
                for ($i = 0; $i < count($grupo); $i++) {
                    for ($j = $i + 1; $j < count($grupo); $j++) {
                        $confrontos[] = [$grupo[$i], $grupo[$j]];
                    }
                }
            }
        } elseif ($torneio->formato == 'eliminacao_simples') {
            $times = $torneio->times;
            shuffle($times); // Embaralha os times

            // Cria os confrontos (simples, para exemplo)
            for ($i = 0; $i < count($times); $i += 2) {
                if (isset($times[$i + 1])) {
                    $confrontos[] = [$times[$i], $times[$i + 1]];
                }
            }
        }

        return view('torneios.show', compact('torneio', 'grupos', 'confrontos'));
    }

    public function pesquisar(Request $request)
    {
        $query = $request->input('query'); // Obtenha a consulta da barra de pesquisa
        $torneios = Torneio::where('nome', 'LIKE', '%' . $query . '%')->get(); // Pesquise torneios

        return view('torneios.resultados', compact('torneios'));
    }

    public function index()
    {
        $torneios = Torneio::where('user_id', auth()->id())->get(); // Obter torneios do usuário autenticado
        return view('torneios.index', compact('torneios'));
    }

    public function edit($id)
    {
        $torneio = Torneio::findOrFail($id); // Encontrar torneio pelo ID
        return view('torneios.edit', compact('torneio'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'times' => 'required|array', // Verifique se é um array
        ]);

        $torneio = Torneio::findOrFail($id);
        $torneio->nome = $request->nome;
        $torneio->descricao = $request->descricao;
        $torneio->times = json_encode($request->times); // Converte o array para JSON
        $torneio->save();

        return redirect()->route('torneios.index')->with('success', 'Torneio atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $torneio = Torneio::findOrFail($id);
        $torneio->delete(); // Exclui o torneio
        return redirect()->route('torneios.index')->with('success', 'Torneio excluído com sucesso!');
    }

    public function salvarResultados(Request $request, $id)
    {
        $request->validate([
            'resultados' => 'required|array',
        ]);

        $torneio = Torneio::findOrFail($id);
        $resultados = $request->input('resultados');
        $pontuacoes = json_decode($torneio->pontuacoes, true) ?? []; // Garante que seja um array

        // Processa os resultados
        foreach ($resultados as $partida => $gols) {
            // Verifica se o array de gols contém exatamente dois valores
            if (!is_array($gols) || count($gols) !== 2) {
                continue; // Pula se os gols não estiverem definidos corretamente
            }

            $golsMarcados = (int)$gols[0]; // Gols do time 1
            $golsSofridos = (int)$gols[1]; // Gols do time 2

            // Obtém os times da partida
            $times = explode(' x ', $partida);
            if (count($times) < 2) {
                continue; // Pula se não encontrar dois times
            }
            
            $time1 = trim($times[0]);
            $time2 = trim($times[1]);

            // Inicializa as pontuações se não existirem
            if (!isset($pontuacoes[$time1])) {
                $pontuacoes[$time1] = 0;
            }
            if (!isset($pontuacoes[$time2])) {
                $pontuacoes[$time2] = 0;
            }

            // Atualiza pontuações com base nos resultados
            if ($golsMarcados > $golsSofridos) {
                $pontuacoes[$time1] += 3; // Vitória para time1
            } elseif ($golsMarcados < $golsSofridos) {
                $pontuacoes[$time2] += 3; // Vitória para time2
            } else {
                $pontuacoes[$time1] += 1; // Empate
                $pontuacoes[$time2] += 1; // Empate
            }
        }

        // Atualiza as pontuações no banco de dados
        $torneio->pontuacoes = json_encode($pontuacoes);
        $torneio->save();

        // Gerar próximos confrontos para eliminação se o formato for eliminatório
        if ($torneio->formato === 'eliminacao_simples') {
            $this->gerarProximosConfrontos($torneio);
        }

        return redirect()->route('torneios.show', $torneio->id)->with('success', 'Resultados salvos com sucesso!');
    }

    private function gerarProximosConfrontos($torneio)
    {
        $times = json_decode($torneio->times);
        shuffle($times); // Embaralha os times

        $confrontos = [];
        for ($i = 0; $i < count($times); $i += 2) {
            if (isset($times[$i + 1])) {
                $confrontos[] = [$times[$i], $times[$i + 1]];
            }
        }

        // Aqui você deve armazenar os confrontos no banco de dados, se necessário.
        // Por exemplo, $torneio->confrontos = json_encode($confrontos);
        // $torneio->save();
    }
}
