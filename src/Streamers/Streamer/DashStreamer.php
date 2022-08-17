<?php

namespace Foxws\Vod\Streamers\Streamer;

use Foxws\Vod\Streamers\Streamer;

class DashStreamer extends Streamer
{
    public function getUrl(string $name, array $parameters = []): string
    {
        $hash = $this->getMappingUrl($name, $parameters, 'manifest.mpd');

        $hashPath = $this->getEncryptedPath($hash);
        $hashPath = $this->getEncodedPath($hashPath);

        return sprintf('%s/%s/%s', config('vod.url'), 'dash', $hashPath);
    }
}
