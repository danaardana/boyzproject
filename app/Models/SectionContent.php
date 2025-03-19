<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionContent extends Model
{
    use HasFactory;

    protected $fillable = ['section_id', 'content_key', 'content_value'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
