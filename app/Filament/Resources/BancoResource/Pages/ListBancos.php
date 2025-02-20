<?php

namespace App\Filament\Resources\BancoResource\Pages;

use App\Filament\Resources\BancoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBancos extends ListRecords
{
    protected static string $resource = BancoResource::class;
    protected static ?string $title = 'Bancos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Novo Banco'),
        ];
    }
}
