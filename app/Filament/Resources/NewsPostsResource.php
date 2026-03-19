<?php

namespace App\Filament\Resources;

use App\Models\News;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class NewsPostsResource extends Resource
{
    protected static ?string $model = News::class;

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
        return [];
    }
}
