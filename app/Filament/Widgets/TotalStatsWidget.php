<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Announcement;
use App\Models\Post;

class TotalStatsWidget extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Pengumuman', Announcement::count())
                ->icon('heroicon-o-bell')
                ->color('info'),

            Card::make('Total Berita', Post::count())
                ->icon('heroicon-o-newspaper')
                ->color('success'),
        ];
    }
}