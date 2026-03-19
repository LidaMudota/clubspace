<?php
namespace App\Filament\Resources;
use App\Models\RefundRequest;
use Filament\Resources\Resource;
class RefundRequestsResource extends Resource { protected static ?string $model = RefundRequest::class; protected static ?string $navigationIcon = 'heroicon-o-arrow-uturn-left'; public static function getPages(): array { return []; } }
