<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Filament\Resources\AnnouncementResource\RelationManagers;
use App\Models\Announcement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\ImageColumn;
use Filament\Resources\Pages\CreateRecord;

class AnnouncementResource extends Resource
{
    protected static ?string $navigationGroup = 'Information';
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('title')
                ->required()
                ->maxLength(255),
            Textarea::make('content')
                ->required(),
            FileUpload::make('image')
                ->label('Gambar')
                ->image()
                ->disk('public') // Menyimpan ke disk 'public'
                ->directory('announcements') // Folder penyimpanan
                ->required(),
            DatePicker::make('published_at')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('title')
                ->label('Judul')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('content')
                ->label('Konten')
                ->limit(50),
            Tables\Columns\ImageColumn::make('image') // Ganti 'images' menjadi 'image'
                ->label('Gambar')
                ->size(100)
                ->disk('public')
                ->getStateUsing(fn($record) => $record->image ? asset('storage/' . $record->image) : null)
                ->square(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Dibuat Pada')
                ->dateTime(),
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
            Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}

class CreateAnnouncement extends CreateRecord
{
    protected function getCreatedNotificationRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
