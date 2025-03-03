<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PosicaoAtivosCart1Resource\Pages;
use App\Filament\Resources\PosicaoAtivosCart1Resource\RelationManagers;
use App\Models\PosicaoAtivosCart1;
use App\Models\Ativo;
use Illuminate\Support\Facades\DB;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PosicaoAtivosCart1Resource extends Resource
{
    protected static ?string $model = Ativo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Carteira 1';


    public static function table(Table $table): Table
    {
        return $table
        ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 1)->where('id_tipo','<=', 2))
        ->columns([
         //   Tables\Columns\TextColumn::make('id_ativo')->label('ID Ativo'),
         //   Tables\Columns\TextColumn::make('id_carteira')->label('ID Carteira'),
         Tables\Columns\TextColumn::make('Ticket')->label('Ativo')
         /*->getStateUsing(function ($record) {
            // Busca o nome do ativo relacionado
            $ativo = Ativo::find($record->id_ativo);
            return $ativo ? $ativo->Ticket : 'Ativo não encontrado';
        })*/,
           // Tables\Columns\TextColumn::make('ticket_ativo')->label('Ticket Ativo'),
          //  Tables\Columns\TextColumn::make('data_com')->label('Data Compra')->date(),
            //Tables\Columns\TextColumn::make('saldo_operacoes')->label('Saldo Operações'),
            //Tables\Columns\TextColumn::make('provento')->label('Provento'),
            // Adicione colunas dinâmicas para cada mês
            ...self::getMonthlyProventoColumns(),
        ]);

    }

    protected static function getMonthlyProventoColumns(): array
    {
        $columns = [];
    
        // Supondo que você queira os últimos 12 meses
        for ($i = 0; $i < 12; $i++) {
            $month = now()->subMonths($i)->format('Y-m');
            $columns[] = Tables\Columns\TextColumn::make("provento_$month")
                ->label(ucfirst(now()->subMonths($i)->format('m/Y')))
                ->money('brl')
                ->getStateUsing(function ($record) use ($month) {
                    return PosicaoAtivosCart1::query()
                        ->where('id_ativo', $record->id)
                        ->where('saldo_operacoes', '<>', 0) // Filtra saldo_operacoes diferente de zero
                        ->whereRaw("DATE_FORMAT(data_com, '%Y-%m') = ?", [$month])
                        ->groupBy('id_ativo') // Agrupa por id_ativo para evitar duplicações
                        ->selectRaw('SUM(provento) as total_provento') // Soma os proventos
                        ->value('total_provento') ?? ""; // Retorna o valor da soma ou 0 se não houver resultados
                });
        }
    
        return $columns;
    }

 


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosicaoAtivosCart1s::route('/'),
           // 'create' => Pages\CreatePosicaoAtivosCart1::route('/create'),
           // 'edit' => Pages\EditPosicaoAtivosCart1::route('/{record}/edit'),
        ];
    }
}
