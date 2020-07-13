<?php

namespace Tests;

use Helldar\LaravelLangPublisher\Contracts\Localizationable;
use Helldar\LaravelLangPublisher\ServiceProvider;
use Helldar\LaravelLangPublisher\Services\Localization;
use Helldar\LaravelLangPublisher\Traits\Containable;
use Helldar\LaravelLangPublisher\Traits\Containers\Pathable;
use Helldar\LaravelLangPublisher\Traits\Containers\Processable;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use Containable;
    use Processable;
    use Pathable;

    /** @var \Helldar\LaravelLangPublisher\Contracts\Pathable */
    protected $path;

    protected $default_locale = 'en';

    protected $is_json = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->path = $this->getPath();

        $this->resetDefaultLang();
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app): void
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('app.locale', $this->default_locale);
        $config->set('lang-publisher.vendor', realpath(__DIR__ . '/../vendor/caouecs/laravel-lang'));

        $config->set('lang-publisher.exclude', [
            'auth' => ['failed'],
            'All rights reserved.',
        ]);
    }

    protected function resetDefaultLang(): void
    {
        File::deleteDirectory(resource_path('lang'));
        File::makeDirectory(resource_path('lang'));

        $source = $this->path->source($this->default_locale);
        $target = $this->path->target($this->default_locale);

        $this->wantsJson()
            ? File::copy($source, $target)
            : File::copyDirectory($source, $target);
    }

    protected function copyFixtures(): void
    {
        if ($this->wantsJson()) {
            File::copy(
                realpath(__DIR__ . '/fixtures/en.json'),
                $this->path->target($this->default_locale)
            );

            return;
        }

        File::copy(
            realpath(__DIR__ . '/fixtures/auth.php'),
            $this->path->target($this->default_locale, 'auth.php')
        );
    }

    protected function deleteLocales(array $locales): void
    {
        foreach ($locales as $locale) {
            $target = $this->path->target($locale);

            $this->wantsJson()
                ? File::delete($target)
                : File::deleteDirectory($target);
        }
    }

    protected function localization(): Localizationable
    {
        return $this->container(Localization::class);
    }

    protected function wantsJson(): bool
    {
        return $this->is_json;
    }
}
