<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes;
    protected $table = 'programs';
    public static $view = 'program_view';

    protected $fillable = ['nama_program', 'crt_id_user', 'upd_id_user', 'del_id_user'];
}
