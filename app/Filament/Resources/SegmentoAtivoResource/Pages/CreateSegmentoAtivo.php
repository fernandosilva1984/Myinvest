<?php

namespace App\Filament\Resources\SegmentoAtivoResource\Pages;

use App\Filament\Resources\SegmentoAtivoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSegmentoAtivo extends CreateRecord
{
    protected static string $resource = SegmentoAtivoResource::class;
    protected static ?string $title = 'Novo Segmento';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
