<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DividendoResource\Pages;
use App\Filament\Resources\DividendoResource\RelationManagers;
use App\Models\Dividendo;
use App\Models\Ativo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Grid;
use Leandrocfe\FilamentPtbrFormFields\Money;
use Filament\Forms\Get;
use Filament\Forms\Set;


class DividendoResource extends Resource
{
    protected static ?string $model = Dividendo::class;
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Proventos';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()

                ->schema([
                Select::make('id_ativo')
                ->label('Ativo')
                ->required(false)
                ->searchable()
                ->options((
                    Ativo::all()->sortBy('Ticket')->where('status',1)->pluck('Ticket','id')->toArray()
                )),
                TextInput::make('valor_dividendo')
                    ->label('Dividendo')
                    ->required()
                    ->prefix('R$'),
                TextInput::make('valor_jcp')
                    ->label('JCP/Amort')
                    ->prefix('R$')

                    ->reactive(),

                   DatePicker::make('data_ref')

                     ->label('Periodo de Ref')
                     ->required(),
                DatePicker::make('data_com')
                    ->label('Data Com')
                    ->live(debounce: 500) // Atualiza automaticamente
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $dividendo =  floatval(str_replace(',', '.',$get('valor_dividendo') ?? 0)); // Converte para número
                        $jcp = floatval(str_replace(',', '.', $get('valor_jcp') ?? 0));
                        $set('valor_total', $dividendo + $jcp);
                    })
                    ->required(),
                DatePicker::make('data_pag')
                    ->label('Data de Pagamento')
                    ->required(),

                Money::make('valor_total')
                    ->disabled()
                    ->prefix('R$'),
                TextInput::make('obs')
                    ->label('Observação')
                    ->columnSpan(3),
            ])
            ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->striped()
        ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 1))
        ->defaultSort('data_ref','desc')
            ->groups([
                Group::make('ativo.Ticket')
                ->label('Ativo')
                ->collapsible()
                ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('Ticket', $direction)),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('ativo.Ticket')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_ref')
                    ->label('Mês Ref')
                    ->searchable()
                    ->date($format = 'F/Y')
                    ->sortable(),
                    Tables\Columns\TextColumn::make('data_com')
                    ->label('Data Com')
                    ->date($format = 'd/m/y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_pag')
                    ->label('Data Pag')
                    ->date($format = 'd/m/y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('valor_dividendo')
                    ->label('Dividendo')
                    ->money('brl'),
                Tables\Columns\TextColumn::make('valor_jcp')
                    ->label('JCP')
                    ->money('brl'),
                Tables\Columns\TextColumn::make('valor_total')
                    ->label('Total')
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
            'index' => Pages\ListDividendos::route('/'),
            'create' => Pages\CreateDividendo::route('/create'),
            'view' => Pages\ViewDividendo::route('/{record}'),
            'edit' => Pages\EditDividendo::route('/{record}/edit'),
        ];
    }
}
