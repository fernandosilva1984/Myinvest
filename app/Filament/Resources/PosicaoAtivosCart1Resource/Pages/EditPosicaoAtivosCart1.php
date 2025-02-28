<?php

namespace App\Filament\Resources\PosicaoAtivosCart1Resource\Pages;

use App\Filament\Resources\PosicaoAtivosCart1Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPosicaoAtivosCart1 extends EditRecord
{
    protected static string $resource = PosicaoAtivosCart1Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
