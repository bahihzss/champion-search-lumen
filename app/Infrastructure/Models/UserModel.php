<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Infrastructure\Models\User
 *
 * @property int $id
 * @property string $name 名前
 * @property string $email メールアドレス
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|UserModel newModelQuery()
 * @method static Builder|UserModel newQuery()
 * @method static Builder|UserModel query()
 * @method static Builder|UserModel whereCreatedAt($value)
 * @method static Builder|UserModel whereEmail($value)
 * @method static Builder|UserModel whereId($value)
 * @method static Builder|UserModel whereName($value)
 * @method static Builder|UserModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserModel extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'users';
    protected $fillable = [
        'id', 'name', 'email',
    ];
}
