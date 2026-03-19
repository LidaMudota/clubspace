<?php

namespace App\Filament\Resources;

use App\Models\Booking;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class BookingsResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationLabel = 'Bookings';

    protected static ?string $modelLabel = 'Booking';

    protected static ?string $pluralModelLabel = 'Bookings';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([])
            ->filters([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\Bookings\Pages\ListBookings::route('/'),
            'create' => \App\Filament\Resources\Bookings\Pages\CreateBooking::route('/create'),
            'edit' => \App\Filament\Resources\Bookings\Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
