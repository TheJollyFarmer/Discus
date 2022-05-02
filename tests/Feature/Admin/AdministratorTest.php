<?php
namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdministratorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAdministratorCanAccessTheAdministrationSection()
    {
        $this->withExceptionHandling()
             ->signInAdmin()
             ->get(route('admin.index'))
             ->assertStatus(Response::HTTP_OK);
    }
    /** @test */
    public function aNonAdministratorCannotAccessTheAdministrationSection()
    {
        $this->withExceptionHandling()
             ->actingAs(create(User::class))
             ->get(route('admin.index'))
             ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
