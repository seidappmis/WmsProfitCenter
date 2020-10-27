<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
  protected $table    = "tr_modules";
  protected $fillable = ['id', 'modul_name', 'modul_link', 'group_name', 'order_menu'];
}
