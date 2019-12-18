<?php

namespace Infoexam\Media\Generators;

use Hashids\Hashids;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class Path implements PathGenerator
{
    /**
     * Get the path for the given media,
     * relative to the root storage path.
     *
     * @param Media $media
     *
     * @return string
     */
    public function getPath(Media $media): string
    {
        return sprintf(
            '%s/%s/',
            $this->prefix($media),
            $this->identify($media)
        );
    }

    /**
     * Get the path for conversions of the given media,
     * relative to the root storage path.
     *
     * @param Media $media
     *
     * @return string
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media);
    }

    /**
     * Get the path for responsive images of the given media,
     * relative to the root storage path.
     *
     * @param Media $media
     *
     * @return string
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media);
    }

    /**
     * Get the path prefix.
     *
     * @param Media $media
     *
     * @return string
     */
    protected function prefix(Media $media): string
    {
        return substr(
            $media->getAttribute('created_at')->timestamp,
            0,
            4
        );
    }

    /**
     * Get the media identity.
     *
     * @param Media $media
     *
     * @return string
     */
    protected function identify(Media $media): string
    {
        $prefix = substr(
            $media->getAttribute('created_at')->timestamp,
            4
        );

        $encode = $this->hashids()->encode(
            $media->getAttribute('id'),
            $media->getAttribute('model_id')
        );

        return sprintf('%s-%s', $prefix, $encode);
    }

    /**
     * Get hashids instance.
     *
     * @return Hashids
     */
    protected function hashids(): Hashids
    {
        return new Hashids(
            'oCq0NOlyPOL9rZwirXpJqTrX0Bs9DbNF',
            6
        );
    }
}
