<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Ativo;
use App\Models\Cotacao;
use GuzzleHttp\Client;
use Carbon\Carbon;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
                'data_hora' => Carbon::now(),
            ]);
        }

        //iniciar busca de cotações de cripto moedas

         // Busca todos os ativos do banco de dados
         $ativos = Ativo::where('status', 1)->where('id_tipo', 4)->get();

         // Cria um array com os nomes dos ativos (Ticket)
         $cryptos = $ativos->pluck('Ticket')->toArray();

         // Faz a requisição à API do CoinGecko
         /*$response = Http::get('https://api.coingecko.com/api/v3/simple/price', [
             'ids' => implode(',', $cryptos),
             'vs_currencies' => 'brl',
         ]);*/
         $response = Http::when(app()->environment('local'), function ($http) {
            return $http->withoutVerifying();
        })->get('https://api.coingecko.com/api/v3/simple/price', [
            'ids' => implode(',', $cryptos),
            'vs_currencies' => 'brl',
        ]);

         // Verifica se a requisição foi bem-sucedida
         if ($response->successful()) {
             $prices = $response->json();

             // Itera sobre as criptomoedas e salva as cotações
             foreach ($prices as $cryptoName => $data) {
                 // Busca o ativo no banco de dados pelo nome (Ticket)
                 $ativo = $ativos->firstWhere('Ticket', $cryptoName);

                 if ($ativo) {
                     // Cria uma nova cotação
                     Cotacao::create([
                         'id_ativo' => $ativo->id,
                         'data_hora' => Carbon::now(), // Data e hora atual
                         'valor' => $data['brl'], // Valor em BRL
                     ]);
                 }
               //  return response()->json(['message' => 'Cotações salvas com sucesso!']+ $prices);
             }

             return response()->json(['message' => 'Cotacoes salvas com sucesso!']);
         } else {
             return response()->json(['error' => 'Falha ao obter cotacoes'], 500);
         }


    }

}
