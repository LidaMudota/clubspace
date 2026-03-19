<?php

it('creates otp successfully', function () {
    $this->post('/auth/otp/send', ['target' => 'member@example.com'])
        ->assertSessionHas('status');

    $this->assertDatabaseCount('otp_codes', 1);
});
