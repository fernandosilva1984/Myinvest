<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ativo;
use App\Models\Cotacao;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class CotacaoController extends Controller
{
    // Método para buscar e salvar cotações
    public function buscarESalvarCotacoes()
    {
        // Busca todos os ativos (ações e fundos imobiliários)
        $ativos = Ativo::where('status', 1)->where('id_tipo', '<=', 2)->get();

        // Inicializa o cliente HTTP (Guzzle)
        $client = new Client(['verify' => false]);

        foreach ($ativos as $ativo) {
            // Monta o símbolo para a API do Yahoo Finance
            $symbol = $ativo->Ticket . '.SA'; // Exemplo: PETR4.SA, VISC11.SA

            // Tenta buscar a cotação no Yahoo Finance
            try {
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
            } catch (\Exception $e) {
                // Se ocorrer um erro, tenta buscar no Alpha Vantage
                $this->buscarNoAlphaVantage($ativo);
            }
        }

        // Iniciar busca de cotações de cripto moedas
        $this->buscarCriptoMoedas();
    }

    // Método para buscar cotações no Alpha Vantage
    private function buscarNoAlphaVantage($ativo)
    {
        $apiKey = 'A8JZESOWJBZ6FOR3'; // Substitua pela sua chave da API Alpha Vantage
        $symbol = $ativo->Ticket . '.SAO'; // Alpha Vantage usa .SAO para ações brasileiras

        try {
            $response = Http::get("https://www.alphavantage.co/query", [
                'function' => 'GLOBAL_QUOTE',
                'symbol' => $symbol,
                'apikey' => $apiKey,
            ]);

            $data = $response->json();

            if (isset($data['Global Quote']['05. price'])) {
                $valor = $data['Global Quote']['05. price'];

                // Salva a cotação na tabela `cotacoes`
                Cotacao::create([
                    'id_ativo' => $ativo->id,
                    'valor' => $valor,
                    'data_hora' => Carbon::now(),
                ]);
            }
        } catch (\Exception $e) {
            // Log do erro ou tratamento adicional
            \Log::error("Erro ao buscar cotação no Alpha Vantage para o ativo {$ativo->Ticket}: " . $e->getMessage());
        }
    }

    // Método para buscar cotações de criptomoedas
    private function buscarCriptoMoedas()
    {
        // Busca todos os ativos do banco de dados
        $ativos = Ativo::where('status', 1)->where('id_tipo', 4)->get();

        // Cria um array com os nomes dos ativos (Ticket)
        $cryptos = $ativos->pluck('Ticket')->toArray();

        // Faz a requisição à API do CoinGecko
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
            }

            return response()->json(['message' => 'Cotacoes salvas com sucesso!']);
        } else {
            return response()->json(['error' => 'Falha ao obter cotacoes'], 500);
        }
    }
}
