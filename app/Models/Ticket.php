<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model {
    protected $fillable = ['user_id','subject','description','status','first_response_at'];
    public function owner(){ return $this->belongsTo(User::class,'user_id'); }
    public function replies(){ return $this->hasMany(TicketReply::class); }

    // helper: foi respondido por admin?
    public function hasAdminResponse(): bool {
        return $this->replies()->whereHas('author', fn($q)=>$q->where('role','admin'))->exists();
    }
}