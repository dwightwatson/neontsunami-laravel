## Neon Tsunami

[![Circle CI](https://circleci.com/gh/dwightwatson/neontsunami.png?style=shield)](https://circleci.com/gh/dwightwatson/neontsunami)

### Introduction
This is the source code for my website/blog [Neon Tsunami](http://www.neontsunami.com). I open sourced it as an example to other developers who might want to see how a real-world Laravel application might be put together. I've worked on a number of large production apps and this is just a taste of my (largely opinionated) style in a smaller app.

* I'm not a huge fan of the repository pattern (at least not yet anyway)
* I prefer validations to be handled by the model, hence using [watson/validating](http://github.com/dwightwatson/validating)
* I'm quite content to use PHPUnit for unit testing models and functional testing the controllers (in conjunction with Mockery and TestDummy)
* I haven't done any integration testing because I can't decide on a test framework
* I use Gulp to handle my assets

#### Envoy deployment
Right now I'm using Laravel Forge's default auto-update functionality, where it deploys my app whenever I push updates to GitHub. However I originally set up this app to be deployed by a CI tool through Envoy. For example, whenever the tests pass through CircleCI it would be able to call my Envoy script and deploy to my production server.

The Envoy script I have in this repo is set up to point to the default Forge site on any Forge server (just pop the IP address in the `@servers` section at the top of the file) and simply has a bunch of different tasks you can run to push your site live.

##### envoy deploy
Deploy your master branch and get Composer updates. Can also take the `--branch=foo` option.

##### envoy stage
Deploy your staging branch and get Composer updates. Can also take the `--branch=foo` option.

##### envoy up / envoy down
Take your site in or out of maintenance mode.

##### envoy run --command="gulp run"
Run an arbitrary ocmmand in the conext of your application.

##### envoy migrate / envoy migrate:rollback
Run the migrations or roll them back in the context of your application.

#### Gulp asset pipeline
The Gulpfile I've set up is used to handle the assets of my application. All the asets are kept in `app/assets` and when you publish them they are run through Gulp and then placed in `public/assets` so that your application has access to them.

`gulp` has a default task that will compile and publish your styles, scripts, images and fonts, otherwise you can do them individually. You'll notice that `application.less` and `application.js` both include a number `//= include`s at the top, which the Gulp pipeline uses to include other assets in their place. It's like a mini-Sprockets.

##### Stylesheets
`gulp stylesheets` will concatenate all your stylesheets, run then through the LESS compiler and then minify and publish them.

##### JavaScripts
`gulp javascripts` will concatenate all your JavaScripts, minify them and then publish them.

##### Other assets
`gulp images` will optimize your image files (try to make the file sizes smaller without losing image quality) and `gulp run fonts` will simply publish your font assets.

##### Watching
`gulp watch` will watch your stylesheets and JavaScripts for changes and then publish them immediately. It doesn't watch changes on images or fonts because they realisically wouldn't be changing that often so I did not see a need, but you could always do this if you wanted.

### License

The Neon Tsunami website is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
