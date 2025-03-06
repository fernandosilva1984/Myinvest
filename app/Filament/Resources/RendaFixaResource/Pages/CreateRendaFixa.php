<?php

namespace App\Filament\Resources\RendaFixaResource\Pages;

use App\Filament\Resources\RendaFixaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRendaFixa extends CreateRecord
{
    protected static string $resource = RendaFixaResource::class;
    protected static ?string $title = 'Nova Aplicação';
   
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
