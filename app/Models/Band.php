<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Band extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_ar',
        'name_en',
        'name_fr',
    ];

    public function name($lang = null)
    {
        $lang = $lang ?? session('locale', app()->getLocale());

        return match ($lang) {
            'en' => $this->name_en ?? $this->name_ar,
            'fr' => $this->name_fr ?? $this->name_ar,
            'ar' => $this->name_ar,
            default => $this->name_ar
        };
    }

    public function getNameAttribute()
    {
        return $this->name();
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'band_brand');
    }

    public function section()
    {
        return Section::withTrashed()->where('type', 'band')->where('element', $this->id)->first();
    }
}
