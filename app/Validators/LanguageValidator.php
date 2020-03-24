<?php declare(strict_types=1);

namespace Sakila\Validators;

use Sakila\Domain\Language\Validator\LanguageValidatorInterface;

class LanguageValidator extends AbstractValidator implements LanguageValidatorInterface
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'id'   => 'sometimes|required|exists:name,language_id',
            'name' => ['required', 'max:20'],
        ];
    }
}
