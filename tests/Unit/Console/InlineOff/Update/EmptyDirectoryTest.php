<?php

/**
 * This file is part of the "laravel-lang/publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2025 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace Tests\Unit\Console\InlineOff\Update;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use LaravelLang\LocaleList\Locale;
use Tests\Unit\Console\InlineOff\TestCase;

class EmptyDirectoryTest extends TestCase
{
    protected Locale $locale = Locale::German;

    protected Locale $fallbackLocale = Locale::English;

    public function testFiles(): void
    {
        $this->forceDeleteLocale(Locale::French);

        $this->assertFileDoesNotExist($this->config->langPath('fr.json'));
        $this->assertFileDoesNotExist($this->config->langPath('fr/auth.php'));
        $this->assertFileDoesNotExist($this->config->langPath('fr/pagination.php'));
        $this->assertFileDoesNotExist($this->config->langPath('fr/validation.php'));
        $this->assertFileDoesNotExist($this->config->langPath('vendor/baq/fr.json'));

        Directory::ensureDirectory($this->config->langPath('fr'));

        $this->assertDirectoryExists($this->config->langPath('fr'));

        $this->assertSame([], File::names($this->config->langPath('fr'), recursive: true));

        $this->artisanLangUpdate();

        $this->assertFileExists($this->config->langPath('fr.json'));
        $this->assertFileExists($this->config->langPath('fr/validation.php'));
        $this->assertFileExists($this->config->langPath('vendor/baq/fr.json'));
    }

    public function testTranslations(): void
    {
        $this->forceDeleteLocale(Locale::English);
        $this->forceDeleteLocale(Locale::French);
        $this->forceDeleteLocale(Locale::German);

        Directory::ensureDirectory($this->config->langPath(Locale::German));

        $this->assertSame('All rights reserved.', $this->trans('All rights reserved.'));
        $this->assertSame('Forbidden', $this->trans('Forbidden'));
        $this->assertSame('Go to page :page', $this->trans('Go to page :page'));
        $this->assertSame('Hello!', $this->trans('Hello!'));

        $this->assertSame('auth.failed', $this->trans('auth.failed'));
        $this->assertSame('auth.password', $this->trans('auth.password'));
        $this->assertSame('auth.throttle', $this->trans('auth.throttle'));

        $this->assertSame('pagination.next', $this->trans('pagination.next'));
        $this->assertSame('pagination.previous', $this->trans('pagination.previous'));

        $this->assertSame('validation.accepted', $this->trans('validation.accepted'));
        $this->assertSame('validation.accepted_if', $this->trans('validation.accepted_if'));
        $this->assertSame('validation.active_url', $this->trans('validation.active_url'));
        $this->assertSame('validation.between.array', $this->trans('validation.between.array'));
        $this->assertSame('validation.between.file', $this->trans('validation.between.file'));
        $this->assertSame('validation.attributes.first_name', $this->trans('validation.attributes.first_name'));
        $this->assertSame('validation.attributes.last_name', $this->trans('validation.attributes.last_name'));
        $this->assertSame('validation.attributes.age', $this->trans('validation.attributes.age'));

        $this->assertSame(
            'validation.custom.first_name.required',
            $this->trans('validation.custom.first_name.required')
        );

        $this->assertSame('validation.custom.first_name.string', $this->trans('validation.custom.first_name.string'));

        $this->artisanLangUpdate();

        $this->assertSame('Alle Rechte vorbehalten.', $this->trans('All rights reserved.'));
        $this->assertSame('Forbidden', $this->trans('Forbidden'));
        $this->assertSame('Go to page :page', $this->trans('Go to page :page'));
        $this->assertSame('Hello!', $this->trans('Hello!'));

        $this->assertSame('auth.failed', $this->trans('auth.failed'));
        $this->assertSame('auth.password', $this->trans('auth.password'));
        $this->assertSame('auth.throttle', $this->trans('auth.throttle'));

        $this->assertSame('pagination.next', $this->trans('pagination.next'));
        $this->assertSame('pagination.previous', $this->trans('pagination.previous'));

        $this->assertSame(':Attribute muss akzeptiert werden.', $this->trans('validation.accepted'));
        $this->assertSame('validation.accepted_if', $this->trans('validation.accepted_if'));
        $this->assertSame('validation.active_url', $this->trans('validation.active_url'));

        $this->assertSame(
            ':Attribute muss zwischen :min & :max Elemente haben.',
            $this->trans('validation.between.array')
        );

        $this->assertSame(
            ':Attribute muss zwischen :min & :max Kilobytes groß sein.',
            $this->trans('validation.between.file')
        );

        $this->assertSame('Vorname', $this->trans('validation.attributes.first_name'));
        $this->assertSame('validation.attributes.last_name', $this->trans('validation.attributes.last_name'));
        $this->assertSame('validation.attributes.age', $this->trans('validation.attributes.age'));

        $this->assertSame(
            'Dieses Vorname muss ausgefüllt werden.',
            $this->trans('validation.custom.first_name.required')
        );

        $this->assertSame('validation.custom.first_name.string', $this->trans('validation.custom.first_name.string'));
    }
}
