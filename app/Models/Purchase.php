<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'purchase';
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'code',
        'dsc',
        'info',
        'dp',
        'tax',
    ];

    public function relationTransaction()
    {
        return $this->hasOne('App\Models\Transaction', 'id', 'p_id');
    }
}
