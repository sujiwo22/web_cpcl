<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramAlokasi extends Model
{
    use SoftDeletes;
    protected $table = 'program_alokasis';
    public static $view = 'program_alokasi_view';

    protected $fillable = [
        'tahun',
        'program_kementrian',
        'id_kementrian',
        'id_dirjen',
        'id_program',
        'id_pic',
        'pic',
        'contact_person',
        'kuota',
        'satuan',
        'status',
        'crt_id_user',
        'upd_id_user',
        'del_id_user'
    ];
}
