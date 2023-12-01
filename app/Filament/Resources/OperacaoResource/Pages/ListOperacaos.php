<?php

namespace App\Filament\Resources\OperacaoResource\Pages;

use App\Filament\Resources\OperacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOperacaos extends ListRecords
{
    protected static string $resource = OperacaoResource::class;
    protected static ?string $title = 'Operações';


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Nova Operação'),
        ];
    }
}
