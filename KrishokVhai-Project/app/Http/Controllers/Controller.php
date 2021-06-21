<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function uploadFile($file, $location){
        $originalFileName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileNameOnly = pathinfo($originalFileName, PATHINFO_FILENAME);
        $fileName = time().'.'.$extension;

        // Storage::disk('ftp')->put($location.$fileNameToStore, fopen($file, 'r+'));
        if($file->storeAs('public/images/'.$location , $fileName)){
            return $fileName;
        }
        return false;
    }


    // public function removeFiles($fileDirectory)
    // {
    //     Storage::disk('ftp')->delete($fileDirectory);
    // }

    public function removeFiles($fileName)
    {
        $filePath = public_path().'/images'.$fileName;
        if(file_exists($filePath)){
            @unlink($filePath);
        }
    }

    public function removeSingleFile($fileName){
        $filePath = public_path('storage/' . $fileName);
        if(file_exists($filePath)){
            if(@unlink($filePath)){
                return true;
            }
        }
        return false;
    }

    // public function fileExists($fileName)
    // {
    //     $exists = Storage::disk('ftp')->exists($fileName);
    //     return $exists;
    // }


    public function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }


}
