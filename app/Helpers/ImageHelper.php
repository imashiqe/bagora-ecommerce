<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

use Illuminate\Support\Str;

use Intervention\Image\Drivers\Gd\Driver;

use Intervention\Image\ImageManager;


class ImageHelper
{
    public static function upload(

        UploadedFile $file,

        string $folder,

        int $width = 600,

        int $height = 600

    ): string {

        /*
        |--------------------------------------------------------------------------
        | Public Folder
        |--------------------------------------------------------------------------
        */

        $folder = trim(
            $folder,
            '/'
        );


        $directory =
            public_path(
                $folder
            );


        /*
        |--------------------------------------------------------------------------
        | Create folder automatically
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

        $extension =
            strtolower(
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


        $fullPath =

            $directory

            . DIRECTORY_SEPARATOR

            . $fileName;


        /*
        |--------------------------------------------------------------------------
        | Intervention Image
        |--------------------------------------------------------------------------
        */

        $manager =
            new ImageManager(
                new Driver()
            );


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
                quality: 82
            );


        /*
        |--------------------------------------------------------------------------
        | Save only relative public path in database
        |--------------------------------------------------------------------------
        */

        return

            $folder

            . '/'

            . $fileName;
    }


    public static function delete(
        ?string $file
    ): void {

        if (!$file) {

            return;

        }


        $path =
            public_path(
                $file
            );


        if (is_file($path)) {

            unlink($path);

        }

    }
}