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

    public $incrementing = false;

    /**
     * @param Flag $nextFlag
     */
    public function appendFlagToList(Flag $nextFlag) : void{
        $this->validateFlow($nextFlag);
        $flagList = $this->getFlagListOfModel();
        $flagList[] = $nextFlag;
        $this->flag_list = json_encode($flagList);
    }

    /**
     * check if string is a json
     * @param $string
     * @return bool
     */
    public function isJson(?string $string) : bool{
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * @return array|mixed
     */
    public function getFlagListOfModel(){
        return ($this->isJson($this->flag_list)) ? json_decode($this->flag_list) : [];
    }

    /**
     * @return array
     */
    private function getPossibleNextFlag() : array {
        $flagList = $this->getFlagListOfModel();
        if(count($flagList)){
            $lastFlagFromTheList = end($flagList);
            if($lastFlagFromTheList->name === Flag::FLAG_NAME_UNPACKING){
                return [Flag::FLAG_NAME_TESTING_BROKEN, Flag::FLAG_NAME_TESTING_EFFICIENT];
            }elseif($lastFlagFromTheList->name === Flag::FLAG_NAME_TESTING_BROKEN){
                return [Flag::FLAG_NAME_PACKING_BROKEN];
            }elseif($lastFlagFromTheList->name === Flag::FLAG_NAME_PACKING_BROKEN){
                return []; // as a last item in flow cannot have next flag
            }elseif($lastFlagFromTheList->name === Flag::FLAG_NAME_TESTING_EFFICIENT){
                return [Flag::FLAG_NAME_CLEANING,FLAG::FLAG_NAME_HOUSING_REPLACEMENT];
            }elseif($lastFlagFromTheList->name === Flag::FLAG_NAME_CLEANING ||
                    $lastFlagFromTheList->name === Flag::FLAG_NAME_HOUSING_REPLACEMENT ){
                return [Flag::FLAG_NAME_PACKING];
            }elseif($lastFlagFromTheList->name === Flag::FLAG_NAME_PACKING){
                return [];// as a last item in flow cannot have next flag
            }
        }else{
            return [Flag::FLAG_NAME_UNPACKING];
        }
    }

    /**
     * @param $wantedFlagToAdd
     * @throws \Exception
     */
    public function validateFlow($wantedFlagToAdd){
        $possibleNextFlags = $this->getPossibleNextFlag();
        if(!count($possibleNextFlags)){
            throw new \Exception('Sorry, but this device has made 1 circle in flow.');
        }
        if(!in_array($wantedFlagToAdd->name,$possibleNextFlags)){
           throw new \Exception('Sorry, if Your last flag is: '. $wantedFlagToAdd->name.', next could be: '.implode(', ',$possibleNextFlags).'.');
        }
    }
}
