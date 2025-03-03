<?php

namespace App\Filament\Resources\ProventosAtivosCart1Resource\Pages;

use App\Filament\Resources\ProventosAtivosCart1Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProventosAtivosCart1 extends EditRecord
{
    protected static string $resource = ProventosAtivosCart1Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
