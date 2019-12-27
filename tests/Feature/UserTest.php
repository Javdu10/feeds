<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Tests\ForeignKeys;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use ForeignKeys;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_should_see_profile()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->get("/users/$user->id");

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_should_not_see_profile()
    {
        $user = factory(User::class)->create();
        $user_not_authoried = factory(User::class)->create();
        $this->actingAs($user_not_authoried);
        $response = $this->get("/users/$user->id");

        $response->assertStatus(403);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_should_edit_profile()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->patch("/users/$user->id", [
            'tags' => 'testTag'
        ]);
        $this->assertDatabaseHas('tagging_tagged', [
            'tag_name' => 'Testtag',
            'taggable_id' => $user->id
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_should_not_edit_profile()
    {
        $user = factory(User::class)->create();
        $user_not_authoried = factory(User::class)->create();
        $this->actingAs($user_not_authoried);
        $response = $this->patch("/users/$user->id", [
            'tags' => 'testTag'
        ]);

        $this->assertDatabaseMissing('tagging_tagged', [
            'tag_name' => 'Testtag',
            'taggable_id' => $user->id
        ]);
    }
}
