<?php declare(strict_types=1);

namespace Sakila\Transformer;

use League\Fractal\TransformerAbstract;
use Sakila\Models\FilmModel;

class FilmTransformer extends TransformerAbstract
{
    /**
     * @param \Sakila\Models\FilmModel $film
     *
     * @return array
     */
    public function transform(FilmModel $film): array
    {
        return [
            'filmId'             => $film->getAttribute('film_id'),
            'title'              => $film->getAttribute('title'),
            'description'        => $film->getAttribute('description'),
            'releaseYear'        => $film->getAttribute('release_year'),
            'languageId'         => $film->getAttribute('language_id'),
            'originalLanguageId' => $film->getAttribute('original_language_id'),
            'rentalDuration'     => $film->getAttribute('rental_duration'),
            'rentalRate'         => $film->getAttribute('rental_rate'),
            'length'             => $film->getAttribute('length'),
            'replacementCost'    => $film->getAttribute('replacement_cost'),
            'rating'             => $film->getAttribute('rating'),
            'specialFeatures'    => $film->getAttribute('special_features'),
        ];
    }
}
