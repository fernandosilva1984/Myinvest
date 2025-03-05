<?php

namespace App\Filament\Resources\ProventosAtivosTotalResource\Pages;

use App\Filament\Resources\ProventosAtivosTotalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProventosAtivosTotals extends ListRecords
{
    protected static string $resource = ProventosAtivosTotalResource::class;

    protected static ?string $title = 'Proventos recebidos por ativo';
}
