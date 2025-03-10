<?php

namespace App\Filament\Resources\DividendoResource\Pages;

use App\Filament\Resources\DividendoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDividendos extends ListRecords
{
    protected static string $resource = DividendoResource::class;
    protected static ?string $title = 'Proventos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Novo Dividendo'),
        ];
    }
}
