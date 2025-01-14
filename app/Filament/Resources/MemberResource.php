<?php
namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationLabel = 'Member';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_pelanggan')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Pelanggan'),

                Forms\Components\TextInput::make('no_telepon')
                    ->required()
                    ->maxLength(15)
                    ->label('Nomor Telepon')
                    ->unique(ignoreRecord: true),

                Forms\Components\Select::make('id_level')
                    ->label('Level')
                    ->relationship('level', 'nama_level')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_pelanggan')->label('ID Pelanggan'),
                
                TextColumn::make('nama_pelanggan')->label('Nama Pelanggan')
                ->searchable(),
                TextColumn::make('no_telepon')->label('Nomor Telepon'),
                TextColumn::make('level.nama_level')->label('Level'),
                TextColumn::make('total_poin')->label('Total Poin'), // Menggunakan accessor
                
            ])
            ->filters([
                // Tambahkan filter sesuai kebutuhan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // Aksi edit
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
            // Tambahkan relasi jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
