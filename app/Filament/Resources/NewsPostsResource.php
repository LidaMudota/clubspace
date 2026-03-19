<?php
namespace App\Filament\Resources;
use App\Models\NewsPost;
use Filament\Resources\Resource;
class NewsPostsResource extends Resource { protected static ?string $model = NewsPost::class; protected static ?string $navigationIcon = 'heroicon-o-newspaper'; public static function getPages(): array { return []; } }
