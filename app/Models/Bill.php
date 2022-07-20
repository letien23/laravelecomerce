<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    public function billDetail(){
        return $this->hasOne('App\Models\BillDetail','id_bill','id');
    }
    public function customer(){
        return $this->belongsTo('App\Models\Customer','id_customer','id');
    }
}
