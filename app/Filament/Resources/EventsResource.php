<?php
namespace App\Filament\Resources;
use App\Models\Event;
use Filament\Resources\Resource;
class EventsResource extends Resource { protected static ?string $model = Event::class; protected static ?string $navigationIcon = 'heroicon-o-calendar-days'; public static function getPages(): array { return []; } }
