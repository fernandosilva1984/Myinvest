<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SegmentoAtivoResource\Pages;
use App\Filament\Resources\SegmentoAtivoResource\RelationManagers;
use App\Models\SegmentoAtivo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SegmentoAtivoResource extends Resource
{
    protected static ?string $model = SegmentoAtivo::class;
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 9;

    protected static ?string $navigationLabel = 'Segmentos';

    protected static ?string $navigationIcon = 'heroicon-m-server-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('segmentoAtivo')
                    ->label('Descrição')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 1))
            ->columns([
                Tables\Columns\TextColumn::make('segmentoAtivo')
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
            'index' => Pages\ListSegmentoAtivos::route('/'),
            'create' => Pages\CreateSegmentoAtivo::route('/create'),
            'view' => Pages\ViewSegmentoAtivo::route('/{record}'),
            'edit' => Pages\EditSegmentoAtivo::route('/{record}/edit'),
        ];
    }
}
