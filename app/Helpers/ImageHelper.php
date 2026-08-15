<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageHelper
{
    /*
    |--------------------------------------------------------------------------
    | Standard Image Upload
    |--------------------------------------------------------------------------
    |
    | Use for:
    | Category
    | Sub Category
    | Child Category
    | Product Thumbnail
    |
    | This method crops image to exact size.
    |
    */

    public static function upload(
        UploadedFile $file,
        string $folder,
        int $width = 600,
        int $height = 600,
        int $quality = 82
    ): string {

        /*
        |--------------------------------------------------------------------------
        | Clean Folder Path
        |--------------------------------------------------------------------------
        */

        $folder = trim(
            $folder,
            '/'
        );


        /*
        |--------------------------------------------------------------------------
        | Full Public Directory
        |--------------------------------------------------------------------------
        */

        $directory = public_path(
            $folder
        );


        /*
        |--------------------------------------------------------------------------
        | Create Folder If Missing
        |--------------------------------------------------------------------------
        */

        if (!is_dir($directory)) {

            mkdir(
                $directory,
                0755,
                true
            );

        }


        /*
        |--------------------------------------------------------------------------
        | File Extension
        |--------------------------------------------------------------------------
        */

        $extension = strtolower(
            $file->extension()
        );


        if ($extension === 'jpeg') {

            $extension = 'jpg';

        }


        /*
        |--------------------------------------------------------------------------
        | Unique File Name
        |--------------------------------------------------------------------------
        */

        $fileName =
            Str::uuid()
            . '.'
            . $extension;


        /*
        |--------------------------------------------------------------------------
        | Full Destination Path
        |--------------------------------------------------------------------------
        */

        $fullPath =
            $directory
            . DIRECTORY_SEPARATOR
            . $fileName;


        /*
        |--------------------------------------------------------------------------
        | Intervention Image Manager
        |--------------------------------------------------------------------------
        */

        $manager = new ImageManager(
            new Driver()
        );


        /*
        |--------------------------------------------------------------------------
        | Read + Crop + Resize + Save
        |--------------------------------------------------------------------------
        |
        | cover() keeps aspect ratio but crops excess area
        | to produce exact width × height.
        |
        */

        $manager
            ->read(
                $file->getRealPath()
            )
            ->cover(
                $width,
                $height
            )
            ->save(
                $fullPath,
                quality: $quality
            );


        /*
        |--------------------------------------------------------------------------
        | Return Relative Public Path
        |--------------------------------------------------------------------------
        |
        | Example:
        | uploads/categories/uuid.jpg
        |
        */

        return
            $folder
            . '/'
            . $fileName;
    }


    /*
    |--------------------------------------------------------------------------
    | Logo Upload
    |--------------------------------------------------------------------------
    |
    | Use for:
    | Brand Logo
    | Site Logo
    | Partner Logo
    |
    | Does NOT crop the image.
    | Maintains aspect ratio.
    |
    */

    public static function uploadLogo(
        UploadedFile $file,
        string $folder,
        int $width = 600,
        int $height = 400,
        int $quality = 90
    ): string {

        /*
        |--------------------------------------------------------------------------
        | Clean Folder Path
        |--------------------------------------------------------------------------
        */

        $folder = trim(
            $folder,
            '/'
        );


        /*
        |--------------------------------------------------------------------------
        | Public Directory
        |--------------------------------------------------------------------------
        */

        $directory = public_path(
            $folder
        );


        /*
        |--------------------------------------------------------------------------
        | Create Directory
        |--------------------------------------------------------------------------
        */

        if (!is_dir($directory)) {

            mkdir(
                $directory,
                0755,
                true
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Extension
        |--------------------------------------------------------------------------
        */

        $extension = strtolower(
            $file->extension()
        );


        if ($extension === 'jpeg') {

            $extension = 'jpg';

        }


        /*
        |--------------------------------------------------------------------------
        | Unique File Name
        |--------------------------------------------------------------------------
        */

        $fileName =
            Str::uuid()
            . '.'
            . $extension;


        /*
        |--------------------------------------------------------------------------
        | Full File Path
        |--------------------------------------------------------------------------
        */

        $fullPath =
            $directory
            . DIRECTORY_SEPARATOR
            . $fileName;


        /*
        |--------------------------------------------------------------------------
        | Intervention Manager
        |--------------------------------------------------------------------------
        */

        $manager = new ImageManager(
            new Driver()
        );


        /*
        |--------------------------------------------------------------------------
        | Scale Down Without Cropping
        |--------------------------------------------------------------------------
        |
        | Important for logos.
        | Keeps original aspect ratio.
        |
        */

        $manager
            ->read(
                $file->getRealPath()
            )
            ->scaleDown(
                width: $width,
                height: $height
            )
            ->save(
                $fullPath,
                quality: $quality
            );


        return
            $folder
            . '/'
            . $fileName;
    }


    /*
    |--------------------------------------------------------------------------
    | Product Gallery Image
    |--------------------------------------------------------------------------
    |
    | Useful later for product gallery.
    |
    */

    public static function uploadGallery(
        UploadedFile $file,
        string $folder = 'uploads/products/gallery',
        int $width = 1200,
        int $height = 1200,
        int $quality = 85
    ): string {

        return self::upload(
            $file,
            $folder,
            $width,
            $height,
            $quality
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Physical File
    |--------------------------------------------------------------------------
    */

    public static function delete(
        ?string $file
    ): void {

        if (!$file) {

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Convert DB Relative Path → Full Public Path
        |--------------------------------------------------------------------------
        */

        $path = public_path(
            ltrim(
                $file,
                '/'
            )
        );


        /*
        |--------------------------------------------------------------------------
        | Delete Only If File Exists
        |--------------------------------------------------------------------------
        */

        if (is_file($path)) {

            unlink($path);

        }
    }


    /*
    |--------------------------------------------------------------------------
    | File Exists
    |--------------------------------------------------------------------------
    */

    public static function exists(
        ?string $file
    ): bool {

        if (!$file) {

            return false;

        }


        return is_file(
            public_path(
                ltrim(
                    $file,
                    '/'
                )
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Public URL
    |--------------------------------------------------------------------------
    |
    | Optional helper if needed in PHP code.
    |
    */

    public static function url(
        ?string $file
    ): ?string {

        if (!$file) {

            return null;

        }


        return asset(
            ltrim(
                $file,
                '/'
            )
        );
    }
}