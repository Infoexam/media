<?php

namespace Infoexam\Media;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class Media extends Model implements HasMediaConversions
{
    use HasMediaTrait;

    /**
     * Register the conversions that should be performed.
     *
     * @param int $width
     *
     * @return void
     */
    public function registerMediaConversions($width = 368) {
        $this->addMediaConversion('thumb')
            ->setManipulations(['w' => $width])
            ->performOnCollections('*')
            ->nonQueued();
    }

    /**
     * Upload medias to server.
     *
     * @param array|UploadedFile $files
     * @param string $collection
     *
     * @return static
     */
    public function uploadMedias($files, $collection = 'default')
    {
        $files = $files instanceof UploadedFile ? [$files] : $files;

        foreach ($files as $file) {
            $filename =  sprintf('origin.%s', $file->guessExtension() ?? 'jpeg');

            $media[] = $this->addMedia($file)
                ->setFileName($filename)
                ->toMediaLibrary($collection);
        }

        return $this;
    }
}
