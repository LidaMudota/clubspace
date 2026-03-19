<?php

namespace App\Policies;

use App\Models\RefundRequest;
use App\Models\User;

class RefundRequestPolicy
{
    public function viewAny(User $user): bool { return $user->can('manage refunds'); }
    public function view(User $user, RefundRequest $refundRequest): bool { return $user->id === $refundRequest->user_id || $user->can('manage refunds'); }
    public function create(User $user): bool { return $user !== null; }
}
