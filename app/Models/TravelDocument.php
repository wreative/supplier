<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelDocument extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'travel_doc';
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = [
        'code',
        'bid_id',
        'date',
        'driver',
        'police_num',
        'info',
        'print'
    ];

    public function relationBidding()
    {
        return $this->belongsTo('App\Models\Bidding', 'id', 'tdoc_id');
    }
}
