<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinishGoodTicket extends Model{
	protected $table = 'log_finish_good_ticket';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $fillable = ['ticket_no', 'model', 'qty', 'ean', 'created_at'];
}