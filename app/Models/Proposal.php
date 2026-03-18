<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposal extends Model
{
    use SoftDeletes;
    protected $table = 'proposals';
    public static $view = 'proposal_view';

    protected $fillable = [
        'tahun',
        'status_proposal',
        'file',
        'id_kelompok',
        'nama_kelompok',
        'alamat_kelompok',
        'id_program_alokasi',
        'jenis_bantuan',
        'jumlah_bantuan',
        'id_pic_penyuluh',
        'nama_penyuluh',
        'contact_person_penyuluh',
        'id_pic_penanggung_jawab',
        'nama_penanggung_jawab',
        'contact_person_penanggung_jawab',
        'status',
        'crt_id_user',
        'upd_id_user',
        'del_id_user'
    ];
}
