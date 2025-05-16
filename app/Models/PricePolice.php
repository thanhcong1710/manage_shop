<?php

namespace App\Models;

use App\Scopes\ThemeCouponScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class PricePolice extends Model
{
    use HasFactory, SoftDeletes;
 
    protected $table = "price_polices";
    protected $guarded = [];

}
