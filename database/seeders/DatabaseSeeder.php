<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Role;
use App\Models\UserRole;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Post::factory(10)->create();
        Comment::factory(20)->create();

        Role::create([
            'name' => 'see-post'
        ]);
        Role::create([
            'name' => 'post-manipulation'
        ]);

        UserRole::create([
            'user_id' => 1,
            'role_id' => 1
        ]);
        UserRole::create([
            'user_id' => 1,
            'role_id' => 2
        ]);
        UserRole::create([
            'user_id' => 2,
            'role_id' => 1
        ]);
        UserRole::create([
            'user_id' => 3,
            'role_id' => 2
        ]);
    }
}
