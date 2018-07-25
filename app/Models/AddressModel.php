<?php declare(strict_types=1);

namespace Sakila\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property \Sakila\Models\CountryModel $country
 */
class AddressModel extends AbstractModel
{
    public function city(): HasOne
    {
        return $this->hasOne(CityModel::class, 'city_id', 'city_id');
    }
}
