<?php

namespace App\Filament\Resources\CarteiraResource\Pages;

use App\Filament\Resources\CarteiraResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCarteira extends CreateRecord
{
    protected static string $resource = CarteiraResource::class;
    protected static ?string $title = 'Nova Carteira';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
