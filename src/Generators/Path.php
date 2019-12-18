<?php

namespace Infoexam\Media\Generators;

use Hashids\Hashids;
use Spatie\MediaLibrary\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class Path implements PathGenerator
{
    /**
     * Get the path for the given media, relative to the root storage path.
     *
     * @param Media $media
     *
     * @return string
     */
    public function getPath(Media $media): string
    {
        return sprintf('%s/%s/', $this->getPrefix($media), $this->getIdentity($media));
    }

    /**
     * Get the path for conversions of the given media, relative to the root storage path.
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
     * Get the path prefix.
     *
     * @param Media $media
     *
     * @return string
     */
    protected function getPrefix(Media $media)
    {
        return substr($media->getAttribute('created_at')->timestamp, 0, 4);
    }

    /**
     * Get the media identity.
     *
     * @param Media $media
     *
     * @return string
     */
    protected function getIdentity(Media $media)
    {
        $prefix = substr($media->getAttribute('created_at')->timestamp, 4);

        $hashids = new Hashids('oCq0NOlyPOL9rZwirXpJqTrX0Bs9DbNF', 6);

        $encode = $hashids->encode($media->getAttribute('id'), $media->getAttribute('model_id'));

        return sprintf('%s-%s', $prefix, $encode);
    }
}
