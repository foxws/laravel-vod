<?php

namespace Foxws\Vod;

use Foxws\Vod\Streamers\Streamer;
use Illuminate\Support\Collection;

class Vod
{
    /** @var array<int, Streamer> */
    protected array $streamers = [];

    /** @param  array<int, Streamer>  $streamers */
    public function streamers(array $streamers): self
    {
        $this->streamers = array_merge($this->streamers, $streamers);

        return $this;
    }

    public function clearStreamers(): self
    {
        $this->streamers = [];

        return $this;
    }

    /** @return Collection<int, Streamer> */
    public function registeredStreamers(): Collection
    {
        return collect($this->streamers);
    }
}
