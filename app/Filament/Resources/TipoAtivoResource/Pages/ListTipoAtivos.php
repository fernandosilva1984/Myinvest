<?php

namespace App\Filament\Resources\TipoAtivoResource\Pages;

use App\Filament\Resources\TipoAtivoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTipoAtivos extends ListRecords
{
    protected static string $resource = TipoAtivoResource::class;
    protected static ?string $title = 'Tipos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Novo Tipo'),
        ];
    }
}
