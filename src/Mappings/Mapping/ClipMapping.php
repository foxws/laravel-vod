<?php

namespace Foxws\Vod\Mappings\Mapping;

use Foxws\Vod\Mappings\Mapping;

class ClipMapping extends Mapping
{
    protected array $attributes = [];

    /** @var callable|null */
    protected $callableAttributes;

    public function type(string $type): self
    {
        $this->attributes(['type' => $type]);

        return $this;
    }

    public function path(string $path): self
    {
        $this->attributes(['path' => $path]);

        return $this;
    }

    public function toArray(): array
    {
        return [
            $this->attributes
        ];
    }
}
