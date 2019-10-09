<?php

namespace Tests\Feature;

use App\Link;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function requested_link_details_are_returned()
    {
        $link = factory(Link::class)->create();

        $response = $this->json('GET', '/short', [
            'code' => $link->code,
        ])
            ->assertJsonFragment([
                'original_url'  => $link->original_url,
                'shortened_url' => $link->shortenedUrl(),
                'code'          => $link->code,
            ])
            ->assertStatus(200);
    }

    /** @test */
    public function throws_404_if_no_link_found()
    {
        $response = $this->json('GET', '/short', ['code' => 'abc']);

        $response->assertStatus(404);
        //        $this->assertEmpty($this->response->getContent());
        $this->assertEmpty($response->getContent());
    }

    /** @test */
    public function used_count_is_incremented()
    {
        $link = factory(Link::class)->create();

        $this->json('GET', '/short', ['code' => $link->code]);
        $this->json('GET', '/short', ['code' => $link->code]);
        $this->json('GET', '/short', ['code' => $link->code]);

        $this->assertDatabaseHas('links', [
            'original_url' => $link->original_url,
            'used_count'   => 3,
        ]);
    }

    /** @test */
    public function last_used_date_is_updated()
    {
        Link::flushEventListeners();

        $link = factory(Link::class)->create([
            'last_used' => Carbon::now()->subDays(2),
        ]);

        $this->json('GET', '/short', ['code' => $link->code]);
        $this->assertDatabaseHas('links', [
            'original_url' => $link->original_url,
            'last_used'    => Carbon::now(),
        ]);
    }
}
