<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function testAConfirmationEmailIsSentUponRegistration()
    {
        Mail::fake();

        event(new Registered(create('App\User')));

        Mail::assertQueued(VerificationEmail::class);
    }

    public function testUserCanVerifyTheirEmailAddress()
    {
        Mail::fake();

        $this->post(route('register'), [
            'name' => 'John Doe',
            'username' => 'JDoe',
            'email' => 'john@example.com',
            'password' => 'johndoe',
            'password_confirmation' => 'johndoe'
        ]);

        $user = User::whereName('John Doe')->first();

        $this->assertFalse($user->verified);
        $this->assertNotNull($user->verification_token);

        $this->get(route('register.verify', ['token' => $user->verification_token]))
            ->assertRedirect(route('threads.index'));

        tap($user->fresh(), function ($user) {
            $this->assertTrue($user->verified);
            $this->assertNull($user->verification_token);
        });
    }

    public function testVerificationFailsWithAnInvalidToken()
    {
        $this->get(route('register.verify', ['token' => 'nonsensical']))
            ->assertRedirect(route('threads.index'))
            ->assertSessionHas('flash', 'Verification failed due to an invalid token.');
    }
}
