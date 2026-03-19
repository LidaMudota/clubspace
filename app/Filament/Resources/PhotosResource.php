<?php
namespace App\Filament\Resources;
use App\Models\Photo;
use Filament\Resources\Resource;
class PhotosResource extends Resource { protected static ?string $model = Photo::class; protected static ?string $navigationIcon = 'heroicon-o-camera'; public static function getPages(): array { return []; } }
