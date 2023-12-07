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
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Grid;

class DividendoResource extends Resource
{
    protected static ?string $model = Dividendo::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Proventos';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                
                ->schema([
                Forms\Components\Select::make('id_ativo')
                ->label('Ativo')
                ->required(false)
                ->searchable()
                ->options((
                    Ativo::all()->sortBy('Ticket')->pluck('Ticket','id')->toArray()
                )),
                Forms\Components\DatePicker::make('data_ref')
               // ->native(false)
               // ->displayFormat('m/Y')
                ->label('Periodo de Ref')
                    ->required(),
                Forms\Components\DatePicker::make('data_com')
                    ->label('Data Com')
                    ->required(),
                Forms\Components\DatePicker::make('data_pag')
                    ->label('Data de Pagamento')
                    ->required(),
                Forms\Components\TextInput::make('valor_dividendo')
                    ->label('Dividendo')
                    ->required()
                    ->prefix('R$')
                    ->currencyMask(thousandSeparator: '.',decimalSeparator: ',', precision: 2),
                Forms\Components\TextInput::make('valor_jcp')
                    ->label('JCP')
                    ->prefix('R$')
                    ->currencyMask(thousandSeparator: '.',decimalSeparator: ',', precision: 2)
                    ->reactive(),
                Forms\Components\TextInput::make('valor_total')
                    
                    ->disabled()
                    
                    ->prefix('R$')
             
                ->currencyMask(thousandSeparator: '.',decimalSeparator: ',', precision: 2),
                Forms\Components\TextInput::make('obs')
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
