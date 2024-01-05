<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Book::factory(42)->create()->each(function ($book) {
            $numReviews = random_int(6, 23);
            Review::factory()
                ->count($numReviews)
                ->goodReview()
                ->for($book)
                ->create()
            ;
        });
        Book::factory(48)->create()->each(function ($book) {
            $numReviews = random_int(1, 16);
            Review::factory()
                ->count($numReviews)
                ->averageReview()
                ->for($book)
                ->create()
            ;
        });
        Book::factory(10)->create()->each(function ($book) {
            $numReviews = random_int(8, 15);
            Review::factory()
                ->count($numReviews)
                ->badReview()
                ->for($book)
                ->create()
            ;
        });
    }
}
