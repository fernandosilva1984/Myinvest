<?php

namespace App\Filament\Resources\AtivoResource\Pages;

use App\Filament\Resources\AtivoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAtivo extends EditRecord
{
    protected static string $resource = AtivoResource::class;
    protected static ?string $title = 'Editar Ativo';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
