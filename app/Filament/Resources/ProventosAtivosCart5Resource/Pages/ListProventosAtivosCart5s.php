<?php

namespace App\Filament\Resources\ProventosAtivosCart5Resource\Pages;

use App\Filament\Resources\ProventosAtivosCart5Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProventosAtivosCart5s extends ListRecords
{
    protected static string $resource = ProventosAtivosCart5Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
