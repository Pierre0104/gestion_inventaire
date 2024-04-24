<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 
        'order_date', 
        'total_price',
        // Pas besoin d'inclure 'created_at' et 'updated_at' ici car Laravel les gère automatiquement
    ];

    // Relation avec Customer (si un modèle Customer existe)
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relation avec Product à travers la table de jointure order_product (si un modèle Product existe)
  public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price');
    }

    // Vous pouvez également ajouter d'autres méthodes et logiques nécessaires à votre modèle ici.
}
