<?php

namespace App\Filament\Resources\ProventosAtivosCart3Resource\Pages;

use App\Filament\Resources\ProventosAtivosCart3Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProventosAtivosCart3s extends ListRecords
{
    protected static string $resource = ProventosAtivosCart3Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
