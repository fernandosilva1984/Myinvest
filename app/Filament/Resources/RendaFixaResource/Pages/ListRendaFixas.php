<?php

namespace App\Filament\Resources\RendaFixaResource\Pages;

use App\Filament\Resources\RendaFixaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRendaFixas extends ListRecords
{
    protected static string $resource = RendaFixaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
