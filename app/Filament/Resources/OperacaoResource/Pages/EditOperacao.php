<?php

namespace App\Filament\Resources\OperacaoResource\Pages;

use App\Filament\Resources\OperacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOperacao extends EditRecord
{
    protected static string $resource = OperacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
