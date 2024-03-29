<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'sales';
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'code',
        'dsc',
        'info',
        'dp',
        'tax',
        'ppn',
        'etc_price',
        'ship_price',
    ];

    public function relationTransaction()
    {
        return $this->hasOne('App\Models\Transaction', 'id', 's_id');
    }
}
