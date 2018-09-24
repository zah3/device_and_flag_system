<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'flag_list',
        'serial_number',
    ];

    protected $primaryKey = 'serial_number';
    public function appendFlagToList(Flag $nextFlag){
        var_dump(json_decode($this->flag_list),$this->isJson($this->flag_list));die(1);
        if($this->isJson($this->flag_list)){
            $currentFlagList = json_decode($this->flag_list);
            $currentFlagList[] = $nextFlag;
            $this->flag_list = json_encode($currentFlagList);
        }else{
            $array[] = $nextFlag;
            $this->flag_list = json_encode($array);
        }
        $this->save();
    }
    public function getFlagList(){
        return $this->flag_list;
    }

    function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
