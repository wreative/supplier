<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'transaction';
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = [
        'items_id',
        'total',
        'code',
        'tgl',
        'unit_id',
        'info',
        'p_id'
    ];

    public function relationItems()
    {
        return $this->belongsTo('App\Models\Items', 'items_id', 'id');
    }

    public function relationUnits()
    {
        return $this->belongsTo('App\Models\Units', 'unit_id', 'id');
    }

    public function relationPurchase()
    {
        return $this->belongsTo('App\Models\Purchase', 'p_id', 'id');
    }
}
