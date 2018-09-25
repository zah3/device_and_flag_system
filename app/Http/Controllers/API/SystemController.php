<?php
/**
 * Created by PhpStorm.
 * User: zachariasz
 * Date: 2018-09-24
 * Time: 22:04
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Flag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class SystemController
 * @package App\Http\Controllers\API
 */
class SystemController extends Controller{

    private $validateScanRequestRules = [];

    public function __construct(){
        $this->validateScanRequestRules = [
            'serial_number' => 'required|max:255',
            'flag_name' => 'required|in:'.implode(',',Flag::AVAILABLE_FLAG_NAMES),
        ];
    }

    /**
     * @param Request $request
     * @param  [string] serial_number
     * @param  [string] flag_name
     * @return \Illuminate\Http\JsonResponse
     */
    public function scan(Request $request){
        $this->validate($request,$this->validateScanRequestRules);
        $device =  Device::find($request->serial_number);
        if(!$device && $request->flag_name === Flag::FLAG_NAME_UNPACKING){
            $device = new Device(['serial_number' => $request->serial_number]);
        }else if((!$device && $request->flag_name !== Flag::FLAG_NAME_UNPACKING) ||
            ($device && $request->flag_name !== Flag::FLAG_NAME_UNPACKING && $device->flag_name == NULL)){
            return response()->json(['message'=>'error','error' => 'Device should start his journey in ' . Flag::FLAG_NAME_UNPACKING],400);
        }
        //$device = Device::firstOrCreate(['serial_number' => $request->serial_number],['serial_number' => $request->serial_number]);
        try{
            DB::beginTransaction();
            $flag = new Flag($request);
            $device->appendFlagToList($flag);
        }catch(\Exception | \Throwable $error){
            DB::rollBack();
            return response()->json(['message'=>'error','error' => $error->getMessage()],400);
        }
        DB::commit();
        $device->save();
        return response()->json(['message'=>'ok','request' => $request->all(),'device' => $device,'flag' => $flag],200);
    }

}