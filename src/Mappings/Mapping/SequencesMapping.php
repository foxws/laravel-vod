<?php

namespace Foxws\Vod\Mappings\Mapping;

use Foxws\Vod\Mappings\Mapping;

class SequencesMapping extends Mapping
{
    protected array $attributes = [];

    /** @var callable|null */
    protected $callableAttributes;

    public function id(string $id): self
    {
        $this->attributes(['id' => $id]);

        return $this;
    }

    public function sequences(array $sequences): self
    {
        $this->attributes(['sequences' => $sequences]);

        return $this;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}
