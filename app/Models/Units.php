<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'units';
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function relationItems()
    {
        return $this->hasOne('App\Models\Items', 'id', 'unit_id');
    }

    public function relationItemsAlmaas()
    {
        return $this->hasOne('App\Models\ItemsAlmaas', 'id', 'unit_id');
    }
