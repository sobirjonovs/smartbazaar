<?php

namespace App\Models\Merchant;

use App\Foundation\Filters\Concerns\HasFilterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * App\Models\Merchant\Merchant
 *
 * @method where(string $string, int $id)
 * @method whereEmail(string $email)
 * @method create(array $array)
 * @method createToken(string $string)
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $password
 * @property string $email
 * @property int $status
 * @property string $registered_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereRegisteredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Merchant\Shop> $shopsRelation
 * @property-read int|null $shops_relation_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @mixin \Eloquent
 */
class Merchant extends Authenticatable
{
    use HasFactory, HasApiTokens, HasFilterable;

    protected $guarded = ['id'];

    /**
     * @return HasMany
     */
    public function shopsRelation(): HasMany
    {
        return $this->hasMany(Shop::class);
    }
}
