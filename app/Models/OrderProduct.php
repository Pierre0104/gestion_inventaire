<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    protected $table = 'order_product';

    // Si vous n'utilisez pas les timestamps (created_at et updated_at), ajoutez ceci :
    public $timestamps = false;

    // Si vous avez des colonnes supplémentaires dans la table pivot que vous souhaitez rendre accessibles, ajoutez-les ici :
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    // Définissez ici les relations si nécessaire, par exemple :
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
