<?php

namespace App\Filament\Resources\SegmentoAtivoResource\Pages;

use App\Filament\Resources\SegmentoAtivoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSegmentoAtivos extends ListRecords
{
    protected static string $resource = SegmentoAtivoResource::class;
    protected static ?string $title = 'Segmentos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Novo Segmento'),
        ];
    }
}
