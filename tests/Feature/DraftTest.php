<?php

namespace Tests\Feature;

use App\Draft;
use Tests\TestCase;
use Tests\ForeignKeys;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DraftTest extends TestCase
{
    use RefreshDatabase;
    use ForeignKeys;
    
    /**
     * Create then delete a draft
     *
     * @return void
     */
    public function test_it_should_delete_a_draft()
    {
        $draft = factory(Draft::class)->create();
        $user = $draft->user;

        $this->ActingAs($user);
        $this->delete("/drafts/$draft->id/delete");

        $this->assertDeleted($draft);
    }

}
