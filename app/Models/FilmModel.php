<?php declare(strict_types=1);

namespace Sakila\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property \Illuminate\Database\Eloquent\Collection $actors
 * @property \Illuminate\Database\Eloquent\Collection $categories
 */
class FilmModel extends AbstractModel
{
    protected $table = 'film';

    protected $primaryKey = 'film_id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(ActorModel::class, 'film_actor', 'film_id', 'actor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(CategoryModel::class, 'film_category', 'film_id', 'category_id');
    }
}
