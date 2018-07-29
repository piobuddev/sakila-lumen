<?php declare(strict_types=1);

namespace Sakila\Validators;

use Sakila\Domain\Film\Validator\FilmValidator as FilmValidatorInterface;

class FilmValidator extends AbstractValidator implements FilmValidatorInterface
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'filmId'             => '',
            'title'              => '',
            'description'        => '',
            'releaseYear'        => '',
            'languageId'         => '',
            'originalLanguageId' => '',
            'rentalDuration'     => '',
            'rentalRate'         => '',
            'length'             => '',
            'replacementCost'    => '',
            'rating'             => '',
            'specialFeatures'    => '',
        ];
    }
}
