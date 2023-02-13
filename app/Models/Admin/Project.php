<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable=[
        "name","description","cover_img","github_link"
        
    ];
    
    use HasFactory;

    public function type(){
        return $this->belongsTo(Type::class);
    }

}
