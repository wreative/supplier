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
        'p_id',
        's_id',
        'sup_id',
        'cus_id',
        'mar_id',
        'tgl',
        'price',
        'total',
        'c_price',
        'pay_id'
    ];

    public function relationItems()
    {
        return $this->belongsTo('App\Models\Items', 'items_id', 'id');
    }

    public function relationPurchase()
    {
        return $this->belongsTo('App\Models\Purchase', 'p_id', 'id');
    }

    public function relationSales()
    {
        return $this->belongsTo('App\Models\Sales', 's_id', 'id');
    }

    public function relationMarketer()
    {
        return $this->belongsTo('App\Models\Marketer', 'mar_id', 'id');
    }

    public function relationCustomer()
    {
        return $this->belongsTo('App\Models\Customer', 'cus_id', 'id');
    }

    public function relationSupplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'sup_id', 'id');
    }

    public function relationPayment()
    {
        return $this->belongsTo('App\Models\Payment', 'pay_id', 'id');
    }
}
