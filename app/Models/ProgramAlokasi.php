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
        'cpcl_status',
        'cpcl_upd_date',
        'cpcl_upd_id_user',
        'verifikasi_status',
        'verifikasi_upd_date',
        'verifikasi_upd_id_user',
        'kontrak_status',
        'kontrak_upd_date',
        'kontrak_upd_id_user',
        'pengiriman_status',
        'pengiriman_upd_date',
        'pengiriman_upd_id_user',
        'distribusi_status',
        'distribusi_upd_date',
        'distribusi_upd_id_user',
        'crt_id_user',
        'upd_id_user',
        'del_id_user'
    ];
}
