<?php

use Infoexam\Media\Media;

class Image extends Media
{
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
