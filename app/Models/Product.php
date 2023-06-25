<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Product extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'products';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'product_category_id',
        'supplier_id',
        'description',
        'price',
        'stock',
        'added_by',
        'total_product_in',
        'total_product_out',
        'added_by',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'active'    => 'Active',
        'inactive'  => 'Inactive',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function categories(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function suppliers(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function total_product_ins(): HasMany
    {
        return $this->hasMany(ProductIn::class, 'product_id');
    }

    public function total_product_outs(): HasMany
    {
        return $this->hasMany(ProductOut::class, 'product_id');
    }

    public function price() {
        return $this->attributes['price'] = "Rp " . number_format($this->attributes['price'],2,',','.');
    }
}