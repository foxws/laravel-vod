<?php

namespace Foxws\Vod\Streamers;

use Illuminate\Support\Str;

abstract class Streamer
{
    protected ?string $name = null;

    protected ?string $label = null;

    protected ?string $route = null;

    final public function __construct()
    {
    }

    public static function new(): static
    {
        $instance = new static();

        return $instance;
    }

    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function label(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function route(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getLabel(): string
    {
        if ($this->label) {
            return $this->label;
        }

        $name = $this->getName();

        return Str::of($name)->snake()->replace('_', ' ')->title();
    }

    public function getName(): string
    {
        if ($this->name) {
            return $this->name;
        }

        return class_basename(static::class);
    }

    public function getRoute(): string
    {
        if ($this->route) {
            return $this->route;
        }

        return '';
    }

    abstract public function getUrl(array $parameters): string;

    protected function getMappingUrl(array $parameters = [], string $uri): string
    {
        $route = trim(route($this->route, $parameters, false), '/');

        $path = sprintf('%s/%s', $route, $uri);

        $hash = substr(
            md5($path, true),
            0,
            $this->getTokenHashSize()
        );

        // Add hash prefix
        $path = $hash.$path;

        // Add PKCS#7 padding
        $pad = 16 - (strlen($path) % 16);

        return $path.str_repeat(chr($pad), $pad);
    }

    protected function getEncryptedPath(string $path): string
    {
        return openssl_encrypt(
            $path,
            'aes-256-cbc',
            $this->getTokenKey(),
            OPENSSL_RAW_DATA | OPENSSL_NO_PADDING,
            $this->getTokenIv()
        );
    }

    protected function getEncodedPath(string $path): string
    {
        return rtrim(strtr(base64_encode($path), '+/', '-_'), '=');
    }

    protected function getTokenKey(): string
    {
        return pack('H*', config('vod.key'));
    }

    protected function getTokenIv(): string
    {
        return pack('H*', config('vod.iv'));
    }

    protected function getTokenHashSize(): int
    {
        return config('vod.hash_size', 8);
    }
}
