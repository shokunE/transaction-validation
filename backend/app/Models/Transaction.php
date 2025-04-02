<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $currency
 * @property float $amount
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User $user
 */
class Transaction extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'currency',
        'amount',
    ];
}
