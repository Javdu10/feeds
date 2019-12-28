<?php

namespace Tests\Feature;

use App\User;
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

    /**
     * Create a draft
     *
     * @return void
     */
    public function test_it_should_create_a_draft()
    {
        $user = factory(User::class)->create();

        $this->ActingAs($user);
        $this->get("/drafts/create");

        $this->assertDatabaseHas('drafts', [
            'owner_id' => $user->id
        ]);
    }

    /**
     * Create then update a draft
     *
     * @return void
     */
    public function test_it_should_patch_a_draft()
    {
        $draft = factory(Draft::class)->create();
        $user = $draft->user;

        $this->ActingAs($user);
        $this->patch("/drafts/$draft->id", [
            'body' => 'new body'
        ]);

        $this->assertDatabaseHas('drafts', [
            'id' => $draft->id,
            'body' => 'new body'
        ]);
        
    }

    /**
     * Create then publish a draft
     *
     * @return void
     */
    public function test_it_should_publish_a_draft()
    {
        $draft = factory(Draft::class)->create();
        $user = $draft->user;
        $draft->tag('Gardening');
        $this->ActingAs($user);
        $this->post("/drafts/$draft->id/publish");

        $this->assertDatabaseHas('articles', [
            'owner_id' => $user->id,
            'body' => $draft->body
        ]);
        $this->assertDatabaseHas('tagging_tagged', [
            'tag_name' => 'Gardening',
        ]);
        $this->assertDeleted($draft);
    }

    /**
     * Create then publish a draft
     *
     * @return void
     */
    public function test_it_should_not_publish_a_draft()
    {
        $draft = factory(Draft::class)->create([
            'title' => null,
            'heading' => null
        ]);
        $user = $draft->user;

        $this->ActingAs($user);
        $response = $this->post("/drafts/$draft->id/publish");

        $this->assertDatabaseHas('drafts',[
            'id' => $draft->id
        ]);
        $response->assertSessionHas('error-publish', "Il manque soit le titre soit la phrase d'accroche pour publier l'article.");
    }

    /**
     * Create then edit a draft
     *
     * @return void
     */
    public function test_it_should_edit_a_draft()
    {
        $draft = factory(Draft::class)->create();
        $user = $draft->user;

        $this->ActingAs($user);
        $response = $this->get("/drafts/$draft->id/edit");

        $response->assertSeeText($draft->body);
    }

    /**
     * Create then show drafts
     *
     * @return void
     */
    public function test_it_should_show_user_drafts()
    {
        $user = factory(User::class)->create();
        $drafts = factory(Draft::class, 2)->create([
            'owner_id' => $user->id
        ]);

        $this->ActingAs($user);
        $response = $this->get("/drafts");

        $response->assertSeeTextInOrder([
            htmlentities($drafts[0]->title),
            htmlentities($drafts[1]->title)
            
        ]);
    }
    
}
