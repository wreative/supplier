<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'sales';
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
        'tlp'
    ];
}
