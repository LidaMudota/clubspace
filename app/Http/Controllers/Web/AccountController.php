<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class AccountController extends Controller
{
    public function profile(): Response { return Inertia::render('Account/Profile'); }
    public function events(): Response { return Inertia::render('Account/Events'); }
    public function payments(): Response { return Inertia::render('Account/Payments'); }
    public function refunds(): Response { return Inertia::render('Account/Refunds'); }
}
