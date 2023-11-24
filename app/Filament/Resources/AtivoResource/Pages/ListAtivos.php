<?php

namespace App\Filament\Resources\AtivoResource\Pages;

use App\Filament\Resources\AtivoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAtivos extends ListRecords
{
    protected static string $resource = AtivoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
