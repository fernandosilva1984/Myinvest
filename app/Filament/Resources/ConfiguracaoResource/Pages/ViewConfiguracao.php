<?php

namespace App\Filament\Resources\ConfiguracaoResource\Pages;

use App\Filament\Resources\ConfiguracaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewConfiguracao extends ViewRecord
{
    protected static string $resource = ConfiguracaoResource::class;
    protected static ?string $title = 'Visualizar Paramentros';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
