<?php
namespace App\Filament\Resources;
use App\Models\PhotoAlbum;
use Filament\Resources\Resource;
class PhotoAlbumsResource extends Resource { protected static ?string $model = PhotoAlbum::class; protected static ?string $navigationIcon = 'heroicon-o-photo'; public static function getPages(): array { return []; } }
