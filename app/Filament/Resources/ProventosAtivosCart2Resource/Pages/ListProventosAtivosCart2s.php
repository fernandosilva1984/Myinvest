<?php

namespace App\Filament\Resources\ProventosAtivosCart2Resource\Pages;

use App\Filament\Resources\ProventosAtivosCart2Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProventosAtivosCart2s extends ListRecords
{
    protected static string $resource = ProventosAtivosCart2Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
