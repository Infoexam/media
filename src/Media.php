<?php

namespace Infoexam\Media;

use Illuminate\Http\UploadedFile;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media as BaseMedia;

trait Media
{
    use HasMediaTrait;

    /**
     * Register the conversions that should be performed.
     *
     * @param BaseMedia|null $media
     *
     * @return void
     *
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(BaseMedia $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->nonQueued();
    }

    /**
     * Upload medias to server.
     *
     * @param array|UploadedFile $files
     * @param string $collection
     *
     * @return static
     *
     * @throws FileCannotBeAdded
     */
    public function uploadMedias($files, $collection = 'default')
    {
        $files = $files instanceof UploadedFile ? [$files] : $files;

        /** @var UploadedFile $file */

        foreach ($files as $file) {
            $filename = sprintf(
                'origin.%s',
                $file->guessExtension()
            );

            $media[] = $this->addMedia($file)
                ->setFileName($filename)
                ->toMediaCollection($collection);
        }

        return $this;
    }
}
