<?php

namespace Tests\Feature;

use App\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkStatsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function link_stats_can_be_shown_by_shortened_code()
    {
        $link = factory(Link::class)->create([
            'requested_count' => 5,
            'used_count' => 234
        ]);

        $this->json('GET', '/stats', [
            'code' => $link->code
        ])
        ->assertJsonFragment($this->expectedJson($link));
    }

    /** @test */
    public function link_stats_fails_if_not_found()
    {
        $this->json('GET', '/stats', ['code' => 'abc'])
            ->assertStatus(404);
    }

    protected function expectedJson(Link $link)
    {
        return [
            'original_url' => $link->original_url,
            'shortened_url' => $link->shortenedUrl(),
            'code' => $link->code,
            'requested_count' => $link->requested_count,
            'used_count' => $link->used_count,
            'last_requested' => $link->last_requested,
            'last_used' => $link->last_used ? $link->last_used : null,
        ];
    }
}
