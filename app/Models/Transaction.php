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
        'type',
        'items_id',
        'info'
    ];

    public function relationItems()
    {
        return $this->belongsTo('App\Models\Items', 'id', 'items_id');
    }

    public function relationUnits()
    {
        return $this->belongsTo('App\Models\Units', 'id', 'unit_id');
    }
}
