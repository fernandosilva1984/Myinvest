<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RendaFixa;
use Carbon\Carbon;

class AtualizarRendaFixa extends Command
{
    /**
     * O nome e a assinatura do comando.
     *
     * @var string
     */
    protected $signature = 'rendafixa:atualizar';

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Atualiza os campos iof, ir, valor_atual e dias_corridos da tabela renda_fixas';

    /**
     * Executa o comando.
     *
     * @return int
     */
    public function handle()
    {
        // Obtém todos os registros da tabela renda_fixas
        $rendasFixas = RendaFixa::all();

        foreach ($rendasFixas as $rendaFixa) {
            // Atualiza dias_corridos (incrementa 1 dia)
            $rendaFixa->dias_corridos += 1;

            // Calcula o valor_atual (valor_atual * (taxa_rent * taxa))
            $taxaRent = $rendaFixa->taxa_rent / 100; // Converte a taxa de porcentagem para decimal
            $taxa = $rendaFixa->taxa / 100; // Converte a taxa de porcentagem para decimal
            $rendaFixa->valor_atual = $rendaFixa->valor_atual * (1 + ($taxaRent * $taxa/266.808));

            // Atualiza IOF e IR (exemplo de cálculo, ajuste conforme sua regra de negócio)
            $rendaFixa->ir = $this->calcularIR($rendaFixa);
            $rendaFixa->iof = $this->calcularIOF($rendaFixa);
            //$rendaFixa->ir = $this->calcularIR($rendaFixa);

            // Salva as alterações no banco de dados
            $rendaFixa->save();
        }

        $this->info('Campos atualizados com sucesso!');
    }

    /**
     * Calcula o IOF (exemplo, ajuste conforme sua regra de negócio)
     *
     * @param RendaFixa $rendaFixa
     * @return float
     */
    private function calcularIOF(RendaFixa $rendaFixa)
    {
        if($rendaFixa->dias_corridos==1){
            // IOF 1 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.96;
            return $iof;
        }elseif($rendaFixa->dias_corridos==2) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.93;
            return $iof;
        }elseif($rendaFixa->dias_corridos==3) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.9;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==4) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.86;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==5) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.83;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==6) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.8;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==7) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.76;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==8) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.73;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==9) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.7;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==10) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.66;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==11) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.63;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==12) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.6;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==13) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.56;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==14) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.53;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==15) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.5;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==16) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.46;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==17) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.43;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==18) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.4;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==19) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.36;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==20) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.33;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==21) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.3;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==22) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.26;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==23) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.23;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==24) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.2;
            return $iof;

        }
        elseif($rendaFixa->dias_corridos==25) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.16;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==26) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.13;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==27) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.1;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==28) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.06;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos==29) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.03;
            return $iof;
        }
        elseif($rendaFixa->dias_corridos>=30) {
            // IOF 2 dia
            $iof = ($rendaFixa->valor_atual - ($rendaFixa->valor_aplic + $rendaFixa->ir)) * 0.0;
            return $iof;
        }

    }

    /**
     * Calcula o IR (exemplo, ajuste conforme sua regra de negócio)
     *
     * @param RendaFixa $rendaFixa
     * @return float
     */
    private function calcularIR(RendaFixa $rendaFixa)
    {
        if($rendaFixa->dias_corridos<=180){

            $ir = ($rendaFixa->valor_atual - $rendaFixa->valor_aplic) * 0.225;
            return $ir;
        }elseif($rendaFixa->dias_corridos<=360) {

            $ir = ($rendaFixa->valor_atual - $rendaFixa->valor_aplic) * 0.2;
            return $ir;
        }
        elseif($rendaFixa->dias_corridos<=720) {

            $ir = ($rendaFixa->valor_atual - $rendaFixa->valor_aplic) * 0.175;
            return $ir;
        }else{
            $ir = ($rendaFixa->valor_atual - $rendaFixa->valor_aplic) * 0.15;
            return $ir;
        }
        // Exemplo de cálculo de IR
        //return $rendaFixa->valor_atual * 0.15; // 15% do valor atual
    }
}
