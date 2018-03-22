<?php

use Illuminate\Support\HtmlString;

if (! function_exists('markdown')) {
    /**
     * Convert Markdown into HTML.
     *
     * @param  string  $markdown
     * @return string
     */
    function markdown($markdown)
    {
        $compiled = (new Parsedown)->text($markdown);

        return new HtmlString($compiled);
    }
}
