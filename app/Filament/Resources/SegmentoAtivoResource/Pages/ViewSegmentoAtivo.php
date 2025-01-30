<?php

namespace App\Filament\Resources\SegmentoAtivoResource\Pages;

use App\Filament\Resources\SegmentoAtivoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSegmentoAtivo extends ViewRecord
{
    protected static string $resource = SegmentoAtivoResource::class;
    protected static ?string $title = 'Visualizar Segmento';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
