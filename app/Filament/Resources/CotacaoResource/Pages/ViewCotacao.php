<?php

namespace App\Filament\Resources\CotacaoResource\Pages;

use App\Filament\Resources\CotacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCotacao extends ViewRecord
{
    protected static string $resource = CotacaoResource::class;
    protected static ?string $title = 'Visualizar Cotação';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
