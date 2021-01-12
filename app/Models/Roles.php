<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'roles';
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function relationCustomer()
    {
        return $this->hasMany('App\Models\User', 'id', 'role_id');
    }
}
