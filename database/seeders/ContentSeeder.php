<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 3; $i++) {
            $title = ucfirst(fake()->words(5, true));
            $slug = Str::slug($title, '-');
            $body = '<p>';
            $body .= fake()->text(250);
            $body .= '</p>';
            $body .= '<p>';
            $body .= fake()->text(250);
            $body .= '</p>';
            $body .= '<p>';
            $body .= fake()->text(500);
            $body .= '</p>';
            $excerpt = substr($body, 0, 150);
            Content::firstOrCreate([
                'title' => $title,
                'slug' => $i . '-' . $slug,
                'excerpt' => $excerpt,
                'body' => $body,
                'author_id' => User::where('type', 'Administrator')->first()->id,
                'published' => true
            ]);
        }
    }
}
