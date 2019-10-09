<?php

namespace Tests\Feature;

use App\Link;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkCreationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function fails_if_no_url_given()
    {
        $response = $this->json('POST', '/short')
            ->assertJsonFragment(['url' => ['Please enter a URL to shorten.']])
            ->assertStatus(422);

        $this->assertDatabaseMissing('links', [
            'code' => '1',
        ]);
    }

    /** @test */
    public function fails_if_url_is_invalid()
    {
        $response = $this->json('POST', '/short', [
            'url' => 'http://google^&$$^&*^',
        ])
            ->assertJsonFragment(['url' => ['Hmm, that doesn\'t look like a valid URL.']])
            ->assertStatus(422);

        $this->assertDatabaseMissing('links', [
            'code' => '1',
        ]);
    }

    /** @test */
    public function link_without_scheme_can_be_shortened()
    {
        //                dd($this->json('POST', '/', [
        //                    'url' => 'www.google.com'
        //                ])->getContent());
        $this->json('POST', '/short', [
            'url' => 'www.google.com',
        ])
            ->assertJsonFragment([
                'data' => [
                    'original_url'  => 'http://www.google.com',
//                    'shortened_url' => env('CLIENT_URL') . '/1',
                    'shortened_url' => env('APP_URL') . '/redirect/1',
                    'code'          => '1',
                ],
            ])
            ->assertStatus(200);
        //                        dd(Link::all());

        //        "id" => "1"
        //        "original_url" => "http://www.google.com"
        //        "code" => null
        //        "requested_count" => "1"
        //        "used_count" => "0"
        //        "created_at" => "2019-09-25 18:13:55"
        //        "updated_at" => "2019-09-25 18:13:55"
        //        "last_requested" => "2019-09-25 18:13:55"
        //        "last_used" => null
        $this
            ->assertDatabaseHas('links', [
                'original_url' => 'http://www.google.com',
                'code'         => '1',
            ]);
    }

    /** @test */
    public function link_with_scheme_can_be_shortened()
    {

        $this->json('POST', '/short', [
            'url' => 'http://www.google.com',
        ])
            ->assertJsonFragment([
                'data' => [
                    'original_url'  => 'http://www.google.com',
//                    'shortened_url' => env('CLIENT_URL') . '/1',
                    'shortened_url' => env('APP_URL') . '/redirect/1',
                    'code'          => '1',
                ],
            ])
            ->assertStatus(200);

        $this
            ->assertDatabaseHas('links', [
                'original_url' => 'http://www.google.com',
                'code'         => '1',
            ]);
    }

    /** @test */
    public function link_is_only_shortened_once()
    {
        $url = 'http://www.google.com';

        $this->json('POST', '/short', ['url' => $url]);
        $this->json('POST', '/short', ['url' => $url]);

        $link = Link::where('original_url', $url)->get();

        $this->assertCount(1, $link);
    }

    /** @test */
    public function requested_count_is_incremented()
    {
        $url = 'http://www.google.com';

        $this->json('POST', '/short', ['url' => $url]);
        $this->json('POST', '/short', ['url' => $url]);

        $this->assertDatabaseHas('links', [
            'original_url'    => $url,
            'requested_count' => 2,
        ]);
    }

    /** @test */
    public function last_requested_date_is_updated_for_existing_link()
    {
        Link::flushEventListeners();

        $link = factory(Link::class)->create([
            'last_requested' => Carbon::now()->subDays(2),
        ]);

        $this->json('POST', '/short', ['url' => $link->original_url]);
        $this->assertDatabaseHas('links', [
            'original_url'   => $link->original_url,
            'last_requested' => Carbon::now(),
        ]);
    }
}
