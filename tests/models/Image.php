<?php

use Illuminate\Database\Eloquent\Model;
use Infoexam\Media\Media;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Image extends Model implements HasMediaConversions
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
