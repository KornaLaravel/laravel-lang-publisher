<?php

namespace Helldar\LaravelLangPublisher\Support;

use Helldar\Support\Facades\Helpers\Arr as ArrHelper;
use Illuminate\Contracts\Support\Arrayable;

class ArrayProcessor implements Arrayable
{
    protected $items = [];

    protected $keys_as_string = false;

    public function keysAsString(): self
    {
        $this->keys_as_string = true;

        return $this;
    }

    public function of(array $items): self
    {
        $this->items = $this->stringingKeys($items);

        return $this;
    }

    public function push($value): self
    {
        array_push($this->items, $value);

        return $this;
    }

    public function merge(array $array): self
    {
        $array = $this->stringingKeys($array);

        foreach ($array as $key => $value) {
            $this->items[$key] = $value;
        }

        return $this;
    }

    public function unique(): self
    {
        $this->items = array_unique($this->items);

        return $this;
    }

    public function values(): self
    {
        $this->items = array_values($this->items);

        return $this;
    }

    public function sort(): self
    {
        $this->items = ArrHelper::sort($this->items);

        return $this;
    }

    public function toArray(): array
    {
        return $this->items;
    }

    protected function stringingKeys(array $array): array
    {
        if (! $this->keys_as_string) {
            return $array;
        }

        return ArrHelper::renameKeys($array, static function ($key) {
            return (string) $key;
        });
    }
}
