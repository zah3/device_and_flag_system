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
        $model = Device::firstOrCreate(['serial_number' => $request->serial_number],['serial_number' => $request->serial_number]);
        try{
            DB::beginTransaction();
            $flag = new Flag($request);
            $model->appendFlagToList($flag);
        }catch(\Exception | \Throwable $error){
            DB::rollBack();
            return response()->json(['message'=>'error','error' => $error->getMessage()],400);
        }
        DB::commit();
        $model->save();
        return response()->json(['message'=>'ok','request' => $request->all(),'model' => $model,'flag' => $flag],200);
    }

}