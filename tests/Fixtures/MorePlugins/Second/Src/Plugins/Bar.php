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

namespace Tests\Fixtures\MorePlugins\Second\Src\Plugins;

use LaravelLang\Publisher\Plugins\Plugin;

class Bar extends Plugin
{
    public function files(): array
    {
        return [];
    }
}
