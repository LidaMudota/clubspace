<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Event;
use App\Models\News;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PublicPageController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Home/Index', [
            'featuredEvents' => Event::query()->where('status', 'published')->latest('starts_at')->limit(3)->get(),
            'latestNews' => News::query()->where('is_published', true)->latest('published_at')->limit(3)->get(),
        ]);
    }

    public function events(Request $request): Response
    {
        $events = Event::query()->where('status', 'published')
            ->when($request->string('search')->toString(), fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->orderBy($request->string('sort', 'starts_at')->toString())
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('Events/Index', ['events' => $events, 'filters' => $request->only(['search', 'sort'])]);
    }

    public function event(string $slug): Response
    {
        $event = Event::query()->where('slug', $slug)->firstOrFail();
        return Inertia::render('Events/Show', ['event' => $event, 'available_seats' => $event->availableSeats()]);
    }

    public function news(): Response
    {
        return Inertia::render('News/Index', ['posts' => News::query()->where('is_published', true)->latest('published_at')->paginate(12)]);
    }

    public function newsShow(string $slug): Response
    {
        return Inertia::render('News/Show', ['post' => News::query()->where('slug', $slug)->firstOrFail()]);
    }

    public function albums(): Response
    {
        return Inertia::render('Albums/Index', ['albums' => Album::query()->where('is_published', true)->latest('published_at')->paginate(12)]);
    }

    public function albumShow(string $slug): Response
    {
        return Inertia::render('Albums/Show', ['album' => Album::query()->with('photos')->where('slug', $slug)->firstOrFail()]);
    }

    public function about(): Response { return Inertia::render('Community/About'); }
    public function contacts(): Response { return Inertia::render('Contacts/Index'); }
}
