<?php

namespace App\Filament\Resources\ProventosAtivosCart2Resource\Pages;

use App\Filament\Resources\ProventosAtivosCart2Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProventosAtivosCart2 extends EditRecord
{
    protected static string $resource = ProventosAtivosCart2Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
