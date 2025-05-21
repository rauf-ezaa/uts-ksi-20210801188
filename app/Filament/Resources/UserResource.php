<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                
                    Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->revealable(), 
                
                    Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->required()
                    ->preload()
                    ->searchable(),
                            
                    Forms\Components\Group::make([

                            Forms\Components\Select::make('role')
                            ->label('Apakah akun untuk dokter ?')
                            ->options([
                            'doc' => 'iya',
                            'tidak' => '',
                            ])
                            ->required()
                            ->native(false)
                            ->visible(fn (?User $record) => $record === null)
                            ->reactive(),

                            
                            Forms\Components\TextInput::make('nip')
                            ->label('NIP')
                            ->visible(fn (?User $record, Get $get) =>
                                $get('role') === 'doc'
                            )
                            ->default(fn (?User $record) => $record?->doctor?->nip),
        
                            Forms\Components\TextInput::make('spesialis')
                            ->label('Spesialis')
                            ->visible(fn (Get $get) =>
                                $get('role') === 'doc'
                            )
                            
                        ])
                        
                    ]);
            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('doctor')
                    ->label('Status')
                    ->formatStateUsing(function ($record) {
                        return $record->doctor ? 'doctor' : '-';
                    })
                    ->badge()

            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Akun Pegawai/Dokter';
    }

    public static function getPluralLabel(): string
    {
        return 'List Akun ';
    }

    public static function beforeFill(Form $form, mixed $record): void
{
    $record->loadMissing('doctor');
}

    
}
