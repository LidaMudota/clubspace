<?php
namespace App\Filament\Resources;
use App\Models\NotificationLog;
use Filament\Resources\Resource;
class NotificationLogsResource extends Resource { protected static ?string $model = NotificationLog::class; protected static ?string $navigationIcon = 'heroicon-o-bell-alert'; public static function getPages(): array { return []; } }
