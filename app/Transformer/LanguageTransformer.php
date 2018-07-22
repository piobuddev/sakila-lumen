<?php declare(strict_types=1);

namespace Sakila\Transformer;

use League\Fractal\TransformerAbstract;
use Sakila\Models\LanguageModel;

class LanguageTransformer extends TransformerAbstract
{
    public function transform(LanguageModel $language): array
    {
        return [
            'languageId' => $language->getAttribute('language_id'),
            'name'       => $language->getAttribute('name'),
        ];
    }
}
