<?php

namespace App\Filament\Resources\ProventosAtivosTotalResource\Pages;

use App\Filament\Resources\ProventosAtivosTotalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProventosAtivosTotal extends EditRecord
{
    protected static string $resource = ProventosAtivosTotalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
