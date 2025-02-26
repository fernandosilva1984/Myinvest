<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FundoSaudeResource\Pages;
use App\Filament\Resources\FundoSaudeResource\RelationManagers;
use App\Models\FundoSaude;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Leandrocfe\FilamentPtbrFormFields\Money;

class FundoSaudeResource extends Resource
{
    protected static ?string $model = FundoSaude::class;
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 13;
    protected static ?string $navigationIcon = 'heroicon-o-lifebuoy';
    protected static ?string $navigationLabel = 'Fundo de Saúde';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('data_')
                    ->label('Data')
                    ->required(),
                Money::make('valor')
                    ->label('Valor')
                    ->required()
                    ->prefix('R$'),
                Select::make('tipo')
                    ->label('Tipo')
                    ->required(false)
                    ->searchable()
                    ->options([
                        'Retirada' => 'Retirada',
                        'Deposito' => 'Deposito',
                    ]),
                Select::make('categoria')
                    ->label('Categoria')
                    ->required(false)
                    ->searchable()
                    ->options([
                        'Consultas' => 'Consultas',
                        'Entradas' => 'Entradas',
                        'Exames' => 'Exames',
                        'Internaçoes' => 'Internações',
                        'Outros' => 'Outros',
                        'Procedimentos' => 'Procedimentos',
                    ]),
                TextInput::make('descricao')
                    ->label('Descrição'),
                Select::make('usuario')
                    ->label('Usuário')
                    ->searchable()
                    ->options([
                        'Fernando' => 'Fernando',
                        'Libina' => 'Libina',
                        'Marina' => 'Marina',
                        'Ester' => 'Ester',
                    ]),
                TextInput::make('comprovante')
                    ->label('Comprovante'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->striped()
        ->defaultSort('data_','desc')
        ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 1))
            ->columns([
                Tables\Columns\TextColumn::make('data_')
                    ->label('Data')
                    ->date($format = 'd/m/y')
                    ->searchable(),
                Tables\Columns\TextColumn::make('valor')
                    ->money('brl'),
                Tables\Columns\TextColumn::make('tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('usuario')
                    ->label('Usuário')
                    ->searchable(),
                Tables\Columns\TextColumn::make('categoria'),
                Tables\Columns\TextColumn::make('descricao')
                    ->label('Descrição')
                    ->searchable(),
            ])
            ->recordClasses(fn (FundoSaude $record) => match ($record->tipo) {
                'Deposito' => 'opacity-30',
                'Retirada' => 'background-color: #333',
                default => null,
            })
            ->filters([
                //
            ])
            ->actions([
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFundoSaudes::route('/'),
        ];
    }
}
