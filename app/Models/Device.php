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

    /**
     * @param Flag $nextFlag
     */
    public function appendFlagToList(Flag $nextFlag) : void{
        $flagList = $this->getFlagListOfModel();
        $flagList[] = $nextFlag;
        $this->flag_list = json_encode($flagList);
        $this->save();
    }

    /**
     * check if string is a json
     * @param $string
     * @return bool
     */
    function isJson(string $string) : bool{
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function getFlagListOfModel(){
        return ($this->isJson($this->flag_list)) ? json_decode($this->flag_list) : [];
    }

    function getPossibleNextFlag(){
        $flagList = $this->getFlagListOfModel();

    }
}
