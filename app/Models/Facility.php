<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Facility extends Model
{
    protected $fillable = ['business_name','last_update_date','street_address'];

    protected $casts = [
        'last_update_date' => 'date',
    ];

    public function materials()
    {
        return $this->belongsToMany(Material::class);
    }

    /* Query Scopes keep the controller skinny */
    public function scopeSearch($query, ?string $term)
    {
        if (!$term) return $query;
        $term = "%{$term}%";
        return $query->where(function($q) use ($term) {
            $q->where('business_name', 'like', $term)
              ->orWhere('street_address', 'like', $term)
              ->orWhereHas('materials', fn($mq) => $mq->where('name','like',$term));
        });
    }

    public function scopeFilterByMaterial($query, $materialId)
    {
        if (!$materialId) return $query;
        return $query->whereHas('materials', fn($q) => $q->where('materials.id', $materialId));
    }

    public function scopeSortByLastUpdate($query, $direction = 'desc')
    {
        $direction = in_array(strtolower($direction), ['asc','desc']) ? $direction : 'desc';
        return $query->orderBy('last_update_date', $direction);
    }
}
