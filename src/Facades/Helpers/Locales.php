<?php

/*
 * This file is part of the "andrey-helldar/laravel-lang-publisher" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/laravel-lang-publisher
 */

declare(strict_types=1);

namespace Helldar\LaravelLangPublisher\Facades\Helpers;

use Helldar\LaravelLangPublisher\Helpers\Locales as Helper;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array available()
 * @method static array installed()
 * @method static array protects()
 * @method static bool isAvailable(string $locale)
 * @method static bool isInstalled(string $locale)
 * @method static bool isProtected(string $locale)
 * @method static string getDefault()
 * @method static string getFallback()
 * @method static void validate(string $locale)
 */
class Locales extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}