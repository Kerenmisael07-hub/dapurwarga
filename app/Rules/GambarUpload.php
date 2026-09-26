<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

/**
 * Bebas format gambar apa saja (JPG, PNG, WEBP, GIF, BMP, AVIF, HEIC, ...),
 * tapi bukan SVG karena bisa berisi skrip, dan tetap dibatasi ukurannya.
 */
class GambarUpload implements ValidationRule
{
    /**
     * MIME yang ditolak demi keamanan.
     *
     * @var list<string>
     */
    protected array $ditolak = [
        'image/svg+xml',
        'image/svg-xml',
    ];

    public function __construct(protected int $maxKilobytes = 8192) {}

    /**
     * Batas yang benar-benar berlaku, dipakai juga untuk teks bantu di form
     * supaya angka yang tampil tidak pernah berbohong.
     */
    public static function infoUkuran(): string
    {
        return 'Maksimal '.round(static::batasMaksimum() / 1024).' MB';
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile) {
            $fail('File gambar tidak terkirim. Coba ulangi unggahannya.');

            return;
        }

        if (! $this->unggahanDiterima($value, $fail)) {
            return;
        }

        if ($value->getSize() > $this->batasKilobytes() * 1024) {
            $fail('Ukuran file maksimal '.round($this->batasKilobytes() / 1024).' MB.');
        }
    }

    protected function openImage(UploadedFile $file): bool
    {
        $mime = (string) $file->getMimeType();

        if (! str_starts_with($mime, 'image/')) {
            return false;
        }

        return ! in_array($mime, $this->ditolak, true);
    }

    /**
     * Bedakan "server tidak mau menerima file ini" dari "file-nya bukan gambar",
     * karena keduanya sama-sama tidak lolos validasi.
     */
    protected function unggahanDiterima(UploadedFile $file, Closure $fail): bool
    {
        $error = $file->getError();

        if ($error === UPLOAD_ERR_OK) {
            if (! $this->openImage($file)) {
                $fail($this->pesanGambar($file));

                return false;
            }

            return true;
        }

        report('Upload gambar ditolak: '.$this->alasanUnggahan($error).' (kode '.$error.')');
        $fail($this->pesanUnggahan($error));

        return false;
    }

    protected function pesanGambar(UploadedFile $file): string
    {
        if (in_array((string) $file->getMimeType(), $this->ditolak, true)) {
            return 'Format SVG tidak diizinkan. Pakai JPG, PNG, WEBP, atau format gambar lain.';
        }

        return 'File yang diunggah harus berupa gambar.';
    }

    protected function pesanUnggahan(int $error): string
    {
        $batasServer = trim((string) ini_get('upload_max_filesize'));

        return match ($error) {
            UPLOAD_ERR_INI_SIZE => 'Ukuran file melebihi batas server ('.$batasServer.'). Kompres foto dulu atau naikkan upload_max_filesize di php.ini.',
            UPLOAD_ERR_FORM_SIZE => 'Ukuran file melebihi batas formulir.',
            UPLOAD_ERR_PARTIAL => 'Upload file terputus, coba ulangi.',
            UPLOAD_ERR_NO_FILE => 'Belum ada file yang dipilih.',
            UPLOAD_ERR_NO_TMP_DIR => 'Server tidak memiliki folder sementara.',
            UPLOAD_ERR_CANT_WRITE => 'Server gagal menyimpan file.',
            UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh ekstensi PHP di server.',
            default => 'File yang diunggah tidak valid.',
        };
    }

    protected function alasanUnggahan(int $error): string
    {
        return [
            UPLOAD_ERR_INI_SIZE => 'ukuran melebihi batas server (upload_max_filesize)',
            UPLOAD_ERR_FORM_SIZE => 'ukuran melebihi batas formulir (MAX_FILE_SIZE)',
            UPLOAD_ERR_PARTIAL => 'file hanya terupload sebagian',
            UPLOAD_ERR_NO_FILE => 'tidak ada file yang dipilih',
            UPLOAD_ERR_NO_TMP_DIR => 'folder sementara tidak tersedia',
            UPLOAD_ERR_CANT_WRITE => 'gagal menulis file ke disk',
            UPLOAD_ERR_EXTENSION => 'dihentikan oleh ekstensi PHP',
        ][$error] ?? 'error tidak diketahui';
    }

    /**
     * Batas terkecil antara aturan aplikasi dan batas server, supaya pesan
     * yang muncul selalu sesuai dengan batas yang benar-benar berlaku.
     */
    protected function batasKilobytes(): int
    {
        return static::batasMaksimum($this->maxKilobytes);
    }

    public static function batasMaksimum(?int $maxKilobytes = null): int
    {
        $maxKilobytes ??= (new static)->maxKilobytes;
        $server = (new static)->kilobytesDariIni((string) ini_get('upload_max_filesize'));

        return $server > 0 ? min($maxKilobytes, $server) : $maxKilobytes;
    }

    protected function kilobytesDariIni(string $value): int
    {
        $value = trim($value);

        if (! preg_match('/^(\d+(?:\.\d+)?)\s*([KMG]?)$/i', $value, $match)) {
            return 0;
        }

        $multiplier = ['K' => 1, 'M' => 1024, 'G' => 1024 * 1024][strtoupper($match[2])] ?? 1;

        return (int) round(((float) $match[1]) * $multiplier);
    }
}
