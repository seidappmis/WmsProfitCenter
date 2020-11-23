<?php

namespace App\Models;

use App\BaseModel;

class ClaimNote extends BaseModel
{
    //Set Table
    protected $table = "clm_claim_notes";

    public function details()
    {
      return $this->hasMany('App\Models\ClaimNoteDetail', 'claim_note_id');
    }
}
