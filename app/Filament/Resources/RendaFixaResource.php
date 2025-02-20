<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RendaFixaResource\Pages;
use App\Filament\Resources\RendaFixaResource\RelationManagers;
use App\Models\RendaFixa;
use App\Models\Ativo;
use App\Models\Banco;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Leandrocfe\FilamentPtbrFormFields\Money;
use Filament\Forms\Components\Grid;

class RendaFixaResource extends Resource
{
    protected static ?string $model = RendaFixa::class;
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 11;
    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';
    protected static ?string $navigationLabel = 'Renda Fixa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                ->schema([
                Select::make('id_ativo')
                    ->columnSpan(1)
                    ->label('Tipo')
                    ->required()
                    ->searchable()
                    ->options((
                Ativo::all()->sortBy('Ticket')->where('status',1)->where('id_tipo',3)->pluck('Ticket','id')->toArray() ))
                    ->required(),
                TextInput::make('descrição')
                    ->columnSpan(3)
                    ->label( 'Descrição')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('data_aplicacao')
                    ->label('Data da Aplicação')
                    ->required(),
                DatePicker::make('data_venc')
                    ->label( 'Vencimento')
                    ->required(),
                Select::make('id_banco_emissor')
                    ->label('Banco Emissor')
                    ->required()
                    ->searchable()
                    ->options((
                Banco::all()->sortBy('nome')->where('status',1)->pluck('nome','id')->toArray() ))
                    ->required(),
                    Select::make('id_banco_gestor')
                    ->label('Banco Gestor')
                    ->required()
                    ->searchable()
                    ->options((
                Banco::all()->sortBy('nome')->where('status',1)->pluck('nome','id')->toArray() ))
                    ->required(),
                Money::make('valor_aplic')
                    ->label( 'Valor da Aplicação')
                    ->prefix('R$')
                    ->required(),
                TextInput::make('taxa')
                    ->label( 'Taxa de referência')
                    ->required()
                    ->suffix('%')
                    ->numeric(),
                TextInput::make('taxa_rent')
                    ->label( 'Rentabilidade')
                    ->required()
                    ->suffix('%')
                    ->numeric(),
                TextInput::make('conta')
                    ->required()
                    ->maxLength(255),
                Toggle::make('status')
                    ->required(),
            ])
            ->columns(6)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_tipo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('id_banco_emissor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('id_banco_gestor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('descrição')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_aplicacao')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_venc')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('valor_aplic')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('iof')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ir')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('indice')
                    ->searchable(),
                Tables\Columns\TextColumn::make('taxa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('taxa_rent')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('conta')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
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
            'index' => Pages\ListRendaFixas::route('/'),
            'create' => Pages\CreateRendaFixa::route('/create'),
            'view' => Pages\ViewRendaFixa::route('/{record}'),
            'edit' => Pages\EditRendaFixa::route('/{record}/edit'),
        ];
    }
}
