<?php

namespace App\Filament\Resources\OperacaoResource\Pages;

use App\Filament\Resources\OperacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOperacao extends ViewRecord
{
    protected static string $resource = OperacaoResource::class;
    protected static ?string $title = 'Visualizar Operação';


    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
