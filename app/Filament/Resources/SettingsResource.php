<?php
namespace App\Filament\Resources;
use App\Models\Setting;
use Filament\Resources\Resource;
class SettingsResource extends Resource { protected static ?string $model = Setting::class; protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth'; public static function getPages(): array { return []; } }
