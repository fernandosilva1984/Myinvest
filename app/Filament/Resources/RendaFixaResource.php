<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RendaFixaResource\Pages;
use App\Filament\Resources\RendaFixaResource\RelationManagers;
use App\Models\RendaFixa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RendaFixaResource extends Resource
{
    protected static ?string $model = RendaFixa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id_tipo')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('id_banco_emissor')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('id_banco_gestor')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('descrição')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('data_aplicacao'),
                Forms\Components\DatePicker::make('data_venc')
                    ->required(),
                Forms\Components\TextInput::make('valor_aplic')
                    ->numeric(),
                Forms\Components\TextInput::make('iof')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('ir')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('indice')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('taxa')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('taxa_rent')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('conta')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('status')
                    ->required(),
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
