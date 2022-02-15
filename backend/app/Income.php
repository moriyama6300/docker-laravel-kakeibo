<?php declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

final class Income extends Model
{
    protected $fillable = [
        'date', 'category','yen'
    ];
}
