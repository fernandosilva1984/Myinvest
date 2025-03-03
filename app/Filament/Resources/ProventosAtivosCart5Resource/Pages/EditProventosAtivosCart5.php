<?php

namespace App\Filament\Resources\ProventosAtivosCart5Resource\Pages;

use App\Filament\Resources\ProventosAtivosCart5Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProventosAtivosCart5 extends EditRecord
{
    protected static string $resource = ProventosAtivosCart5Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
