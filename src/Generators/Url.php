<?php

namespace Infoexam\Media\Generators;

use Spatie\MediaLibrary\UrlGenerator\BaseUrlGenerator;
use Spatie\MediaLibrary\UrlGenerator\UrlGenerator;

class Url extends BaseUrlGenerator implements UrlGenerator
{
    /**
     * Get the path for the given media, relative to the root storage path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getPathRelativeToRoot();
    }

    /**
     * Get the url for the profile of a media item.
     *
     * @return string
     */
    public function getUrl() : string
    {
        return sprintf('%s/%s', $this->prefix(), $this->getPathRelativeToRoot());
    }

    /**
     * Get the url prefix.
     *
     * @return string
     */
    protected function prefix()
    {
        $url = config('laravel-medialibrary.media_url');

        return $url ?: $this->local();
    }

    /**
     * Get image url from local filesystem.
     *
     * @return string
     */
    protected function local()
    {
        $filesystem = config('laravel-medialibrary.defaultFilesystem');

        $root = config("filesystems.disks.{$filesystem}.root");

        return str_replace(public_path(), '', $root);
    }
}
