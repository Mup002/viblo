<?php

namespace Database\Seeders;

use App\Models\Serie;
use App\Models\Tag;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SerieTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $serie;
    protected $tag;
    public function __construct(
        Serie $serie,
        Tag $tag
    )
    {
        $this->serie = $serie;
        $this->tag = $tag;
    }
    public function run(): void
    {
        //
        $series = $this->serie::all();
        $tags = $this->tag::all();
        foreach($series as $serie)
        {
            $randomTags = $tags->random(rand(1,5));
            foreach($randomTags as $tag)
            {
                DB::table('serie_tag')->insert(
                    [
                        'serie_id' => $serie -> serie_id,
                        'tag_id' => $tag -> tag_id,
                        'created_at' => now(),
                        'updated_at'=> now(),
                    ]
                    );
            }
        }
    }
}
