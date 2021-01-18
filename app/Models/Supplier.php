<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'supplier';
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
        return $this->belongsTo('App\Models\SupplierDetail', 'detail_id', 'id');
    }

    public function relationTransaction()
    {
        return $this->hasMany('App\Models\Transaction', 'id', 'sup_id');
    }
}
