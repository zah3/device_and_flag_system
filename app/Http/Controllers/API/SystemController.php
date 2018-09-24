<?php
/**
 * Created by PhpStorm.
 * User: zachariasz
 * Date: 2018-09-24
 * Time: 22:04
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

/**
 * Class SystemController
 * @package App\Http\Controllers\API
 */
class SystemController extends Controller{

    public function scan(string $serialNumber, string$flagName){
        return response(['']);
    }

}