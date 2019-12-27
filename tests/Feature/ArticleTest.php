<?php

namespace Tests\Feature;

use App\User;
use App\Article;
use Tests\TestCase;
use Tests\ForeignKeys;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;
    use ForeignKeys;
    
    /**
     * Create then show article.
     *
     * @return void
     */
    public function test_it_should_show_an_article()
    {
        $article = factory(Article::class)->create();
        $response = $this->get("/articles/$article->id");

        $response->assertSeeText($article->body);
    }

    /**
     * Create then show all articles.
     *
     * @return void
     */
    public function test_it_should_show_all_articles_if_not_logged()
    {
        $articles = factory(Article::class, 3)->create();
        $response = $this->get("/");

        $response->assertSeeTextinOrder([
            $articles[0]->title,
            $articles[1]->title,
            $articles[2]->title
        ]);
    }

    /**
     * Create then show all articles.
     *
     * @return void
     */
    public function test_it_should_show_some_articles_if_logged()
    {
        $articles = factory(Article::class, 3)->create();
        $articles[0]->tag('Gardening');
        $articles[2]->tag('Gardening');
        $articles[0]->save();
        $articles[2]->save();

        $user = factory(User::class)->create();
        $user->tag('Gardening');
        $this->ActingAs($user);
        $response = $this->get("/");
        $response->assertDontSeeText($articles[1]->title);
    }

    /**
     * Create then delete an article
     *
     * @return void
     */
    public function test_it_should_delete_an_article()
    {
        $article = factory(Article::class)->create();

        $this->ActingAs($article->user);
        $response = $this->delete("/articles/$article->id/delete");
        $this->assertDeleted($article);
    }

    /**
     * Create then delete an article
     *
     * @return void
     */
    public function test_it_should_not_delete_an_article()
    {
        $no_delete = factory(Article::class)->create();
        $article = factory(Article::class)->create();

        $this->ActingAs($article->user);
        $response = $this->delete("/articles/$no_delete->id/delete");
        $response->assertSessionMissing('success-message');
        
    }

    /**
     * Create then delete an article
     *
     * @return void
     */
    public function test_it_should_not_like_an_article()
    {
        $article = factory(Article::class)->create();

        $this->ActingAs($article->user);
        $this->patch("/articles/$article->id/like");
        $this->assertDatabaseMissing('votes', [
            'user_id' => $article->user->id,
            'article_id' => $article->id
        ]);
        
    }

    /**
     * Create then delete an article
     *
     * @return void
     */
    public function test_it_should_like_an_article()
    {
        $other_user = factory(User::class)->create();
        $article = factory(Article::class)->create();

        $this->ActingAs($other_user);
        $this->patch("/articles/$article->id/like");
        $this->assertDatabaseHas('votes', [
            'user_id' => $other_user->id,
            'article_id' => $article->id
        ]);
        
    }

    /**
     * Create then delete an article
     *
     * @return void
     */
    public function test_it_should_dislike_an_article()
    {
        $other_user = factory(User::class)->create();
        $article = factory(Article::class)->create();

        $this->ActingAs($other_user);
        $this->patch("/articles/$article->id/dislike");
        $this->assertDatabaseHas('votes', [
            'user_id' => $other_user->id,
            'article_id' => $article->id
        ]);
        
    }

    /**
     * Create then delete an article
     *
     * @return void
     */
    public function test_it_should_not_dislike_an_article()
    {
        $article = factory(Article::class)->create();

        $this->ActingAs($article->user);
        $this->patch("/articles/$article->id/dislike");
        $this->assertDatabaseMissing('votes', [
            'user_id' => $article->user->id,
            'article_id' => $article->id
        ]);
        
    }

    /**
     * Create then delete an article
     *
     * @return void
     */
    public function test_it_should_like_then_dislike_an_article()
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->create();

        $this->ActingAs($user);
        $this->patch("/articles/$article->id/like");
        $this->patch("/articles/$article->id/dislike");
        $this->assertDatabaseHas('votes', [
            'user_id' => $user->id,
            'article_id' => $article->id,
        ]);
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'votes_against' => 1
        ]);
    }

    /**
     * Create then delete an article
     *
     * @return void
     */
    public function test_it_should_dislike_then_like_an_article()
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->create();

        $this->ActingAs($user);
        $this->patch("/articles/$article->id/dislike");
        $this->patch("/articles/$article->id/like");
        $this->assertDatabaseHas('votes', [
            'user_id' => $user->id,
            'article_id' => $article->id,
        ]);
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'votes_for' => 1
        ]);
    }

    /**
     * Create then delete an article
     *
     * @return void
     */
    public function test_it_should_report_an_article()
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->create();

        $this->ActingAs($user);
        $this->post("/articles/$article->id/report");
        $this->assertDatabaseHas('reports', [
            'user_id' => $user->id,
            'article_id' => $article->id,
        ]);
    }

    /**
     * Create then delete an article
     *
     * @return void
     */
    public function test_it_should_not_report_an_article()
    {
        $article = factory(Article::class)->create();

        $this->ActingAs($article->user);
        $this->post("/articles/$article->id/report");
        $this->assertDatabaseMissing('reports', [
            'user_id' => $article->user->id,
            'article_id' => $article->id,
        ]);
    }

    /**
     * Create then delete an article
     *
     * @return void
     */
    public function test_it_should_change_report_an_article()
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->create();

        $this->ActingAs($user);
        $this->post("/articles/$article->id/report");
        $this->post("/articles/$article->id/report");

        $this->assertDatabaseHas('reports', [
            'user_id' => $user->id,
            'article_id' => $article->id,
        ]);
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'reports' => 1
        ]);
    }
}
