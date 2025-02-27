<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProventoMesResource\Pages;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Ativo;
use App\Models\Operacao;
use App\Models\Dividendo;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;


class ProventoMesResource extends Resource
{
    protected static ?string $model = Ativo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /*public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Defina os campos do formulário aqui
            ]);
    }
*/
public static function table(Tables\Table $table): Tables\Table
{
    // Buscar os meses únicos de dividendos (YYYY-MM)
    $mesesProventos = Dividendo::selectRaw("DATE_FORMAT(data_pag, '%Y-%m') as mes")
        ->distinct()
        ->orderBy('mes')
        ->pluck('mes');

    return $table
        ->query(self::getMatrizQuery())
        ->columns(self::getTableColumns($mesesProventos))
        ->filters([])
        ->actions([]);
}

private static function getMatrizQuery()
{
    return Ativo::query()
        ->select('ativos.id', 'ativos.Ticket')
        ->leftJoinSub(self::getDividendoAgrupado(), 'dividendos', function ($join) {
            $join->on('ativos.id', '=', 'dividendos.id_ativo');
        });
}

private static function getDividendoAgrupado()
{
    return Dividendo::selectRaw("
            id_ativo,
            DATE_FORMAT(data_pag, '%Y-%m') as mes,
            SUM(valor_total) as total_dividendo
        ")
        ->groupBy('id_ativo', 'mes');
}
private static function getPosicaoAgrupada()
{
    return Operacao::selectRaw("
            id_ativo,
            DATE_FORMAT(data, '%Y-%m') as mes,
            SUM(CASE WHEN valor_total > 0 THEN qtd ELSE -qtd END) as saldo
        ")
        ->groupBy('id_ativo', 'mes');
}
private static function getTableColumns($mesesProventos)
{
    $colunas = [
        TextColumn::make('Ticket')->label('Ativo'),
    ];

    foreach ($mesesProventos as $mes) {
        $colunas[] = TextColumn::make("dividendos_{$mes}")
            ->label(Carbon::parse($mes . '-01')->translatedFormat('M/Y'))
            ->getStateUsing(fn ($record) => self::calcularProvento($record, $mes));
    }

    return $colunas;
}

private static function calcularProvento($record, $mes)
{
    $qtdPosicao = $record->{"posicao_$mes"} ?? 0;
    $totalDividendo = $record->{"dividendo_$mes"} ?? 0;

    return number_format($totalDividendo * $qtdPosicao, 2, ',', '.');
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProventoMes::route('/'),
            'create' => Pages\CreateProventoMes::route('/create'),
            'edit' => Pages\EditProventoMes::route('/{record}/edit'),
        ];
    }
}
