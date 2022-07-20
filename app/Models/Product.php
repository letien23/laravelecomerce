<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['name','id_type','description','unit_price','promotion_price','image','unit','new'];

    public function billDetail(){
        return $this->hasMany('App\Models\BillDetail','id_product','id');
    }
}
