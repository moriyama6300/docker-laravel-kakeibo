<?php declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

final class Labels extends Model
{
    protected $fillable = [
        'name', 'color'
    ];
}
