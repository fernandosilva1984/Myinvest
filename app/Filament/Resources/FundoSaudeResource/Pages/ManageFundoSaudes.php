<?php

namespace App\Filament\Resources\FundoSaudeResource\Pages;

use App\Filament\Resources\FundoSaudeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFundoSaudes extends ManageRecords
{
    protected static string $resource = FundoSaudeResource::class;
    protected static ?string $title = 'Fundo de Saúde';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Novo'),
        ];
    }
}
