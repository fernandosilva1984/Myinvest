<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovimentacaoResource\Pages;
use App\Filament\Resources\MovimentacaoResource\RelationManagers;
use App\Models\Movimentacao;
use App\Models\Carteira;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Leandrocfe\FilamentPtbrFormFields\Money;

class MovimentacaoResource extends Resource
{
    protected static ?string $model = Movimentacao::class;
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';
    protected static ?string $navigationLabel = 'Movimentações';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('id_carteira')
                    ->label('Carteira')
                    ->required()
                    ->searchable()

                    ->options((
                    Carteira::all()->sortBy('Nome')->pluck('Nome','id')->toArray()
                )),
                Forms\Components\DatePicker::make('data')
                    ->label('Data')
                    ->required(),
                    Money::make('valor_total')
                    ->label('Valor')
                    ->prefix('R$'),
                  //  ->currencyMask(thousandSeparator: '.',decimalSeparator: ',', precision: 2),
                Forms\Components\Radio::make('tipo')
                    ->required()
                    ->default('A')
                    ->reactive()
                    ->afterStateUpdated(function($state, $set, $get){
                        $valor_total = 'valor_total';
                        if ($state == "S"){
                            $set('valor_total', $get('valor_total'));
                        }
                    })
                    ->options([
                        'A' => 'Aporte',
                        'D' => 'Dividendo',
                        'S' => 'Saque',
                ]),
                Forms\Components\TextInput::make('obs')
                    ->label('Observação')
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->striped()
            ->defaultSort('data','desc')
            ->groups([
                Group::make('carteira.Nome')
                ->label('Carteira')
                ->collapsible()
                ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('Nome', $direction)),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('carteira.Nome')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data')
                    ->date($format = 'd/m/y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('valor_total')
                    ->Label('Valor')
                    ->sortable()
                    ->money('brl'),
                Tables\Columns\TextColumn::make('tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                    'A' => 'success',
                    'D' => 'info',
                    'S' => 'danger',
                }),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->label('')
                ->tooltip('Visualizar'),
                Tables\Actions\EditAction::make()
                ->label('')
                ->tooltip('Editar'),
                Tables\Actions\DeleteAction::make()
                ->label('')
                ->tooltip('Excluir'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListMovimentacaos::route('/'),
            'create' => Pages\CreateMovimentacao::route('/create'),
            'view' => Pages\ViewMovimentacao::route('/{record}'),
            'edit' => Pages\EditMovimentacao::route('/{record}/edit'),
        ];
    }
}
