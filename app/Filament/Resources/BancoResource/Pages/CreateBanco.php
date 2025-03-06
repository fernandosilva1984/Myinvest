<?php

namespace App\Filament\Resources\BancoResource\Pages;

use App\Filament\Resources\BancoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBanco extends CreateRecord
{
    protected static string $resource = BancoResource::class;
    protected static ?string $title = 'Novo Banco';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
