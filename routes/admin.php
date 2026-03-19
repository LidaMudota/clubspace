<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->prefix('admin')->group(function (): void {
    // Filament panel routes are registered by provider.
});
