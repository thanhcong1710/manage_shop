<?php

namespace App\Models;

use App\Scopes\ThemeCouponScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockInOut extends Model
{
    use HasFactory;
 
    protected $table = "stock_in_outs";
    protected $guarded = [];

    public function creator()
    {
        return $this->hasOne(User::class,'id','creator_id');
    } 
}
