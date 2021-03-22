<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'payment';
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function relationTransaction()
    {
        return $this->hasOne('App\Models\Transaction', 'id', 'pay_id');
    }
}
