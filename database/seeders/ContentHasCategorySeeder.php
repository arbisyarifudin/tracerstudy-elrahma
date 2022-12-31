<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Content;
use App\Models\ContentHasCategories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentHasCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $contentIDs = Content::pluck('id');
        $categoryIDs = Categories::pluck('id');

        for ($i = 0; $i < ($contentIDs->count() - 1); $i++) {
            $contentID = $contentIDs[$i];
            for ($x = 0; $x < ($categoryIDs->count() - 1); $x++) {
                ContentHasCategories::firstOrCreate([
                    'content_id' => $contentID,
                    'category_id' => fake()->randomElement($categoryIDs),
                ]);
            }
        }
    }
}
