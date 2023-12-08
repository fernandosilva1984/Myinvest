<?php

namespace App\Filament\Resources\MovimentacaoResource\Pages;

use App\Filament\Resources\MovimentacaoResource;
use App\Models\Carteira;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMovimentacao extends CreateRecord
{
    protected static string $resource = MovimentacaoResource::class;
    protected static ?string $title = 'Nova Movimentação';

    protected function afterCreate(): void
    {
        if ($this->record->tipo == 'A'){
            $carteira = Carteira::find($this->record->id_carteira);
            $carteira->Valor_Investido += $this->record->valor_total;
            $carteira->save();   
        }
        else
        {   
            $carteira = Carteira::find($this->record->id_carteira);
            $carteira->Valor_Investido -= $this->record->valor_total;
            $carteira->save();   
        }
    
    }
}

