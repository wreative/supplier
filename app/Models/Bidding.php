<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidding extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'bidding';
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = [
        'code',
        'cus_id',
        'items',
        'date',
        'ppn',
        'dsc',
        'gt',
        'info',
        'cost'
    ];

    public function relationCustomer()
    {
        return $this->belongsTo('App\Models\Customer', 'cus_id', 'id');
    }
}
