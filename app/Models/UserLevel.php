<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLevel extends Model
{
    use SoftDeletes;
    protected $table = 'user_levels';

    protected $fillable = ['level_name', 'crt_id_user', 'upd_id_user','del_id_user'];

    var $view = 'user_level_view';
    //
}
