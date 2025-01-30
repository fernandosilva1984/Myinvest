<?php

namespace App\Filament\Resources\TipoAtivoResource\Pages;

use App\Filament\Resources\TipoAtivoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTipoAtivo extends ViewRecord
{
    protected static string $resource = TipoAtivoResource::class;
    protected static ?string $title = 'Visualizar Tipo';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
