<?php

if (! function_exists('commonmark')) {
    /**
     * Convert Commonmark into HTML.
     *
     * @param  string  $commonmark
     * @return string
     */
    function commonmark($commonmark)
    {
        return (new League\CommonMark\CommonMarkConverter)->convertToHtml($commonmark);
    }
}
