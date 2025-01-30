<?php

namespace App\Http\Controllers;
// app/Http/Controllers/SeuController.php
//namespace App\Http\Controllers;

use App\Models\Cotacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class cotacaoController extends Controller
{
    public function salvarDadosDoGoogleSheets()
    {
        // Faça a requisição para a API do Google Sheets
        $response = Http::withoutVerifying()->get('https://sheets.googleapis.com/v4/spreadsheets/1vRQLbi4b1MwoNqs_qx3xmwSArbXCWS4B4nRXsERp-zM/values/cotações!a2:d26', [
            'majorDimension' => 'ROWS',
            'key' => 'AIzaSyC23EajrXzvdCCPCvKiTIyzQw8kGju9094',
        ]);

        // Verifique se a requisição foi bem-sucedida
        if ($response->successful()) {
            // Obtenha os dados da resposta
            $dadosArray = $response->json()['values'];

            // Percorra os dados e salve no banco de dados
            foreach ($dadosArray as $dados) {
                Cotacao::create([
                    'id_ativo' => $dados[0],
                    'valor' => $dados[2],

                    // Adicione mais campos conforme necessário
                ]);
            }

            // Retorne uma resposta, redirecione ou faça o que for apropriado para o seu caso
            return response()->json(['mensagem' => 'Dados do Google Sheets salvos com sucesso']);
        } else {
            // Caso a requisição não seja bem-sucedida, trate o erro conforme necessário
            return response()->json(['erro' => 'Erro ao obter dados do Google Sheets'], $response->status());
        }
    }
}
