<?php

namespace App\Filament\Resources\CotacaoResource\Pages;

use App\Filament\Resources\CotacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCotacao extends EditRecord
{
    protected static string $resource = CotacaoResource::class;
    protected static ?string $title = 'Editar Cotação';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
