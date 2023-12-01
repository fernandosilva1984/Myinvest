<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OperacaoResource\Pages;
use App\Filament\Resources\OperacaoResource\RelationManagers;
use App\Models\Operacao;
use App\Models\Ativo;
use App\Models\Carteira;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OperacaoResource extends Resource
{
    protected static ?string $model = Operacao::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Operações';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_carteira')
                ->label('Carteira')
                ->required()
                ->searchable()
                ->options((
                    Carteira::all()->pluck('Nome','id')->toArray()
                )),
                    Forms\Components\Select::make('id_ativo')
                    ->label('Ativo')
                    ->required()
                    ->searchable()
                    ->options((
                        Ativo::all()->pluck('Ticket','id')->toArray()
                    )),
                Forms\Components\DatePicker::make('data')
                    ->label('Data')
                    ->required(),
                Forms\Components\TextInput::make('qtd')
                    ->label('Quantidade')
                    ->numeric(),
                Forms\Components\TextInput::make('valor_unitario')
                    ->label('Valor Unitário')
                    ->prefix('R$')
                    ->currencyMask(thousandSeparator: '.',decimalSeparator: ',', precision: 2),
                Forms\Components\TextInput::make('valor_total')
                    ->label('Valor Total')
                    ->prefix('R$')
                    ->currencyMask(thousandSeparator: '.',decimalSeparator: ',', precision: 2)                      
                    ->disabled(),
                Forms\Components\Select::make('tipo')
                    ->options([
                        'C' => 'Compra',
                        'V' => 'Venda',
                        'A' => 'Aporte',
                        'S' => 'Saque',
                    ]),
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
            ->groups([
                Group::make('ativo.Ticket')
                ->label('Ativo')
                ->collapsible()
                ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('Ticket', $direction)),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('data')
                    ->label('Data')
                    ->date($format = 'j/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('carteira.Nome')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ativo.Ticket')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('qtd')
                    ->label('Qtd')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('valor_unitario')
                    ->label('V. Unitário')    
                    ->money('brl'),
                Tables\Columns\TextColumn::make('valor_total')
                    ->label('V. Total')    
                 ->money('brl'),
                Tables\Columns\TextColumn::make('tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'C' => 'success',
                        'V' => 'danger',
                        'A' => 'gray',
                        'S' => 'warning',
                        
                    }),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListOperacaos::route('/'),
            'create' => Pages\CreateOperacao::route('/create'),
            'view' => Pages\ViewOperacao::route('/{record}'),
            'edit' => Pages\EditOperacao::route('/{record}/edit'),
        ];
    }
}
