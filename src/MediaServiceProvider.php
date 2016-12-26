<?php

namespace Infoexam\Media;

use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;

class MediaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(MediaLibraryServiceProvider::class);
    }
}
