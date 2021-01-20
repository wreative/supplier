<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierDetail extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'd_supplier';
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'email',
        'fax',
        'sales',
        'no_rek',
        'name_rek',
        'bank',
        'npwp',
        'info'
    ];

    public function relationTransaction()
    {
        return $this->hasOne('App\Models\Transaction', 'sup_id', 'id');
    }
}
