<?php

namespace App\Filament\Resources\CarteiraResource\Pages;

use App\Filament\Resources\CarteiraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCarteiras extends ListRecords
{
    protected static string $resource = CarteiraResource::class;
    protected static ?string $title = 'Carteiras';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Nova Carteira'),
        ];
    }
}
