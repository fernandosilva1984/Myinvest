<?php

namespace App\Filament\Resources\MovimentacaoResource\Pages;

use App\Filament\Resources\MovimentacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMovimentacao extends CreateRecord
{
    protected static string $resource = MovimentacaoResource::class;
    protected static ?string $title = 'Nova Movimentação';
}
