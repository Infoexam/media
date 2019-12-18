<?php

namespace Infoexam\Media\Generators;

use DateTimeInterface;
use Spatie\MediaLibrary\UrlGenerator\BaseUrlGenerator;

class Url extends BaseUrlGenerator
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
    public function getUrl(): string
    {
        return sprintf(
            '%s/%s',
            $this->prefix(),
            $this->getPathRelativeToRoot()
        );
    }

    /**
     * Get the temporary url for a media item.
     *
     * @param DateTimeInterface $expiration
     * @param array $options
     *
     * @return string
     */
    public function getTemporaryUrl(DateTimeInterface $expiration, array $options = []): string
    {
        return $this->getUrl();
    }

    /**
     * Get the url to the directory containing responsive images.
     *
     * @return string
     */
    public function getResponsiveImagesDirectoryUrl(): string
    {
        return $this->getUrl();
    }

    /**
     * Get the url prefix.
     *
     * @return string
     */
    protected function prefix(): string
    {
        return config('medialibrary.media_url') ?: $this->local();
    }

    /**
     * Get image url from local filesystem.
     *
     * @return string
     */
    protected function local(): string
    {
        $filesystem = config('medialibrary.disk_name');

        $root = config("filesystems.disks.{$filesystem}.root");

        return str_replace(public_path(), '', $root);
    }
}
