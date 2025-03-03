<?php

namespace App\Filament\Resources\PosicaoResource\Pages;

use App\Filament\Resources\PosicaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPosicaos extends ListRecords
{
    protected static string $resource = PosicaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
