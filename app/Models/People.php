<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $guarded;

    public function getMarkerColorAttribute()
    {
        $color = '';
        $today = Carbon::today();
        $sub = Carbon::today()->subDays(5);
        if($this->expiration_date){
            if($this->expiration_date === $today->toDateString()){
                $color = '#fa7a9c';
            }elseif($this->expiration_date < $today->toDateString()){
                $color = '#fc0303';
            }
            elseif($this->expiration_date === $sub->toDateString()){
                $color = '#edfa5a';
            }elseif(Carbon::parse($this->expiration_date)->between($sub, $today)){
                $color =  '#edfa5a';
            }else{
                $color = '#50ba47';
            }
        }
        return $color;
    }
}
