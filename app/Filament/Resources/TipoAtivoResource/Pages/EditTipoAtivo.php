<?php

namespace App\Filament\Resources\TipoAtivoResource\Pages;

use App\Filament\Resources\TipoAtivoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTipoAtivo extends EditRecord
{
    protected static string $resource = TipoAtivoResource::class;
    protected static ?string $title = 'Editar Tipo';
    

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
