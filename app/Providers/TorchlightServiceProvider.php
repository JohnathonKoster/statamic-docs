<?php

namespace App\Providers;

use App\Torchlight\HighlighterCache;
use Illuminate\Support\ServiceProvider;
use Statamic\Facades\Markdown;
use Torchlight\Engine\CommonMark\Extension;
use Torchlight\Engine\Options;

class TorchlightServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Options::setDefaultOptionsBuilder(fn () => Options::fromArray(config('torchlight.options', [])));

        $extension = new Extension(config('torchlight.theme'));

        $extension->renderer()
            ->setDefaultGrammar(config('torchlight.options.defaultLanguage', 'txt'))
            ->setBlockCache(new HighlighterCache);

        Markdown::addExtension(fn () => $extension);
    }
}
