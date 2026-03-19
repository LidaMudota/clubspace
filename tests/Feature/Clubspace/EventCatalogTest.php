<?php

use App\Models\Event;

it('shows event catalog', function () {
    Event::factory()->create(['status' => 'published']);

    $this->get('/events')->assertOk();
});
