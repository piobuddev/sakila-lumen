<?php declare(strict_types=1);

namespace Sakila\Transformer;

use League\Fractal\TransformerAbstract;
use Sakila\Models\CountryModel;

class CountryTransformer extends TransformerAbstract
{
    /**
     * @param \Sakila\Models\CountryModel $country
     *
     * @return array
     */
    public function transform(CountryModel $country): array
    {
        return [
            'countryId' => $country->getAttribute('country_id'),
            'country'   => $country->getAttribute('country'),
        ];
    }
}
