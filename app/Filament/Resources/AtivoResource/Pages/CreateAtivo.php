<?php

namespace App\Filament\Resources\AtivoResource\Pages;

use App\Filament\Resources\AtivoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAtivo extends CreateRecord
{
    protected static string $resource = AtivoResource::class;
    protected static ?string $title = 'Novo Ativo';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
