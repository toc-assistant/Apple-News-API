<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Request;

use TomGould\AppleNews\Request\MultipartBuilder;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * Tests for MultipartBuilder file operations that require actual filesystem access.
 */
final class MultipartBuilderFileTest extends TestCase
{
    private string $tempDir;

    protected function setUp(): void
    {
        $this->tempDir = sys_get_temp_dir() . '/apple-news-test-' . uniqid();
        mkdir($this->tempDir, 0777, true);
    }

    protected function tearDown(): void
    {
        // Clean up temp files
        $files = glob($this->tempDir . '/*');
        if ($files) {
            foreach ($files as $file) {
                unlink($file);
            }
        }
        rmdir($this->tempDir);
    }

    public function testAddImageFileWithJpeg(): void
    {
        $filePath = $this->tempDir . '/test.jpg';
        file_put_contents($filePath, 'fake-jpeg-content');

        $builder = new MultipartBuilder('test-boundary');
        $builder->addImageFile('hero', $filePath);
        $body = $builder->build();

        $this->assertStringContainsString('Content-Type: image/jpeg', $body);
        $this->assertStringContainsString('filename=test.jpg', $body);
        $this->assertStringContainsString('fake-jpeg-content', $body);
    }

    public function testAddImageFileWithPng(): void
    {
        $filePath = $this->tempDir . '/logo.png';
        file_put_contents($filePath, 'fake-png-content');

        $builder = new MultipartBuilder('test-boundary');
        $builder->addImageFile('logo', $filePath);
        $body = $builder->build();

        $this->assertStringContainsString('Content-Type: image/png', $body);
        $this->assertStringContainsString('filename=logo.png', $body);
    }

    public function testAddImageFileWithGif(): void
    {
        $filePath = $this->tempDir . '/animation.gif';
        file_put_contents($filePath, 'fake-gif-content');

        $builder = new MultipartBuilder('test-boundary');
        $builder->addImageFile('anim', $filePath);
        $body = $builder->build();

        $this->assertStringContainsString('Content-Type: image/gif', $body);
    }

    public function testAddImageFileWithUnknownExtension(): void
    {
        $filePath = $this->tempDir . '/image.xyz';
        file_put_contents($filePath, 'fake-content');

        $builder = new MultipartBuilder('test-boundary');
        $builder->addImageFile('unknown', $filePath);
        $body = $builder->build();

        $this->assertStringContainsString('Content-Type: application/octet-stream', $body);
    }

    public function testAddImageFileWithWebpExtension(): void
    {
        $filePath = $this->tempDir . '/image.webp';
        file_put_contents($filePath, 'fake-webp-content');

        $builder = new MultipartBuilder('test-boundary');
        $builder->addImageFile('webp', $filePath);
        $body = $builder->build();

        $this->assertStringContainsString('Content-Type: image/webp', $body);
    }

    public function testAddImageFileWithUppercaseExtension(): void
    {
        $filePath = $this->tempDir . '/photo.JPG';
        file_put_contents($filePath, 'fake-jpeg-content');

        $builder = new MultipartBuilder('test-boundary');
        $builder->addImageFile('photo', $filePath);
        $body = $builder->build();

        $this->assertStringContainsString('Content-Type: image/jpeg', $body);
    }

    public function testAddImageFileWithJpegExtension(): void
    {
        $filePath = $this->tempDir . '/photo.jpeg';
        file_put_contents($filePath, 'fake-jpeg-content');

        $builder = new MultipartBuilder('test-boundary');
        $builder->addImageFile('photo', $filePath);
        $body = $builder->build();

        $this->assertStringContainsString('Content-Type: image/jpeg', $body);
    }

    public function testAddPartWithoutFilename(): void
    {
        $builder = new MultipartBuilder('test-boundary');
        $builder->addPart('data', 'content', 'text/plain', null);
        $body = $builder->build();

        $this->assertStringContainsString('name=data', $body);
        $this->assertStringNotContainsString('filename=', $body);
    }
}

