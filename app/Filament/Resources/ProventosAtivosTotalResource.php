<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProventosAtivosTotalResource\Pages;
use App\Filament\Resources\ProventosAtivosTotalResource\RelationManagers;
use App\Models\Ativo;
use App\Models\ProventoAtivosTotal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProventosAtivosTotalResource extends Resource
{
    protected static ?string $model = Ativo::class;

    protected static ?string $navigationGroup = 'Dividendos por Carteira';
    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Total Recebido';

    public static function table(Table $table): Table
    {
        return $table
            
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 1)->where('id_tipo','<=', 2))
                ->columns([
                
                 Tables\Columns\TextColumn::make('Ticket')->label('Ativo'),
                 ...self::getMonthlyProventoColumns(),
                ]);
           
    }
    protected static function getMonthlyProventoColumns(): array
{
    $columns = [];

    // Busca todos os meses e anos distintos disponíveis no banco de dados
    $periods = ProventoAtivosTotal::query()
        ->selectRaw("YEAR(data_pag) as year, DATE_FORMAT(data_pag, '%Y-%m') as month")
        ->where('saldo_operacoes', '<>', 0) // Filtra saldo_operacoes diferente de zero
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc') // Ordena os anos em ordem crescente
        ->orderBy('month', 'asc') // Ordena os meses em ordem crescente
        ->get();

    // Agrupa os períodos por ano
    $groupedPeriods = $periods->groupBy('year');

    // Coluna para somar todos os proventos anteriores a 2025
    $columns[] = Tables\Columns\TextColumn::make("provento_pre_2025")
        ->label("TOTAL")
        ->money('brl')
        ->getStateUsing(function ($record) {
            return ProventoAtivosTotal::query()
                ->where('id_ativo', $record->id)
                ->where('saldo_operacoes', '<>', 0)
                //->whereYear('data_pag', '<', 2025) // Filtra anos anteriores a 2025
                ->sum('provento') ?? ''; // Soma os proventos
        });

    // Colunas para todos os anos
    foreach ($groupedPeriods as $year => $months) {
        // Coluna com o total do ano
      /*  $columns[] = Tables\Columns\TextColumn::make("provento_total_$year")
            ->label("$year")
            ->money('brl')
            ->getStateUsing(function ($record) use ($year) {
                return ProventoAtivosCart01::query()
                    ->where('id_ativo', $record->id)
                    ->where('saldo_operacoes', '<>', 0)
                    ->whereYear('data_pag', $year) // Filtra pelo ano
                    ->sum('provento') ?? ''; // Soma os proventos do ano
            });
*/
        // Colunas para cada mês do ano (apenas a partir de 2025, em ordem crescente)
        if ($year >= 2025) {
            foreach ($months->sortBy('month') as $period) {
                $month = $period->month;
                $columns[] = Tables\Columns\TextColumn::make("provento_$month")
                    ->label(ucfirst(\Carbon\Carbon::createFromFormat('Y-m', $month)->format('m/Y')))
                    ->money('brl')
                    ->getStateUsing(function ($record) use ($month) {
                        return ProventoAtivosTotal::query()
                            ->where('id_ativo', $record->id)
                            ->where('saldo_operacoes', '<>', 0)
                            ->whereRaw("DATE_FORMAT(data_pag, '%Y-%m') = ?", [$month])
                            ->sum('provento') ?? ''; // Soma os proventos do mês
                    });
            }
        }
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
            'index' => Pages\ListProventosAtivosTotals::route('/'),
            
        ];
    }    
}
