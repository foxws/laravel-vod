<?php

namespace Foxws\Vod\Http\Controllers;

use Foxws\Vod\Streamers\Streamer;
use Foxws\Vod\Vod;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class VodStreamController
{
    public function __invoke(Request $request, string $streamer): RedirectResponse
    {
        return redirect(
            $this->runStreamer($request, $streamer)
        );

    }

    protected function runStreamer(Request $request, string $streamer): string
    {
        return app(Vod::class)
            ->registeredStreamers()
            ->firstOrFail(fn (Streamer $item) => $item->getName() === $streamer)
            ->getUrl(
                parameters: $request->route()->parameters(),
            );
    }
}
