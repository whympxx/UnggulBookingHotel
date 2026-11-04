<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Simpan gambar upload ke public/uploads/{folder} dan kembalikan path relatif
 * (mis. "uploads/hotels/abc.jpg") yang bisa langsung dipakai dengan asset().
 */
class ImageUpload
{
    public static function store(UploadedFile $file, string $folder): string
    {
        $dir = public_path('uploads/'.$folder);
        File::ensureDirectoryExists($dir);

        $name = Str::uuid()->toString().'.'.$file->extension();
        $file->move($dir, $name);

        return 'uploads/'.$folder.'/'.$name;
    }

    /** Hapus file lama, hanya jika berada di folder uploads (gambar bawaan tidak ikut terhapus). */
    public static function delete(?string $path): void
    {
        if ($path && str_starts_with($path, 'uploads/')) {
            File::delete(public_path($path));
        }
    }
}
