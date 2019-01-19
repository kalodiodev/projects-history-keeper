<?php

namespace Tests\Feature;

use App\Tag;
use App\Snippet;
use Tests\IntegrationTestCase;

class SnippetIndexTest extends IntegrationTestCase
{
    /** @test */
    public function a_user_can_view_own_snippets_index()
    {
        $user = $this->signInDefault();

        // signed in user's snippets
        create(Snippet::class, ['user_id' => $user->id], 2);

        // other users snippets
        create(Snippet::class, [], 2);

        $response = $this->get(route('snippet.index'))
            ->assertStatus(200)
            ->assertViewIs('snippet.index')
            ->assertViewHas('snippets');

        $snippets = $response->original->getData()['snippets'];
        $this->assertEquals(2, $snippets->count());
    }

    /** @test */
    public function an_authorized_user_can_view_all_snippets_index()
    {
        $user = $this->signInAdmin();

        // signed in user's snippets
        create(Snippet::class, ['user_id' => $user->id], 2);

        // other users snippets
        create(Snippet::class, [], 2);

        $response = $this->get(route('snippet.index'))
            ->assertStatus(200)
            ->assertViewIs('snippet.index')
            ->assertViewHas(['snippets']);

        $snippets = $response->original->getData()['snippets'];
        $this->assertEquals(4, $snippets->count());
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_snippets()
    {
        $this->signInRestricted();

        $this->get(route('snippet.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_snippets_index()
    {
        $this->get(route('snippet.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_admin_can_index_all_snippets_by_tag()
    {
        $this->signInAdmin();

        $firstTag = create(Tag::class);
        $secondTag = create(Tag::class);

        $this->createSnippetsOfTag($firstTag, 4);
        $this->createSnippetsOfTag($secondTag, 3);

        $responses = $this->get(route('snippet.index', ['tag' => $firstTag->name]))
            ->assertStatus(200);

        $snippets = $responses->original->getData()['snippets'];
        $this->assertEquals(4, $snippets->count());
    }

    /** @test */
    public function a_default_user_can_index_only_their_snippets_by_tag()
    {
        $user = $this->signInDefault();

        $firstTag = create(Tag::class);
        $secondTag = create(Tag::class);

        $this->createSnippetsOfTag($firstTag, 2);
        $this->createSnippetsOfTag($secondTag, 3);

        // User's snippets
        $this->createSnippetsOfTag($firstTag, 1, ['user_id' => $user->id]);
        $this->createSnippetsOfTag($secondTag, 1, ['user_id' => $user->id]);

        $responses = $this->get(route('snippet.index', ['tag' => $firstTag->name]))
            ->assertStatus(200);

        $snippets = $responses->original->getData()['snippets'];
        $this->assertEquals(1, $snippets->count());
    }

    /** @test */
    public function an_admin_can_search_snippets()
    {
        $this->signInAdmin();

        $snippet1 = create(Snippet::class, ['title' => 'first snippet']);
        $snippet2 = create(Snippet::class, ['title' => 'second snippet']);

        $this->get(route('snippet.index', ['search' => $snippet1->title]))
            ->assertStatus(200)
            ->assertSee($snippet1->title)
            ->assertDontSee($snippet2->title);
    }

    /** @test */
    public function a_default_user_can_search_their_snippets()
    {
        $user = $this->signInDefault();

        create(Snippet::class, ['title' => 'first', 'user_id' => $user->id]);
        create(Snippet::class, ['title' => 'second', 'user_id' => $user->id]);
        create(Snippet::class, ['title' => 'first']);

        $response = $this->get(route('snippet.index', ['search' => 'first']))
            ->assertStatus(200);

        $snippets = $response->original->getData()['snippets'];
        $this->assertEquals(1, $snippets->count());
    }

    /**
     * Create Snippets with given tag
     *
     * @param $tag
     * @param $snippetsNumber
     * @param array $overrides
     * @return mixed
     */
    private function createSnippetsOfTag($tag, $snippetsNumber, $overrides = [])
    {
        $snippets = create(Snippet::class, $overrides, $snippetsNumber);
        foreach ($snippets as $snippet) {
            $snippet->tags()->attach($tag);
        }

        return $snippets;
    }
}
