<?php declare(strict_types=1);

namespace Sakila\Transformer;

use League\Fractal\TransformerAbstract;
use Sakila\Models\StoreModel;

class StoreTransformer extends TransformerAbstract
{
    /**
     * @param \Sakila\Models\StoreModel $store
     *
     * @return array
     */
    public function transform(StoreModel $store): array
    {
        return [
            'storeId'        => $store->getAttribute('store_id'),
            'managerStaffId' => $store->getAttribute('manager_staff_id'),
            'addressId'      => $store->getAttribute('address_id'),
        ];
    }
}
