<?php

namespace App\Filament\Resources\CarteiraResource\Pages;

use App\Filament\Resources\CarteiraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCarteira extends EditRecord
{
    protected static string $resource = CarteiraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
