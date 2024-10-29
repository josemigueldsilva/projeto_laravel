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
            'quantidade_times' => 'required|integer|min:2',
            'times' => 'required|array',
        ]);

        $torneio = new Torneio();
        $torneio->nome = $request->nome;
        $torneio->user_id = auth()->id();
        $torneio->descricao = $request->descricao;
        $torneio->quantidade_times = $request->quantidade_times;
        $torneio->times = json_encode($request->times);

        // Sorteio inicial dos confrontos
        $confrontos = $this->sorteioEliminacao($request->times);
        $torneio->confrontos = json_encode($confrontos);

        $torneio->save();

        return redirect()->route('torneios.show', ['id' => $torneio->id])->with('success', 'Torneio criado com sucesso!');
    }

    public function show($id)
{
    $torneio = Torneio::findOrFail($id);
    $torneio->times = json_decode($torneio->times);
    $confrontos = json_decode($torneio->confrontos, true) ?? []; // Converte para array ou inicializa como vazio

    return view('torneios.show', compact('torneio', 'confrontos'));
}

    public function salvarResultados(Request $request, $id)
{
    $request->validate([
        'avancam' => 'required|array', // Lista dos times que avançam
    ]);

    $torneio = Torneio::findOrFail($id);
    $timesQueAvancam = $request->input('avancam');

    // Verifica se restou apenas um time avançando, o que significa que temos um campeão
    if (count($timesQueAvancam) === 1) {
        $torneio->campeao = $timesQueAvancam[0]; // Define o campeão
        $torneio->confrontos = null; // Remove os confrontos, pois o torneio acabou
        $torneio->save();

        return redirect()->route('torneios.show', $torneio->id)
            ->with('success', 'Parabéns ao campeão: ' . $torneio->campeao . '!');
    }

    // Caso contrário, gere os próximos confrontos
    $this->gerarProximosConfrontos($torneio, $timesQueAvancam);

    return redirect()->route('torneios.show', $torneio->id)
        ->with('success', 'Resultados salvos e próximos confrontos gerados com sucesso!');
}

    private function gerarProximosConfrontos($torneio, $timesQueAvancam)
    {
        shuffle($timesQueAvancam); // Embaralha os times que avançaram

        $confrontos = [];
        for ($i = 0; $i < count($timesQueAvancam); $i += 2) {
            if (isset($timesQueAvancam[$i + 1])) {
                $confrontos[] = [$timesQueAvancam[$i], $timesQueAvancam[$i + 1]];
            }
        }

        $torneio->confrontos = json_encode($confrontos);
        $torneio->save();
    }

    private function sorteioEliminacao($times)
    {
        shuffle($times);
        $confrontos = [];
        for ($i = 0; $i < count($times); $i += 2) {
            if (isset($times[$i + 1])) {
                $confrontos[] = [$times[$i], $times[$i + 1]];
            }
        }
        return $confrontos;
    }

    public function index()
    {
        $torneios = Torneio::where('user_id', auth()->id())->get(); // Obter torneios do usuário autenticado
        return view('torneios.index', compact('torneios'));
    }

    public function edit($id)
{
    // Encontra o torneio pelo ID
    $torneio = Torneio::findOrFail($id);

    // Retorna a view de edição com os dados do torneio
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

    public function pesquisar(Request $request)
{
    $query = $request->input('query');

    // Buscando torneios com base na consulta
    $torneios = Torneio::where('nome', 'LIKE', "%{$query}%")->get(); // Supondo que você tenha um campo 'nome' na tabela torneios

    return view('torneios.pesquisar', compact('torneios', 'query'));
}
}
