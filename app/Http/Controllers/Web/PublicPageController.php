<?php

namespace App\Http\Controllers\Web;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Event;
use App\Models\News;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class PublicPageController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Home/Index', [
            'featuredEvents' => Event::query()
                ->where('status', 'published')
                ->where('starts_at', '>=', now())
                ->orderBy('starts_at')
                ->limit(6)
                ->get(),
            'latestNews' => News::query()->where('is_published', true)->latest('published_at')->limit(3)->get(),
            'featuredAlbums' => Album::query()->where('is_published', true)->latest('published_at')->limit(4)->get(),
            'stats' => [
                'events' => Event::query()->where('status', 'published')->count(),
                'members' => \App\Models\User::query()->count(),
                'albums' => Album::query()->where('is_published', true)->count(),
            ],
        ]);
    }

    public function events(Request $request): Response
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:120'],
            'period' => ['nullable', 'in:all,week,month'],
            'sort' => ['nullable', 'in:starts_at,price_asc,price_desc,newest'],
            'price_from' => ['nullable', 'integer', 'min:0'],
            'price_to' => ['nullable', 'integer', 'min:0'],
        ]);

        $sort = $request->string('sort', 'starts_at')->toString();

        $events = Event::query()
            ->where('status', 'published')
            ->where('starts_at', '>=', now()->startOfDay())
            ->when($request->filled('search'), fn (Builder $query) => $query->where('title', 'like', '%'.$request->string('search')->toString().'%'))
            ->when($request->string('period')->toString() === 'week', fn (Builder $query) => $query->whereBetween('starts_at', [now(), now()->addWeek()]))
            ->when($request->string('period')->toString() === 'month', fn (Builder $query) => $query->whereBetween('starts_at', [now(), now()->addMonth()]))
            ->when($request->filled('price_from'), fn (Builder $query) => $query->where('price', '>=', (int) $request->input('price_from')))
            ->when($request->filled('price_to'), fn (Builder $query) => $query->where('price', '<=', (int) $request->input('price_to')))
            ->when($sort === 'price_asc', fn (Builder $query) => $query->orderBy('price'))
            ->when($sort === 'price_desc', fn (Builder $query) => $query->orderByDesc('price'))
            ->when($sort === 'newest', fn (Builder $query) => $query->latest('created_at'))
            ->when($sort === 'starts_at', fn (Builder $query) => $query->orderBy('starts_at'))
            ->paginate(12)
            ->through(function (Event $event) {
                return [
                    ...$event->toArray(),
                    'available_seats' => $event->availableSeats(),
                ];
            })
            ->withQueryString();

        return Inertia::render('Events/Index', [
            'events' => $events,
            'filters' => $request->only(['search', 'period', 'sort', 'price_from', 'price_to']),
        ]);
    }

    public function event(Request $request, string $slug): Response
    {
        $event = Event::query()->where('slug', $slug)->firstOrFail();

        return Inertia::render('Events/Show', [
            'event' => $event,
            'available_seats' => $event->availableSeats(),
            'is_booked' => $request->user()?->bookings()
                ->where('event_id', $event->id)
                ->whereIn('status', [BookingStatus::Draft, BookingStatus::Confirmed])
                ->exists() ?? false,
            'related' => Event::query()
                ->where('status', 'published')
                ->where('id', '!=', $event->id)
                ->orderBy('starts_at')
                ->limit(3)
                ->get(),
        ]);
    }

    public function news(): Response
    {
        return Inertia::render('News/Index', [
            'posts' => News::query()->where('is_published', true)->latest('published_at')->paginate(12),
        ]);
    }

    public function newsShow(string $slug): Response
    {
        $post = News::query()->where('slug', $slug)->firstOrFail();

        return Inertia::render('News/Show', [
            'post' => $post,
            'related' => News::query()
                ->where('is_published', true)
                ->where('id', '!=', $post->id)
                ->latest('published_at')
                ->limit(3)
                ->get(),
        ]);
    }

    public function albums(): Response
    {
        return Inertia::render('Albums/Index', [
            'albums' => Album::query()->where('is_published', true)->latest('published_at')->paginate(12),
        ]);
    }

    public function albumShow(string $slug): Response
    {
        $album = Album::query()->with(['photos' => fn ($query) => $query->orderBy('sort_order')])->where('slug', $slug)->firstOrFail();

        return Inertia::render('Albums/Show', ['album' => $album]);
    }

    public function about(): Response
    {
        return Inertia::render('Community/About', [
            'stats' => [
                'events' => Event::query()->where('status', 'published')->count(),
                'members' => \App\Models\User::query()->count(),
                'news' => News::query()->where('is_published', true)->count(),
            ],
        ]);
    }

    public function contacts(): Response
    {
        return Inertia::render('Contacts/Index', [
            'contacts' => [
                'email' => config('mail.from.address'),
                'telegram' => config('clubspace.telegram.chat_id'),
                'address' => config('app.name').' Community Hub, Москва',
                'working_hours' => 'Ежедневно, 10:00–21:00',
            ],
        ]);
    }

    public function contactFeedback(Request $request)
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        Log::channel('stack')->info('Contact feedback', $payload);

        return back()->with('status', 'Спасибо! Мы свяжемся с вами в ближайшее время.');
    }
}
