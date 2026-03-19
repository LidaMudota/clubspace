<?php
namespace App\Filament\Resources;
use App\Models\User;
use Filament\Resources\Resource;
class UsersResource extends Resource { protected static ?string $model = User::class; protected static ?string $navigationIcon = 'heroicon-o-users'; public static function getPages(): array { return []; } }
