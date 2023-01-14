<?php

namespace Crud\Classes;


class FileUploader
{

    public static function upload($file, $path, $name = null)
    {
        $client_original_names = [
            'jpg' => 'jpg',
            'png' => 'png',
            'jpeg' => 'jpeg',
        ];


        if (!array_key_exists($file->getClientOriginalExtension(), $client_original_names)) {
            $name = time() . '-' . md5(rand(1, 1000)) . '.' . $file->getClientOriginalExtension();
        } else {
            $name = time() . '-' . md5(rand(1, 1000)) . '.webp';
        }


       // $name = time() . '-' . md5(rand(1, 1000)) . '.webp';
        $file->move($path, $name);
        return $path . $name;
    }

    public static function uploadMultiple($files, $path, $name = null)
    {


        $names = [];

        if (is_array($files)) {
            foreach ($files as $file) {
                $names[] = self::upload($file, $path, $name);
            }
        } else {

            $names[] = self::upload($files, $path, $name);
        }


        return $names;
    }

    public function uploadBase64($base64, $path, $name = null)
    {
        $name = $name ?? time() . '.png';
        $file = fopen($path . '/' . $name, 'wb');
        fwrite($file, base64_decode($base64));
        fclose($file);
        return $name;
    }

    public function uploadMultipleBase64($base64s, $path, $name = null)
    {
        $names = [];
        foreach ($base64s as $base64) {
            $names[] = $this->uploadBase64($base64, $path, $name);
        }
        return $names;
    }

    public function uploadBase64WithPrefix($base64, $path, $prefix, $name = null)
    {
        $name = $name ?? time() . '.png';
        $file = fopen($path . '/' . $prefix . $name, 'wb');
        fwrite($file, base64_decode($base64));
        fclose($file);
        return $prefix . $name;
    }

    public function uploadMultipleBase64WithPrefix($base64s, $path, $prefix, $name = null)
    {
        $names = [];
        foreach ($base64s as $base64) {
            $names[] = $this->uploadBase64WithPrefix($base64, $path, $prefix, $name);
        }
        return $names;
    }

    public function uploadBase64WithSuffix($base64, $path, $suffix, $name = null)
    {
        $name = $name ?? time() . '.png';
        $file = fopen($path . '/' . $name . $suffix, 'wb');
        fwrite($file, base64_decode($base64));
        fclose($file);
        return $name . $suffix;
    }

    public function uploadMultipleBase64WithSuffix($base64s, $path, $suffix, $name = null)
    {
        $names = [];
        foreach ($base64s as $base64) {
            $names[] = $this->uploadBase64WithSuffix($base64, $path, $suffix, $name);
        }
        return $names;
    }


}
