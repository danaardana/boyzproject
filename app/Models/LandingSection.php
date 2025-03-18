<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingSection extends Model
{
    use HasFactory;

    protected $table = 'landing_sections'; // Pastikan nama tabel benar
    protected $fillable = ['section_name', 'content', 'is_active', 'order'];
}
