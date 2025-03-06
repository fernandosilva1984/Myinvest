<?php

namespace App\Filament\Resources\AtivoResource\Pages;

use App\Filament\Resources\AtivoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAtivo extends ViewRecord
{
    protected static string $resource = AtivoResource::class;
    protected static ?string $title = 'Visualizar Ativo';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            
        ];
    }
}
