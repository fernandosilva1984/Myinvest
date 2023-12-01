<?php

namespace App\Filament\Resources\DividendoResource\Pages;

use App\Filament\Resources\DividendoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDividendo extends CreateRecord
{
    protected static string $resource = DividendoResource::class;
    protected static ?string $title = 'Novo Dividendo';
}
