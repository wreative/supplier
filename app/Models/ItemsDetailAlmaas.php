<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsDetailAlmaas extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'al_d_items';
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'price_sell',
        'price_buy',
        'info',
    ];

    public function relationItems()
    {
        return $this->hasOne('App\Models\ItemsAlmaas', 'id', 'detail_id');
    }
}