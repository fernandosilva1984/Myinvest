<?php

namespace App\Filament\Resources\PosicaoResource\Pages;

use App\Filament\Resources\PosicaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPosicao extends EditRecord
{
    protected static string $resource = PosicaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
