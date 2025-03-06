<?php

namespace App\Filament\Resources\OperacaoResource\Pages;

//use App\Services\OperacaoService;
use App\Filament\Resources\OperacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOperacao extends CreateRecord
{
    protected static string $resource = OperacaoResource::class;
    protected static ?string $title = 'Nova Operação';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
/*
    protected function afterCreate(): void
    {
        // Chama o Service para calcular o preço médio e o resultado
        $operacaoService = new OperacaoService();
        $operacaoService->calcularPrecoMedioEResultado(
            $this->record->id_carteira,
            $this->record->id_ativo,
            $this->record->data,
            $this->record->qtd,
            $this->record->valor_unitario//,
            //$this->record->valor_total
        );
    }*/
}
