<?php declare(strict_types=1);

namespace Sakila\Transformer;

use League\Fractal\TransformerAbstract;
use Sakila\Models\AddressModel;

class AddressTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'city',
        'country'
    ];

    /**
     * @param \Sakila\Models\AddressModel $address
     *
     * @return array
     */
    public function transform(AddressModel $address): array
    {
        return [
            'id'         => $address->getAttribute('address_id'),
            'address'    => $address->getAttribute('address'),
            'address2'   => $address->getAttribute('address2'),
            'district'   => $address->getAttribute('district'),
            'cityId'     => $address->getAttribute('city_id'),
            'postalCode' => $address->getAttribute('postal_code'),
            'phone'      => $address->getAttribute('phone'),
        ];
    }

    /**
     * @param \Sakila\Models\AddressModel $address
     *
     * @return \League\Fractal\Resource\Item
     */
    protected function includeCity(AddressModel $address)
    {
        return $this->item($address->city, new CityTransformer());
    }

    /**
     * @param \Sakila\Models\AddressModel $address
     *
     * @return \League\Fractal\Resource\Item
     */
    protected function includeCountry(AddressModel $address)
    {
        return $this->item($address->city->country, new CountryTransformer());
    }
}
