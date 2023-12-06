<?php

namespace App\Filament\Resources\DividendoResource\Pages;

use App\Filament\Resources\DividendoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDividendo extends ViewRecord
{
    protected static string $resource = DividendoResource::class;
    protected static ?string $title = 'Visualizar Provento';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
