<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function linkResponse(Link $link, $merge = [])
    {
        return response()->json([
            'data' => array_merge([
                'original_url' => $link->original_url,
                'shortened_url' => $link->shortenedUrl(),
                'code' => $link->code,
            ], $merge)
        ], 200);
    }
}
