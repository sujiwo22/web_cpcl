<?php

// app/Models/MenuItem.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    protected $fillable = ['icon', 'name', 'url', 'parent_id', 'order', 'crt_id_user', 'upd_id_user', 'del_id_user'];
    public static $view = 'menu_item_views';
    
    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id', 'id')->orderBy('order');
    }
}
