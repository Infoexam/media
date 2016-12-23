<?php

class MediaTest extends Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->loadMigrationsFrom([
            '--realpath' => realpath(__DIR__.'/migrations'),
        ]);
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown()
    {
        parent::tearDown();

        $filesystem = new \Illuminate\Filesystem\Filesystem;

        $filesystem->cleanDirectory(__DIR__.'/uploads');
    }

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            Infoexam\Media\MediaServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('filesystems.disks.media', [
            'driver' => 'local',
            'root'   => __DIR__.'/uploads',
        ]);

        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('laravel-medialibrary.custom_url_generator_class', \Infoexam\Media\Generators\Url::class);
        $app['config']->set('laravel-medialibrary.custom_path_generator_class', \Infoexam\Media\Generators\Path::class);
    }

    public function test_media()
    {
        $prefix = __DIR__.'/medias/';

        copy($prefix.'earth.jpeg', $prefix.'test1.jpeg');
        copy($prefix.'earth.jpeg', $prefix.'test2.jpeg');

        $image = Image::create()->uploadMedias([$this->uploadFile('test1'), $this->uploadFile('test2')]);

        $this->assertCount(2, $image->getMedia());

        $media = $image->getFirstMedia();

        $this->assertContains('uploads', $media->getUrl());
        $this->assertContains('origin.jpeg', $media->getUrl());
        $this->assertContains('thumb.jpg', $media->getUrl('thumb'));

        $this->assertStringEndsWith('origin.jpeg', $media->getPath());
        $this->assertStringEndsWith('thumb.jpg', $media->getPath('thumb'));

        $this->assertFileNotExists(__DIR__.'/medias/test.jpeg');
    }

    /**
     * Get a fake upload file.
     *
     * @param string $filename
     *
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    protected function uploadFile($filename)
    {
        return new \Symfony\Component\HttpFoundation\File\UploadedFile(
            __DIR__.'/medias/'.$filename.'.jpeg',
            'earth',
            'image/jpeg',
            393781,
            null,
            true
        );
    }
}
