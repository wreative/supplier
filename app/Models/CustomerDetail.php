<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDetail extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'd_customer';
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = [
        'email',
        'fax',
        'no_rek',
        'name_rek',
        'bank',
        'npwp',
        'info'
    ];

    public function relationCustomer()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'detail_id');
    }
}
