<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @method static when(mixed $title, \Closure $param)
 */
class Book extends Model
{
    use HasFactory;

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'like', '%' . $title . '%');
    }

    public function scopePopular(Builder $query, ?string $from = null, ?string $to = null): Builder|QueryBuilder
    {
        return $query->withCount([
            'reviews' => fn(Builder $query) => $this->dateRangeFilter($query, $from, $to),
        ])->orderBy('reviews_count', 'desc');
    }

    public function scopeHighestRated(Builder $query, ?string $from = null, ?string $to = null): Builder
    {
        return $query->withAvg([
            'reviews' => fn(Builder $query) => $this->dateRangeFilter($query, $from, $to),
        ], 'rating')->orderBy('reviews_avg_rating', 'desc');
    }

    public function scopeMinReviews(Builder $query, int $minReviews): Builder
    {
        return $query->having('reviews_count', '>=', $minReviews);
    }

    public function scopeUnpopular(Builder $query, ?string $from = null, ?string $to = null): Builder
    {
        return $query->withCount([
            'reviews' => fn(Builder $query) => $this->dateRangeFilter($query, $from, $to),
        ])->orderBy('reviews_count');
    }

    private function dateRangeFilter(Builder $query, ?string $from = null, ?string $to = null): Builder
    {
        if ($from && !$to) {
            return $query->where('created_at', '>=', $from);
        }

        if (!$from && $to) {
            return $query->where('created_at', '<=', $to);
        }

        if ($from && $to) {
            return $query->whereBetween('created_at', [$from, $to]);
        }

        return $query;
    }
}
