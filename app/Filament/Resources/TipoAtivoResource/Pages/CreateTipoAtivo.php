<?php

namespace App\Filament\Resources\TipoAtivoResource\Pages;

use App\Filament\Resources\TipoAtivoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTipoAtivo extends CreateRecord
{
    protected static string $resource = TipoAtivoResource::class;
    protected static ?string $title = 'Novo Tipo';
}
