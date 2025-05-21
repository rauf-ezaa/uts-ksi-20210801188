<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MedicalRecord;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MedicalRecordResource\Pages;
use App\Filament\Resources\MedicalRecordResource\RelationManagers;

class MedicalRecordResource extends Resource
{
    protected static ?string $model = MedicalRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('obat')
                    ->maxLength(20),
                Forms\Components\TextInput::make('diagnosa')
                    ->required()
                    ->maxLength(100),
                        Forms\Components\Select::make('pasien_id')
                        ->relationship('Pasien', 'nama_lengkap')
                        ->required()
                        ->preload()
                        ->searchable(),
                
                Forms\Components\Hidden::make('docter_id')
                ->default(function () {
                    $user = Auth::user();
                    return $user?->doctor?->id;
                }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('obat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('diagnosa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Pasien.nama_lengkap')
                    ->label('nama pasien')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListMedicalRecords::route('/'),
            'create' => Pages\CreateMedicalRecord::route('/create'),
            'edit' => Pages\EditMedicalRecord::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
    
        if ($user && $user->docter) {
            // Ambil id dari tabel 'docters' yang berelasi dengan user
            $docterId = $user->docter->id;
    
            // Filter hanya medical record milik dokter ini
            return parent::getEloquentQuery()->where('docter_id', $docterId);
        }
    
        return parent::getEloquentQuery();
    }

}
