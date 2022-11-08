<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use PHPUnit\Framework\TestCase;
//use Tests\Unit\factory;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    use RefreshDatabase;
    /** @test */
    public function test_success_full_login()
    {
    
        $user = User::create(
            [
                'name' => 'Gabriel Teixeira',
                'email' => 'sample@test.com',
                'password' => '123456'
            ]
        );
        
        dd($user);

        //$this->assertTrue(true);
    }
}
