<?php

namespace App\Filament\Resources\SegmentoAtivoResource\Pages;

use App\Filament\Resources\SegmentoAtivoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSegmentoAtivo extends EditRecord
{
    protected static string $resource = SegmentoAtivoResource::class;
    protected static ?string $title = 'Editar Segmento';


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
