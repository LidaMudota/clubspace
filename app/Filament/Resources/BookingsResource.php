<?php

namespace App\Filament\Resources;

use App\Models\Booking;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use App\Filament\Resources\BookingsResource\Pages;

class BookingsResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationLabel = 'Bookings';

    protected static ?string $modelLabel = 'Booking';

    protected static ?string $pluralModelLabel = 'Bookings';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([]);
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}