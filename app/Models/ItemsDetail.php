<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsDetail extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'd_items';
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'price_inc',
        'price_exc',
        'profit',
        'price',
    ];

    public function relationItems()
    {
        return $this->hasOne('App\Models\Items', 'id', 'detail_id');
    }
}
