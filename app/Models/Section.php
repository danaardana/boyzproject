<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'title', 'description','content', 'image', 'button_text', 'button_link', 'is_active','layout', 'show_order'];

    public function contents()
    {
        return $this->hasMany(SectionContent::class);
    }
}
