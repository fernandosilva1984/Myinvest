<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BancoResource\Pages;
use App\Filament\Resources\BancoResource\RelationManagers;
use App\Models\Banco;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class BancoResource extends Resource
{
    protected static ?string $model = Banco::class;

    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 10;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nome')
                    ->label(label: 'Nome')
                    ->required()
                    ->maxLength(255),
                TextInput::make('razao_social')
                    ->label(label: 'Razão Social')
                    ->columnSpan(3)
                    ->required()
                    ->maxLength(255),
                TextInput::make('CNPJ')
                    ->label(label: 'CNPJ')
                    ->mask('99.999.999/9999-99')
                    ->required()
                    ->maxLength(255),
                TextInput::make('logradouro')
                    ->required()
                    ->maxLength(255),
                TextInput::make('bairro')
                    ->required()
                    ->maxLength(255),
                TextInput::make('cidade')
                    ->required()
                    ->maxLength(255),
                TextInput::make('UF')
                    ->label(label: 'UF')
                    ->required()
                    ->maxLength(255),
                Toggle::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 1))
            ->columns([
                TextColumn::make('nome')
                    ->label(label: 'Nome')
                    ->searchable(),
                TextColumn::make('razao_social')
                    ->label(label: 'Razão Social')
                    ->searchable(),
                TextColumn::make('CNPJ')
                    ->label(label: 'CNPJ')
                    ->searchable(),
                IconColumn::make('status')
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
            'index' => Pages\ListBancos::route('/'),
            'create' => Pages\CreateBanco::route('/create'),
            'view' => Pages\ViewBanco::route('/{record}'),
            'edit' => Pages\EditBanco::route('/{record}/edit'),
        ];
    }
}
