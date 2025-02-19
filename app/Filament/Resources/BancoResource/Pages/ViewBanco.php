<?php

namespace App\Filament\Resources\BancoResource\Pages;

use App\Filament\Resources\BancoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBanco extends ViewRecord
{
    protected static string $resource = BancoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
