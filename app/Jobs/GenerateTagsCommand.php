<?php

namespace NeonTsunami\Commands;

use NeonTsunami\Tag;
use NeonTsunami\Jobs\Job;


use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Database\Eloquent\Collection;

class GenerateTagsCommand extends Job implements SelfHandling
{

    /**
     * Tag slugs.
     *
     * @var string
     */
    protected $slugs;

    /**
     * Tag models.
     *
     * @var array
     */
    protected $tags = [];

    /**
     * Create a new command instance.
     *
     * @param  string  $slugs
     * @return void
     */
    public function __construct($tags)
    {
        $this->slugs = explode(',', $tags);
    }

    /**
     * Execute the command.
     *
     * @return Collection
     */
    public function handle()
    {
        foreach ($this->slugs as $slug) {
            if (! $tag = Tag::where('slug', $slug)->first()) {
                $tag = Tag::create(['name' => $slug]);
            }

            $this->tags[] = $tag;
        }

        return new Collection($this->tags);
    }
}
