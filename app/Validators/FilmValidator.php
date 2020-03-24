<?php declare(strict_types=1);

namespace Sakila\Validators;

use Sakila\Domain\Film\Validator\FilmValidatorInterface;

class FilmValidator extends AbstractValidator implements FilmValidatorInterface
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'filmId'             => 'sometimes|required|exists:film,film_id',
            'title'              => 'required|string|max:255',
            'description'        => '',
            'releaseYear'        => 'digits:4',
            'languageId'         => 'required|exists:language,language_id',
            'originalLanguageId' => 'sometimes|required|exists:language,language_id',
            'rentalDuration'     => 'numeric',
            'rentalRate'         => 'numeric',
            'length'             => 'numeric',
            'replacementCost'    => 'numeric',
            'rating'             => 'in:G,PG,PG-13,R,NC-17',
            'specialFeatures'    => 'in:Trailers,Commentaries,Deleted Scenes,Behind the Scenes',
        ];
    }
}
