<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsAlmaas extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'al_items';
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'unit_id',
        'stock',
        'code',
        'detail_id'
    ];

    public function relationUnits()
    {
        return $this->belongsTo('App\Models\Units', 'unit_id', 'id');
    }

    public function relationDetail()
    {
        return $this->belongsTo('App\Models\ItemsDetailAlmaas', 'detail_id', 'id');
    }
}
