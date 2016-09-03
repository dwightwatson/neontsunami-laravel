const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
  mix.sass('app.scss')
    .copy('resources/images', 'public/images')
    .webpack('app.js', 'public/js/app.js')
    .webpack('admin/app.js', 'public/js/admin/app.js')
    .version([
      'public/css/app.css',
      'public/js/app.js',
      'public/js/admin/app.js',
      'public/images'
    ]);
});
