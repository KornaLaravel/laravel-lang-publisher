<?php

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Resources;

use Helldar\Contracts\LangPublisher\Translation as Resource;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Arr;

class Translation implements Resource
{
    use Makeable;

    protected $keys = [];

    protected $translations = [];

    public function getKeys(): array
    {
        return $this->keys;
    }

    public function keys(string $target, array $keys): Resource
    {
        $values = $this->keys[$target] ?? [];

        $this->keys[$target] = $this->merge($values, $keys);

        return $this;
    }

    public function translation(string $locale, string $target, array $translations): Resource
    {
        $values = $this->translations[$target][$locale] ?? [];

        $this->translations[$target][$locale] = $this->merge($values, $translations);

        return $this;
    }

    public function getTranslations(): array
    {
        return $this->translations;
    }

    protected function merge(array ...$arrays): array
    {
        return Arr::merge(...$arrays);
    }
}
