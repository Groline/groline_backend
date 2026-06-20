<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'name_fr',
        'slug',
        'image',
        'status'
    ];

    public function getImageAttribute($value)
  {
    return $value && Storage::disk('upload')->exists($value)
      ? Storage::disk('upload')->url($value)
      : null;
  }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getNameAttribute()
    {
        $locale = session('locale', 'ar');
        return $this->{"name_{$locale}"};
    }

    public function section()
    {
        return Section::withTrashed()->where('type', 'brand')->where('element', $this->id)->first();
    }
}
