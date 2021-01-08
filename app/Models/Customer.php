<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'customer';
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
        'address',
        'tlp',
        'detail_id'
    ];

    public function relationDetail()
    {
        return $this->belongsTo('App\Models\CustomerDetail', 'detail_id', 'id');
    }
}
