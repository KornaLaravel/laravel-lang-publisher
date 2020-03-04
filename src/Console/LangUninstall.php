<?php

namespace Helldar\LaravelLangPublisher\Console;

use function compact;
use Illuminate\Support\Facades\File;
use function resource_path;

class LangUninstall extends BaseCommand
{
    protected $signature = 'lang:uninstall {locales* : Localizations to uninstall}';

    protected $description = 'Uninstall localizations.';

    protected $result = [];

    public function handle()
    {
        $this->uninstall((array) $this->argument('locales'));
        $this->showResult($this->result, 'No uninstalled localizations.');
    }

    protected function uninstall(array $locales): void
    {
        foreach ($locales as $locale) {
            $result = File::deleteDirectory(
                resource_path('lang' . DIRECTORY_SEPARATOR . $locale)
            );

            $this->pushResult($locale, $result);
        }
    }

    protected function pushResult(string $locale, bool $result)
    {
        $status = $result ? 'uninstalled' : 'error';

        $this->result[] = compact('locale', 'status');
    }
}