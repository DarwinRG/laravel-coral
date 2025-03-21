<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    private $categories = [
        ['name' => 'Animals', 'image' => 'https://picsum.photos/id/219/800/600'],
        ['name' => 'Mountains', 'image' => 'https://picsum.photos/id/353/800/600'],
        ['name' => 'People', 'image' => 'https://picsum.photos/id/342/800/600'],
        ['name' => 'Things', 'image' => 'https://picsum.photos/id/252/800/600'],
    ];

    private $date;

    private function createPost($data = [])
    {
        $date = $this->date->subDay();

        $category_key = array_rand($this->categories);

        $defaults = [
            'created_at' => $date,
            'updated_at' => $date,
            'published_at' => $date,
            'category_id' => $category_key + 1,
            'main_image_url' => $this->categories[$category_key]['image'],
        ];

        $data = array_merge($defaults, $data);

        return Post::factory()->create($data);
    }

    public function run()
    {
        $this->date = Carbon::now();

        foreach ($this->categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
            ]);
        }

        // Featured posts
        for ($i = 0; $i < 1; $i++) {
            $this->createPost(['is_featured' => 1]);
        }

        // Published posts
        for ($i = 0; $i < 2; $i++) {
            $this->createPost();
        }

        // Draft posts
        for ($i = 0; $i < 1; $i++) {
            $this->createPost(['published_at' => null]);
        }
    }
}
