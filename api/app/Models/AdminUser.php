<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    protected $connection = 'mysql';
    protected $table = 't_admin_user';
    public $timestamps = false;

}
