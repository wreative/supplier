<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'items';
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'unit_id',
        'stock',
        'code',
        'info',
        'detail_id'
    ];

    public function relationUnits()
    {
        return $this->belongsTo('App\Models\Units', 'unit_id', 'id');
    }

    public function relationTransaction()
    {
        return $this->hasOne('App\Models\Transaction', 'id', 'items_id');
    }

    public function relationDetail()
    {
        return $this->belongsTo('App\Models\ItemsDetail', 'detail_id', 'id');
    }

    public function relationBidding()
    {
        return $this->belongsTo('App\Models\Units', 'unit_id', 'id');
    }
}
