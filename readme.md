## Neon Tsunami

[![Circle CI](https://circleci.com/gh/dwightwatson/neontsunami.png?style=shield)](https://circleci.com/gh/dwightwatson/neontsunami)

### Introduction

This is the source code for my website/blog [Neon Tsunami](http://www.neontsunami.com). I open sourced it as an example to other developers who might want to see how a real-world Laravel application might be put together. I've worked on a number of large production apps and this is just a taste of my (largely opinionated) style in a smaller app.

* I'm not a huge fan of the repository pattern (at least not yet anyway)
* I prefer validations to be handled by the model, hence using [watson/validating](http://github.com/dwightwatson/validating)
* I'm quite content to use PHPUnit for unit testing models and functional testing the controllers (in conjunction with Mockery and TestDummy)
* I haven't done any integration testing because I can't decide on a test framework
* I use Gulp to handle my assets

### License

The Neon Tsunami website is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
