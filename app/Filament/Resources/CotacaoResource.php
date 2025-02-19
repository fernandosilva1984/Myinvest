<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CotacaoResource\Pages;
use App\Filament\Resources\CotacaoResource\RelationManagers;
use App\Models\Cotacao;
use App\Models\Ativo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Grouping\Group;
use Filament\Forms\Components\Grid;
use Leandrocfe\FilamentPtbrFormFields\Money;

class CotacaoResource extends Resource
{
    protected static ?string $model = Cotacao::class;

    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 7;
    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-ripple';
    protected static ?string $navigationLabel = 'Cotações';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                ->schema([
                Forms\Components\Select::make('id_ativo')
                ->label('Ativo')
                ->required()
                ->searchable()
                ->options((
                Ativo::all()->sortBy('Ticket')->where('status',1)->pluck('Ticket','id')->toArray()
                )),
                Forms\Components\DateTimePicker::make('data_hora')
                ->label('Data/Hora')
                ->required(),
                TextInput::make('valor')
                ->required()
                ->label('Valor')
                ->prefix('R$'),
              //  ->currencyMask(thousandSeparator: '.',decimalSeparator: ',', precision: 2),
            ])
            ->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->striped()
        ->defaultSort('data_hora','desc')
        ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 1))

       /* ->groups([
        /*    Group::make('ativo.Ticket')
            ->label('Ativo')
            ->collapsible()
            ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('Ticket', $direction)),
        ])*/
            ->columns([
                Tables\Columns\TextColumn::make('ativo.Ticket')
                ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_hora')
                ->searchable()
                    ->label('Data/Hora')
                    ->dateTime($format = 'd/m/y H:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make('valor')
                    ->label('Cotação')
                    ->money('brl'),


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
                ->modalHeading('Tem certeza?')
                ->modalDescription('Essa ação não pode ser desfeita.')
                ->modalButton('Excluir')
                ->modalWidth('md') // ✅ Correção: Usando o enum corretamente
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
            'index' => Pages\ListCotacaos::route('/'),
            'create' => Pages\CreateCotacao::route('/create'),
            'view' => Pages\ViewCotacao::route('/{record}'),
            'edit' => Pages\EditCotacao::route('/{record}/edit'),
        ];
    }
}
