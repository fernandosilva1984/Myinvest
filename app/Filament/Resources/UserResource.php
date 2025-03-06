<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{

    protected static ?string $navigationGroup = 'Configurações';
    protected static ?int $navigationSort = 3;
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Usuários';

    protected static ?string $modelLabel = 'usuário';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->label(label: 'Nome Completo')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->label(label: 'E-mail')
                ->email()
                ->required()
                ->maxLength(255),
            //Forms\Components\DateTimePicker::make('email_verified_at'),
            Forms\Components\TextInput::make('password')
                ->label(label: 'Senha')
                ->password()
                ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                ->dehydrated(fn ($state) => filled($state))
                ->required(fn (string $context): bool => $context === 'create'),
            Forms\Components\Select::make('roles')
                ->label('Perfil')
              //  ->multiple()
                ->preload()
                ->relationship('roles', 'name', fn(builder $query) => auth()->user()->hasRole('TI')? null : 
                $query->where('name', '!=', 'TI')),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 1))
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->label(label: 'Nome Completo'),
            Tables\Columns\TextColumn::make('email')
                ->label(label: 'E-mail'),
            Tables\Columns\TextColumn::make('roles.name')
                ->label('Perfil')
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime(format: 'd/m/Y H:i:s')
                ->label(label: 'Data de Cadastro'),
           // Tables\Columns\TextColumn::make('updated_at')
           //     ->dateTime(),
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
                ->visible(fn (User $user): bool => auth()->user()->can('delete', $user))
                ->modalHeading('Tem certeza?')
                ->modalDescription('Essa ação não pode ser desfeita.')
                ->modalButton('Excluir')
                //->can('delete', User::class)
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder

    {
        return auth()->user()->hasRole('TI') ? parent::getEloquentQuery() : parent::getEloquentQuery()->whereHas('roles', fn (Builder $query) => $query->where('name', '!=', 'TI'));
    }
}
