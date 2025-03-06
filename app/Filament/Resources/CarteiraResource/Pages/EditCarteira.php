<?php

namespace App\Filament\Resources\CarteiraResource\Pages;

use App\Filament\Resources\CarteiraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCarteira extends EditRecord
{
    protected static string $resource = CarteiraResource::class;
    protected static ?string $title = 'Editar Carteira';

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
