<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use App\Models\Classroom;

class ClassStatsWidget extends BaseWidget
{
    protected static ?string $maxHeight = null; 
    protected static bool $isLazy = false; 
    
    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation|null
    {
        return Classroom::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Nama Kelas')
                ->sortable()
                ->searchable()
                ->wrap(),

            TextColumn::make('students_count')
                ->label('Total Murid')
                ->counts('students')
                ->sortable(),

            TextColumn::make('teachers')
                ->label('Guru Pengajar')
                ->formatStateUsing(fn ($record) => $record->teachers->isNotEmpty()
                    ? $record->teachers->pluck('name')->join(', ')
                   : 'Belum ada guru')
                ->wrap(),
        ];
    }
}
