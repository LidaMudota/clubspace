<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Event;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ClubspaceStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Events', (string) Event::query()->count()),
            Stat::make('Bookings', (string) Booking::query()->count()),
            Stat::make('Payments', (string) Payment::query()->count()),
        ];
    }
}
