<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Ativo;
use App\Models\Cotacao;
use GuzzleHttp\Client;
use Carbon\Carbon;

class CotacaoController extends Controller
{
    // Método para buscar e salvar cotações
    public function buscarESalvarCotacoes()
    {
        // Busca todos os ativos (ações e fundos imobiliários)
        $ativos = Ativo::where('status', 1)->where('id_tipo','<=',2)->get();

        // Inicializa o cliente HTTP (Guzzle)
        $client = new Client(['verify' => false,]);

        foreach ($ativos as $ativo) {
            // Monta o símbolo para a API do Yahoo Finance
            $symbol = $ativo->Ticket . '.SA'; // Exemplo: PETR4.SA, VISC11.SA

            // Faz a requisição à API do Yahoo Finance
            $response = $client->get("https://query1.finance.yahoo.com/v8/finance/chart/{$symbol}");
            $data = json_decode($response->getBody(), true);

            // Extrai o valor da cotação
            $valor = $data['chart']['result'][0]['meta']['regularMarketPrice'];

            // Salva a cotação na tabela `cotacoes`
            Cotacao::create([
                'id_ativo' => $ativo->id,
                'valor' => $valor,
                //'data_hora' => Carbon::now()->toDateString(),
            ]);
        }

        return response()->json(['message' => 'Cotações atualizadas com sucesso!']);
    }
}
