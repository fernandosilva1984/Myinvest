<?php

namespace App\Filament\Resources\MovimentacaoResource\Pages;

use App\Filament\Resources\MovimentacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMovimentacao extends ViewRecord
{
    protected static string $resource = MovimentacaoResource::class;
    protected static ?string $title = 'Visualizar Movimentação';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
