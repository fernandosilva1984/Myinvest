<?php

namespace App\Filament\Resources\ProventoMesResource\Pages;

use App\Filament\Resources\ProventoMesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProventoMes extends EditRecord
{
    protected static string $resource = ProventoMesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
