<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionContent extends Model
{
    use HasFactory;

    protected $fillable = ['section_id', 'content_key', 'content_value', 'description', 'type','extra_data','show_order','created_at','updated_at'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
