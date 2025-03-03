<?php

namespace App\Filament\Resources\ProventosAtivosCart3Resource\Pages;

use App\Filament\Resources\ProventosAtivosCart3Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProventosAtivosCart3 extends EditRecord
{
    protected static string $resource = ProventosAtivosCart3Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
