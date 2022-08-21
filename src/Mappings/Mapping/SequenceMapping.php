<?php

namespace Foxws\Vod\Mappings\Mapping;

use Foxws\Vod\Mappings\Mapping;

class SequenceMapping extends Mapping
{
    protected array $attributes = [];

    /** @var callable|null */
    protected $callableAttributes;

    public function id(string $id): self
    {
        $this->attributes(['id' => $id]);

        return $this;
    }

    public function label(string $label): self
    {
        $this->attributes(['label' => $label]);

        return $this;
    }

    public function language(string $language): self
    {
        $this->attributes(['language' => $language]);

        return $this;
    }

    public function clips(array $clips): self
    {
        $this->attributes(['clips' => $clips]);

        return $this;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}
