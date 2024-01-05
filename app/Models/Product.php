<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    public static $rules = [
        'name' => 'required|unique:products',
        'buyPrice' => 'required',
        'sellPrice' => 'required',
        'stock' => 'required|numeric',
        'image' => 'required|image|mimes:jpeg,png|max:100', // Max size 100KB, allowed formats: JPG, PNG
        'categoryId' => 'required|exists:categories,id',
    ];

    public static $updateRules = [
        'name' => 'required',
        'buyPrice' => 'required',
        'sellPrice' => 'required',
        'stock' => 'required|numeric',
        'image' => 'required|image|mimes:jpeg,png|max:100', // Max size 100KB, allowed formats: JPG, PNG
        'categoryId' => 'required|exists:categories,id',
    ];

    public function scopeFilter($query, array $filters)
    {
        // if (request('search')) {
        //     return $query->where('name', 'like', '%' . request('search') . '%');
        // }

        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        });

        $query->when($filters['categoryId'] ?? false, function ($query, $categoryId) {
            return $query->whereHas('category', function ($query) use ($categoryId) {
                $query->where('categoryId', $categoryId);
            });
            // return $query->where('categoryId', $categoryId);
        });
    }
}
