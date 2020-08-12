<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;

class UserTest extends TestCase
{
    public function addUser($name, $email, $password) {
        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->save();
    }

    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function addUsers()
    {
        addUser('Dillon Ching', 'dillon@ching.com', 'asdf');
        addUser('Jane Doe', 'jane@doe.com', 'asdf');
    }
}
