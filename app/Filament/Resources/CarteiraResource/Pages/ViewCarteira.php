<?php

namespace App\Filament\Resources\CarteiraResource\Pages;

use App\Filament\Resources\CarteiraResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCarteira extends ViewRecord
{
    protected static string $resource = CarteiraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
