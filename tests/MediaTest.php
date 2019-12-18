<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\UploadedFile;
use Infoexam\Media\Generators\Path;
use Infoexam\Media\Generators\Url;

class MediaTest extends Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/migrations');
    }

    /**
     * Get package providers.
     *
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            Infoexam\Media\MediaServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('filesystems.disks.public.root', __DIR__ . '/uploads');

        $app['config']->set('database.default', 'testing');

        $app['config']->set('medialibrary.url_generator', Url::class);

        $app['config']->set('medialibrary.path_generator', Path::class);
    }

    public function test_media()
    {
        $prefix = __DIR__ . '/medias/';

        copy($prefix . 'earth.jpeg', $prefix . 'test1.jpeg');
        copy($prefix . 'earth.jpeg', $prefix . 'test2.jpeg');

        $image = Image::create()->uploadMedias([
            $this->uploadFile('test1'),
            $this->uploadFile('test2'),
        ]);

        $this->assertCount(2, $image->getMedia());

        $media = $image->getFirstMedia();

        $this->assertStringContainsString('uploads', $media->getUrl());

        $this->assertStringContainsString('origin.jpeg', $media->getUrl());

        $this->assertStringContainsString('thumb.jpg', $media->getUrl('thumb'));

        $this->assertStringEndsWith('origin.jpeg', $media->getPath());

        $this->assertStringEndsWith('thumb.jpg', $media->getPath('thumb'));

        $this->assertFileNotExists(__DIR__ . '/medias/test.jpeg');
    }

    /**
     * Get a fake upload file.
     *
     * @param string $filename
     *
     * @return UploadedFile
     */
    protected function uploadFile($filename): UploadedFile
    {
        return new UploadedFile(
            __DIR__ . '/medias/' . $filename . '.jpeg',
            'earth',
            'image/jpeg',
            null,
            true
        );
    }
}
