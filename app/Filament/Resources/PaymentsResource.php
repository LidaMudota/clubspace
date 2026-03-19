<?php
namespace App\Filament\Resources;
use App\Models\Payment;
use Filament\Resources\Resource;
class PaymentsResource extends Resource { protected static ?string $model = Payment::class; protected static ?string $navigationIcon = 'heroicon-o-credit-card'; public static function getPages(): array { return []; } }
