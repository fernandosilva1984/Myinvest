<?php

namespace App\Filament\Resources\DividendoResource\Pages;

use App\Filament\Resources\DividendoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDividendo extends EditRecord
{
    protected static string $resource = DividendoResource::class;
    protected static ?string $title = 'Editar Provento';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
