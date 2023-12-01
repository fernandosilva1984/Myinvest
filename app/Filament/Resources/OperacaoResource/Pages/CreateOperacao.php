<?php

namespace App\Filament\Resources\OperacaoResource\Pages;

use App\Filament\Resources\OperacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOperacao extends CreateRecord
{
    protected static string $resource = OperacaoResource::class;
    protected static ?string $title = 'Nova Operação';

}
