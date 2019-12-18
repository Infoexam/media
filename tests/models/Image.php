<?php

use Illuminate\Database\Eloquent\Model;
use Infoexam\Media\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Image extends Model implements HasMedia
{
    use Media;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'testing';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
