<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function checkUploadFolder($folder)
    {
        if(!is_dir(public_path().'/'.$folder)) {
            if (!mkdir($folder)) {
                return false;
            }
        }

        chmod(public_path().'/'.$folder, 0777);

        return true;
    }
}
