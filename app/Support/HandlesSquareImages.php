<?php

namespace App\Support;

use GdImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Symfony\Component\Mime\MimeTypes;

/**
 * Semua foto (menu maupun profil) otomatis disimpan sebagai persegi 1:1
 * supaya tampilannya rapi di mana saja.
 */
trait HandlesSquareImages
{
    protected function storeSquareImage(UploadedFile $file, string $folder, int $maxSide = 1200): ?string
    {
        $directory = public_path($folder);

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $baseName = Str::random(20).'_'.time();
        $name = $baseName.'.jpg';

        if ($this->saveSquareImage($file->getRealPath(), $directory.DIRECTORY_SEPARATOR.$name, $maxSide)) {
            return $folder.'/'.$name;
        }

        // Cadangan: kalau gambarnya tidak bisa diproses, simpan apa adanya.
        // Ekstensi ikut isi file (bukan nama dari browser) supaya tidak ada
        // file executable yang tersimpan di folder publik.
        $name = $baseName.'.'.$this->safeExtension($file->getRealPath());
        $file->move($directory, $name);

        return $folder.'/'.$name;
    }

    protected function safeExtension(string $path): string
    {
        $mime = (string) (@mime_content_type($path) ?: '');

        $extensions = $mime !== '' ? MimeTypes::getDefault()->getExtensions($mime) : [];

        $extension = $extensions[0] ?? 'bin';

        return preg_replace('/[^a-z0-9]/', '', strtolower($extension)) ?: 'bin';
    }

    protected function deleteStoredImage(?string $path): void
    {
        if (! $path || str_starts_with($path, 'http')) {
            return;
        }

        $fullPath = public_path($path);

        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }

    /**
     * Potong foto dari tengah, ubah jadi 1:1, lalu perkecil maksimal $maxSide.
     */
    protected function saveSquareImage(string $source, string $target, int $maxSide = 1200): bool
    {
        $image = $this->openImage($source);

        if (! $image) {
            return false;
        }

        $image = $this->applyExifOrientation($image, $source);

        $width = imagesx($image);
        $height = imagesy($image);
        $side = min($width, $height);
        $size = min($side, $maxSide);

        $canvas = imagecreatetruecolor($size, $size);
        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefilledrectangle($canvas, 0, 0, $size, $size, $white);

        $saved = imagecopyresampled(
            $canvas,
            $image,
            0,
            0,
            (int) round(($width - $side) / 2),
            (int) round(($height - $side) / 2),
            $size,
            $size,
            $side,
            $side
        ) && imagejpeg($canvas, $target, 85);

        imagedestroy($canvas);
        imagedestroy($image);

        return $saved;
    }

    protected function openImage(string $path): ?GdImage
    {
        if (! is_file($path) || ! function_exists('imagecreatetruecolor')) {
            return null;
        }

        $type = @getimagesize($path)[2] ?? 0;

        $image = match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($path),
            IMAGETYPE_PNG => @imagecreatefrompng($path),
            IMAGETYPE_GIF => @imagecreatefromgif($path),
            IMAGETYPE_BMP => function_exists('imagecreatefrombmp') ? @imagecreatefrombmp($path) : false,
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
            IMAGETYPE_ICO => function_exists('imagecreatefromico') ? @imagecreatefromico($path) : false,
            default => null,
        };

        if (! $image) {
            // Format lain (mis. AVIF, TGA, TIFF) selama didukung lib GD.
            $image = function_exists('imagecreatefromstring')
                ? @imagecreatefromstring((string) @file_get_contents($path))
                : false;
        }

        return $image instanceof GdImage ? $image : null;
    }

    /**
     * Foto HP sering tersimpan terbalik, jadi putar dulu sesuai EXIF.
     */
    protected function applyExifOrientation(GdImage $image, string $path): GdImage
    {
        if (! function_exists('exif_read_data')) {
            return $image;
        }

        $rotated = match ((int) (@exif_read_data($path)['Orientation'] ?? 1)) {
            3 => imagerotate($image, 180, 0),
            6 => imagerotate($image, -90, 0),
            8 => imagerotate($image, 90, 0),
            default => null,
        };

        if ($rotated instanceof GdImage) {
            imagedestroy($image);

            return $rotated;
        }

        return $image;
    }
}
