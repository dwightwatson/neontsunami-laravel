/*!
 * Bootstrap v3.3.5 (http://getbootstrap.com)
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under the MIT license
 */

if (typeof jQuery === 'undefined') {
  throw new Error('Bootstrap\'s JavaScript requires jQuery')
}

+function ($) {
  'use strict';
  var version = $.fn.jquery.split(' ')[0].split('.')
  if ((version[0] < 2 && version[1] < 9) || (version[0] == 1 && version[1] == 9 && version[2] < 1)) {
    throw new Error('Bootstrap\'s JavaScript requires jQuery version 1.9.1 or higher')
  }
}(jQuery);

/* ========================================================================
 * Bootstrap: transition.js v3.3.5
 * http://getbootstrap.com/javascript/#transitions
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // CSS TRANSITION SUPPORT (Shoutout: http://www.modernizr.com/)
  // ============================================================

  function transitionEnd() {
    var el = document.createElement('bootstrap')

    var transEndEventNames = {
      WebkitTransition : 'webkitTransitionEnd',
      MozTransition    : 'transitionend',
      OTransition      : 'oTransitionEnd otransitionend',
      transition       : 'transitionend'
    }

    for (var name in transEndEventNames) {
      if (el.style[name] !== undefined) {
        return { end: transEndEventNames[name] }
      }
    }

    return false // explicit for ie8 (  ._.)
  }

  // http://blog.alexmaccaw.com/css-transitions
  $.fn.emulateTransitionEnd = function (duration) {
    var called = false
    var $el = this
    $(this).one('bsTransitionEnd', function () { called = true })
    var callback = function () { if (!called) $($el).trigger($.support.transition.end) }
    setTimeout(callback, duration)
    return this
  }

  $(function () {
    $.support.transition = transitionEnd()

    if (!$.support.transition) return

    $.event.special.bsTransitionEnd = {
      bindType: $.support.transition.end,
      delegateType: $.support.transition.end,
      handle: function (e) {
        if ($(e.target).is(this)) return e.handleObj.handler.apply(this, arguments)
      }
    }
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: alert.js v3.3.5
 * http://getbootstrap.com/javascript/#alerts
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // ALERT CLASS DEFINITION
  // ======================

  var dismiss = '[data-dismiss="alert"]'
  var Alert   = function (el) {
    $(el).on('click', dismiss, this.close)
  }

  Alert.VERSION = '3.3.5'

  Alert.TRANSITION_DURATION = 150

  Alert.prototype.close = function (e) {
    var $this    = $(this)
    var selector = $this.attr('data-target')

    if (!selector) {
      selector = $this.attr('href')
      selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
    }

    var $parent = $(selector)

    if (e) e.preventDefault()

    if (!$parent.length) {
      $parent = $this.closest('.alert')
    }

    $parent.trigger(e = $.Event('close.bs.alert'))

    if (e.isDefaultPrevented()) return

    $parent.removeClass('in')

    function removeElement() {
      // detach from parent, fire event then clean up data
      $parent.detach().trigger('closed.bs.alert').remove()
    }

    $.support.transition && $parent.hasClass('fade') ?
      $parent
        .one('bsTransitionEnd', removeElement)
        .emulateTransitionEnd(Alert.TRANSITION_DURATION) :
      removeElement()
  }


  // ALERT PLUGIN DEFINITION
  // =======================

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this)
      var data  = $this.data('bs.alert')

      if (!data) $this.data('bs.alert', (data = new Alert(this)))
      if (typeof option == 'string') data[option].call($this)
    })
  }

  var old = $.fn.alert

  $.fn.alert             = Plugin
  $.fn.alert.Constructor = Alert


  // ALERT NO CONFLICT
  // =================

  $.fn.alert.noConflict = function () {
    $.fn.alert = old
    return this
  }


  // ALERT DATA-API
  // ==============

  $(document).on('click.bs.alert.data-api', dismiss, Alert.prototype.close)

}(jQuery);

/* ========================================================================
 * Bootstrap: button.js v3.3.5
 * http://getbootstrap.com/javascript/#buttons
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // BUTTON PUBLIC CLASS DEFINITION
  // ==============================

  var Button = function (element, options) {
    this.$element  = $(element)
    this.options   = $.extend({}, Button.DEFAULTS, options)
    this.isLoading = false
  }

  Button.VERSION  = '3.3.5'

  Button.DEFAULTS = {
    loadingText: 'loading...'
  }

  Button.prototype.setState = function (state) {
    var d    = 'disabled'
    var $el  = this.$element
    var val  = $el.is('input') ? 'val' : 'html'
    var data = $el.data()

    state += 'Text'

    if (data.resetText == null) $el.data('resetText', $el[val]())

    // push to event loop to allow forms to submit
    setTimeout($.proxy(function () {
      $el[val](data[state] == null ? this.options[state] : data[state])

      if (state == 'loadingText') {
        this.isLoading = true
        $el.addClass(d).attr(d, d)
      } else if (this.isLoading) {
        this.isLoading = false
        $el.removeClass(d).removeAttr(d)
      }
    }, this), 0)
  }

  Button.prototype.toggle = function () {
    var changed = true
    var $parent = this.$element.closest('[data-toggle="buttons"]')

    if ($parent.length) {
      var $input = this.$element.find('input')
      if ($input.prop('type') == 'radio') {
        if ($input.prop('checked')) changed = false
        $parent.find('.active').removeClass('active')
        this.$element.addClass('active')
      } else if ($input.prop('type') == 'checkbox') {
        if (($input.prop('checked')) !== this.$element.hasClass('active')) changed = false
        this.$element.toggleClass('active')
      }
      $input.prop('checked', this.$element.hasClass('active'))
      if (changed) $input.trigger('change')
    } else {
      this.$element.attr('aria-pressed', !this.$element.hasClass('active'))
      this.$element.toggleClass('active')
    }
  }


  // BUTTON PLUGIN DEFINITION
  // ========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.button')
      var options = typeof option == 'object' && option

      if (!data) $this.data('bs.button', (data = new Button(this, options)))

      if (option == 'toggle') data.toggle()
      else if (option) data.setState(option)
    })
  }

  var old = $.fn.button

  $.fn.button             = Plugin
  $.fn.button.Constructor = Button


  // BUTTON NO CONFLICT
  // ==================

  $.fn.button.noConflict = function () {
    $.fn.button = old
    return this
  }


  // BUTTON DATA-API
  // ===============

  $(document)
    .on('click.bs.button.data-api', '[data-toggle^="button"]', function (e) {
      var $btn = $(e.target)
      if (!$btn.hasClass('btn')) $btn = $btn.closest('.btn')
      Plugin.call($btn, 'toggle')
      if (!($(e.target).is('input[type="radio"]') || $(e.target).is('input[type="checkbox"]'))) e.preventDefault()
    })
    .on('focus.bs.button.data-api blur.bs.button.data-api', '[data-toggle^="button"]', function (e) {
      $(e.target).closest('.btn').toggleClass('focus', /^focus(in)?$/.test(e.type))
    })

}(jQuery);

/* ========================================================================
 * Bootstrap: carousel.js v3.3.5
 * http://getbootstrap.com/javascript/#carousel
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // CAROUSEL CLASS DEFINITION
  // =========================

  var Carousel = function (element, options) {
    this.$element    = $(element)
    this.$indicators = this.$element.find('.carousel-indicators')
    this.options     = options
    this.paused      = null
    this.sliding     = null
    this.interval    = null
    this.$active     = null
    this.$items      = null

    this.options.keyboard && this.$element.on('keydown.bs.carousel', $.proxy(this.keydown, this))

    this.options.pause == 'hover' && !('ontouchstart' in document.documentElement) && this.$element
      .on('mouseenter.bs.carousel', $.proxy(this.pause, this))
      .on('mouseleave.bs.carousel', $.proxy(this.cycle, this))
  }

  Carousel.VERSION  = '3.3.5'

  Carousel.TRANSITION_DURATION = 600

  Carousel.DEFAULTS = {
    interval: 5000,
    pause: 'hover',
    wrap: true,
    keyboard: true
  }

  Carousel.prototype.keydown = function (e) {
    if (/input|textarea/i.test(e.target.tagName)) return
    switch (e.which) {
      case 37: this.prev(); break
      case 39: this.next(); break
      default: return
    }

    e.preventDefault()
  }

  Carousel.prototype.cycle = function (e) {
    e || (this.paused = false)

    this.interval && clearInterval(this.interval)

    this.options.interval
      && !this.paused
      && (this.interval = setInterval($.proxy(this.next, this), this.options.interval))

    return this
  }

  Carousel.prototype.getItemIndex = function (item) {
    this.$items = item.parent().children('.item')
    return this.$items.index(item || this.$active)
  }

  Carousel.prototype.getItemForDirection = function (direction, active) {
    var activeIndex = this.getItemIndex(active)
    var willWrap = (direction == 'prev' && activeIndex === 0)
                || (direction == 'next' && activeIndex == (this.$items.length - 1))
    if (willWrap && !this.options.wrap) return active
    var delta = direction == 'prev' ? -1 : 1
    var itemIndex = (activeIndex + delta) % this.$items.length
    return this.$items.eq(itemIndex)
  }

  Carousel.prototype.to = function (pos) {
    var that        = this
    var activeIndex = this.getItemIndex(this.$active = this.$element.find('.item.active'))

    if (pos > (this.$items.length - 1) || pos < 0) return

    if (this.sliding)       return this.$element.one('slid.bs.carousel', function () { that.to(pos) }) // yes, "slid"
    if (activeIndex == pos) return this.pause().cycle()

    return this.slide(pos > activeIndex ? 'next' : 'prev', this.$items.eq(pos))
  }

  Carousel.prototype.pause = function (e) {
    e || (this.paused = true)

    if (this.$element.find('.next, .prev').length && $.support.transition) {
      this.$element.trigger($.support.transition.end)
      this.cycle(true)
    }

    this.interval = clearInterval(this.interval)

    return this
  }

  Carousel.prototype.next = function () {
    if (this.sliding) return
    return this.slide('next')
  }

  Carousel.prototype.prev = function () {
    if (this.sliding) return
    return this.slide('prev')
  }

  Carousel.prototype.slide = function (type, next) {
    var $active   = this.$element.find('.item.active')
    var $next     = next || this.getItemForDirection(type, $active)
    var isCycling = this.interval
    var direction = type == 'next' ? 'left' : 'right'
    var that      = this

    if ($next.hasClass('active')) return (this.sliding = false)

    var relatedTarget = $next[0]
    var slideEvent = $.Event('slide.bs.carousel', {
      relatedTarget: relatedTarget,
      direction: direction
    })
    this.$element.trigger(slideEvent)
    if (slideEvent.isDefaultPrevented()) return

    this.sliding = true

    isCycling && this.pause()

    if (this.$indicators.length) {
      this.$indicators.find('.active').removeClass('active')
      var $nextIndicator = $(this.$indicators.children()[this.getItemIndex($next)])
      $nextIndicator && $nextIndicator.addClass('active')
    }

    var slidEvent = $.Event('slid.bs.carousel', { relatedTarget: relatedTarget, direction: direction }) // yes, "slid"
    if ($.support.transition && this.$element.hasClass('slide')) {
      $next.addClass(type)
      $next[0].offsetWidth // force reflow
      $active.addClass(direction)
      $next.addClass(direction)
      $active
        .one('bsTransitionEnd', function () {
          $next.removeClass([type, direction].join(' ')).addClass('active')
          $active.removeClass(['active', direction].join(' '))
          that.sliding = false
          setTimeout(function () {
            that.$element.trigger(slidEvent)
          }, 0)
        })
        .emulateTransitionEnd(Carousel.TRANSITION_DURATION)
    } else {
      $active.removeClass('active')
      $next.addClass('active')
      this.sliding = false
      this.$element.trigger(slidEvent)
    }

    isCycling && this.cycle()

    return this
  }


  // CAROUSEL PLUGIN DEFINITION
  // ==========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.carousel')
      var options = $.extend({}, Carousel.DEFAULTS, $this.data(), typeof option == 'object' && option)
      var action  = typeof option == 'string' ? option : options.slide

      if (!data) $this.data('bs.carousel', (data = new Carousel(this, options)))
      if (typeof option == 'number') data.to(option)
      else if (action) data[action]()
      else if (options.interval) data.pause().cycle()
    })
  }

  var old = $.fn.carousel

  $.fn.carousel             = Plugin
  $.fn.carousel.Constructor = Carousel


  // CAROUSEL NO CONFLICT
  // ====================

  $.fn.carousel.noConflict = function () {
    $.fn.carousel = old
    return this
  }


  // CAROUSEL DATA-API
  // =================

  var clickHandler = function (e) {
    var href
    var $this   = $(this)
    var $target = $($this.attr('data-target') || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '')) // strip for ie7
    if (!$target.hasClass('carousel')) return
    var options = $.extend({}, $target.data(), $this.data())
    var slideIndex = $this.attr('data-slide-to')
    if (slideIndex) options.interval = false

    Plugin.call($target, options)

    if (slideIndex) {
      $target.data('bs.carousel').to(slideIndex)
    }

    e.preventDefault()
  }

  $(document)
    .on('click.bs.carousel.data-api', '[data-slide]', clickHandler)
    .on('click.bs.carousel.data-api', '[data-slide-to]', clickHandler)

  $(window).on('load', function () {
    $('[data-ride="carousel"]').each(function () {
      var $carousel = $(this)
      Plugin.call($carousel, $carousel.data())
    })
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: collapse.js v3.3.5
 * http://getbootstrap.com/javascript/#collapse
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // COLLAPSE PUBLIC CLASS DEFINITION
  // ================================

  var Collapse = function (element, options) {
    this.$element      = $(element)
    this.options       = $.extend({}, Collapse.DEFAULTS, options)
    this.$trigger      = $('[data-toggle="collapse"][href="#' + element.id + '"],' +
                           '[data-toggle="collapse"][data-target="#' + element.id + '"]')
    this.transitioning = null

    if (this.options.parent) {
      this.$parent = this.getParent()
    } else {
      this.addAriaAndCollapsedClass(this.$element, this.$trigger)
    }

    if (this.options.toggle) this.toggle()
  }

  Collapse.VERSION  = '3.3.5'

  Collapse.TRANSITION_DURATION = 350

  Collapse.DEFAULTS = {
    toggle: true
  }

  Collapse.prototype.dimension = function () {
    var hasWidth = this.$element.hasClass('width')
    return hasWidth ? 'width' : 'height'
  }

  Collapse.prototype.show = function () {
    if (this.transitioning || this.$element.hasClass('in')) return

    var activesData
    var actives = this.$parent && this.$parent.children('.panel').children('.in, .collapsing')

    if (actives && actives.length) {
      activesData = actives.data('bs.collapse')
      if (activesData && activesData.transitioning) return
    }

    var startEvent = $.Event('show.bs.collapse')
    this.$element.trigger(startEvent)
    if (startEvent.isDefaultPrevented()) return

    if (actives && actives.length) {
      Plugin.call(actives, 'hide')
      activesData || actives.data('bs.collapse', null)
    }

    var dimension = this.dimension()

    this.$element
      .removeClass('collapse')
      .addClass('collapsing')[dimension](0)
      .attr('aria-expanded', true)

    this.$trigger
      .removeClass('collapsed')
      .attr('aria-expanded', true)

    this.transitioning = 1

    var complete = function () {
      this.$element
        .removeClass('collapsing')
        .addClass('collapse in')[dimension]('')
      this.transitioning = 0
      this.$element
        .trigger('shown.bs.collapse')
    }

    if (!$.support.transition) return complete.call(this)

    var scrollSize = $.camelCase(['scroll', dimension].join('-'))

    this.$element
      .one('bsTransitionEnd', $.proxy(complete, this))
      .emulateTransitionEnd(Collapse.TRANSITION_DURATION)[dimension](this.$element[0][scrollSize])
  }

  Collapse.prototype.hide = function () {
    if (this.transitioning || !this.$element.hasClass('in')) return

    var startEvent = $.Event('hide.bs.collapse')
    this.$element.trigger(startEvent)
    if (startEvent.isDefaultPrevented()) return

    var dimension = this.dimension()

    this.$element[dimension](this.$element[dimension]())[0].offsetHeight

    this.$element
      .addClass('collapsing')
      .removeClass('collapse in')
      .attr('aria-expanded', false)

    this.$trigger
      .addClass('collapsed')
      .attr('aria-expanded', false)

    this.transitioning = 1

    var complete = function () {
      this.transitioning = 0
      this.$element
        .removeClass('collapsing')
        .addClass('collapse')
        .trigger('hidden.bs.collapse')
    }

    if (!$.support.transition) return complete.call(this)

    this.$element
      [dimension](0)
      .one('bsTransitionEnd', $.proxy(complete, this))
      .emulateTransitionEnd(Collapse.TRANSITION_DURATION)
  }

  Collapse.prototype.toggle = function () {
    this[this.$element.hasClass('in') ? 'hide' : 'show']()
  }

  Collapse.prototype.getParent = function () {
    return $(this.options.parent)
      .find('[data-toggle="collapse"][data-parent="' + this.options.parent + '"]')
      .each($.proxy(function (i, element) {
        var $element = $(element)
        this.addAriaAndCollapsedClass(getTargetFromTrigger($element), $element)
      }, this))
      .end()
  }

  Collapse.prototype.addAriaAndCollapsedClass = function ($element, $trigger) {
    var isOpen = $element.hasClass('in')

    $element.attr('aria-expanded', isOpen)
    $trigger
      .toggleClass('collapsed', !isOpen)
      .attr('aria-expanded', isOpen)
  }

  function getTargetFromTrigger($trigger) {
    var href
    var target = $trigger.attr('data-target')
      || (href = $trigger.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '') // strip for ie7

    return $(target)
  }


  // COLLAPSE PLUGIN DEFINITION
  // ==========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.collapse')
      var options = $.extend({}, Collapse.DEFAULTS, $this.data(), typeof option == 'object' && option)

      if (!data && options.toggle && /show|hide/.test(option)) options.toggle = false
      if (!data) $this.data('bs.collapse', (data = new Collapse(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.collapse

  $.fn.collapse             = Plugin
  $.fn.collapse.Constructor = Collapse


  // COLLAPSE NO CONFLICT
  // ====================

  $.fn.collapse.noConflict = function () {
    $.fn.collapse = old
    return this
  }


  // COLLAPSE DATA-API
  // =================

  $(document).on('click.bs.collapse.data-api', '[data-toggle="collapse"]', function (e) {
    var $this   = $(this)

    if (!$this.attr('data-target')) e.preventDefault()

    var $target = getTargetFromTrigger($this)
    var data    = $target.data('bs.collapse')
    var option  = data ? 'toggle' : $this.data()

    Plugin.call($target, option)
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: dropdown.js v3.3.5
 * http://getbootstrap.com/javascript/#dropdowns
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // DROPDOWN CLASS DEFINITION
  // =========================

  var backdrop = '.dropdown-backdrop'
  var toggle   = '[data-toggle="dropdown"]'
  var Dropdown = function (element) {
    $(element).on('click.bs.dropdown', this.toggle)
  }

  Dropdown.VERSION = '3.3.5'

  function getParent($this) {
    var selector = $this.attr('data-target')

    if (!selector) {
      selector = $this.attr('href')
      selector = selector && /#[A-Za-z]/.test(selector) && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
    }

    var $parent = selector && $(selector)

    return $parent && $parent.length ? $parent : $this.parent()
  }

  function clearMenus(e) {
    if (e && e.which === 3) return
    $(backdrop).remove()
    $(toggle).each(function () {
      var $this         = $(this)
      var $parent       = getParent($this)
      var relatedTarget = { relatedTarget: this }

      if (!$parent.hasClass('open')) return

      if (e && e.type == 'click' && /input|textarea/i.test(e.target.tagName) && $.contains($parent[0], e.target)) return

      $parent.trigger(e = $.Event('hide.bs.dropdown', relatedTarget))

      if (e.isDefaultPrevented()) return

      $this.attr('aria-expanded', 'false')
      $parent.removeClass('open').trigger('hidden.bs.dropdown', relatedTarget)
    })
  }

  Dropdown.prototype.toggle = function (e) {
    var $this = $(this)

    if ($this.is('.disabled, :disabled')) return

    var $parent  = getParent($this)
    var isActive = $parent.hasClass('open')

    clearMenus()

    if (!isActive) {
      if ('ontouchstart' in document.documentElement && !$parent.closest('.navbar-nav').length) {
        // if mobile we use a backdrop because click events don't delegate
        $(document.createElement('div'))
          .addClass('dropdown-backdrop')
          .insertAfter($(this))
          .on('click', clearMenus)
      }

      var relatedTarget = { relatedTarget: this }
      $parent.trigger(e = $.Event('show.bs.dropdown', relatedTarget))

      if (e.isDefaultPrevented()) return

      $this
        .trigger('focus')
        .attr('aria-expanded', 'true')

      $parent
        .toggleClass('open')
        .trigger('shown.bs.dropdown', relatedTarget)
    }

    return false
  }

  Dropdown.prototype.keydown = function (e) {
    if (!/(38|40|27|32)/.test(e.which) || /input|textarea/i.test(e.target.tagName)) return

    var $this = $(this)

    e.preventDefault()
    e.stopPropagation()

    if ($this.is('.disabled, :disabled')) return

    var $parent  = getParent($this)
    var isActive = $parent.hasClass('open')

    if (!isActive && e.which != 27 || isActive && e.which == 27) {
      if (e.which == 27) $parent.find(toggle).trigger('focus')
      return $this.trigger('click')
    }

    var desc = ' li:not(.disabled):visible a'
    var $items = $parent.find('.dropdown-menu' + desc)

    if (!$items.length) return

    var index = $items.index(e.target)

    if (e.which == 38 && index > 0)                 index--         // up
    if (e.which == 40 && index < $items.length - 1) index++         // down
    if (!~index)                                    index = 0

    $items.eq(index).trigger('focus')
  }


  // DROPDOWN PLUGIN DEFINITION
  // ==========================

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this)
      var data  = $this.data('bs.dropdown')

      if (!data) $this.data('bs.dropdown', (data = new Dropdown(this)))
      if (typeof option == 'string') data[option].call($this)
    })
  }

  var old = $.fn.dropdown

  $.fn.dropdown             = Plugin
  $.fn.dropdown.Constructor = Dropdown


  // DROPDOWN NO CONFLICT
  // ====================

  $.fn.dropdown.noConflict = function () {
    $.fn.dropdown = old
    return this
  }


  // APPLY TO STANDARD DROPDOWN ELEMENTS
  // ===================================

  $(document)
    .on('click.bs.dropdown.data-api', clearMenus)
    .on('click.bs.dropdown.data-api', '.dropdown form', function (e) { e.stopPropagation() })
    .on('click.bs.dropdown.data-api', toggle, Dropdown.prototype.toggle)
    .on('keydown.bs.dropdown.data-api', toggle, Dropdown.prototype.keydown)
    .on('keydown.bs.dropdown.data-api', '.dropdown-menu', Dropdown.prototype.keydown)

}(jQuery);

/* ========================================================================
 * Bootstrap: modal.js v3.3.5
 * http://getbootstrap.com/javascript/#modals
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // MODAL CLASS DEFINITION
  // ======================

  var Modal = function (element, options) {
    this.options             = options
    this.$body               = $(document.body)
    this.$element            = $(element)
    this.$dialog             = this.$element.find('.modal-dialog')
    this.$backdrop           = null
    this.isShown             = null
    this.originalBodyPad     = null
    this.scrollbarWidth      = 0
    this.ignoreBackdropClick = false

    if (this.options.remote) {
      this.$element
        .find('.modal-content')
        .load(this.options.remote, $.proxy(function () {
          this.$element.trigger('loaded.bs.modal')
        }, this))
    }
  }

  Modal.VERSION  = '3.3.5'

  Modal.TRANSITION_DURATION = 300
  Modal.BACKDROP_TRANSITION_DURATION = 150

  Modal.DEFAULTS = {
    backdrop: true,
    keyboard: true,
    show: true
  }

  Modal.prototype.toggle = function (_relatedTarget) {
    return this.isShown ? this.hide() : this.show(_relatedTarget)
  }

  Modal.prototype.show = function (_relatedTarget) {
    var that = this
    var e    = $.Event('show.bs.modal', { relatedTarget: _relatedTarget })

    this.$element.trigger(e)

    if (this.isShown || e.isDefaultPrevented()) return

    this.isShown = true

    this.checkScrollbar()
    this.setScrollbar()
    this.$body.addClass('modal-open')

    this.escape()
    this.resize()

    this.$element.on('click.dismiss.bs.modal', '[data-dismiss="modal"]', $.proxy(this.hide, this))

    this.$dialog.on('mousedown.dismiss.bs.modal', function () {
      that.$element.one('mouseup.dismiss.bs.modal', function (e) {
        if ($(e.target).is(that.$element)) that.ignoreBackdropClick = true
      })
    })

    this.backdrop(function () {
      var transition = $.support.transition && that.$element.hasClass('fade')

      if (!that.$element.parent().length) {
        that.$element.appendTo(that.$body) // don't move modals dom position
      }

      that.$element
        .show()
        .scrollTop(0)

      that.adjustDialog()

      if (transition) {
        that.$element[0].offsetWidth // force reflow
      }

      that.$element.addClass('in')

      that.enforceFocus()

      var e = $.Event('shown.bs.modal', { relatedTarget: _relatedTarget })

      transition ?
        that.$dialog // wait for modal to slide in
          .one('bsTransitionEnd', function () {
            that.$element.trigger('focus').trigger(e)
          })
          .emulateTransitionEnd(Modal.TRANSITION_DURATION) :
        that.$element.trigger('focus').trigger(e)
    })
  }

  Modal.prototype.hide = function (e) {
    if (e) e.preventDefault()

    e = $.Event('hide.bs.modal')

    this.$element.trigger(e)

    if (!this.isShown || e.isDefaultPrevented()) return

    this.isShown = false

    this.escape()
    this.resize()

    $(document).off('focusin.bs.modal')

    this.$element
      .removeClass('in')
      .off('click.dismiss.bs.modal')
      .off('mouseup.dismiss.bs.modal')

    this.$dialog.off('mousedown.dismiss.bs.modal')

    $.support.transition && this.$element.hasClass('fade') ?
      this.$element
        .one('bsTransitionEnd', $.proxy(this.hideModal, this))
        .emulateTransitionEnd(Modal.TRANSITION_DURATION) :
      this.hideModal()
  }

  Modal.prototype.enforceFocus = function () {
    $(document)
      .off('focusin.bs.modal') // guard against infinite focus loop
      .on('focusin.bs.modal', $.proxy(function (e) {
        if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
          this.$element.trigger('focus')
        }
      }, this))
  }

  Modal.prototype.escape = function () {
    if (this.isShown && this.options.keyboard) {
      this.$element.on('keydown.dismiss.bs.modal', $.proxy(function (e) {
        e.which == 27 && this.hide()
      }, this))
    } else if (!this.isShown) {
      this.$element.off('keydown.dismiss.bs.modal')
    }
  }

  Modal.prototype.resize = function () {
    if (this.isShown) {
      $(window).on('resize.bs.modal', $.proxy(this.handleUpdate, this))
    } else {
      $(window).off('resize.bs.modal')
    }
  }

  Modal.prototype.hideModal = function () {
    var that = this
    this.$element.hide()
    this.backdrop(function () {
      that.$body.removeClass('modal-open')
      that.resetAdjustments()
      that.resetScrollbar()
      that.$element.trigger('hidden.bs.modal')
    })
  }

  Modal.prototype.removeBackdrop = function () {
    this.$backdrop && this.$backdrop.remove()
    this.$backdrop = null
  }

  Modal.prototype.backdrop = function (callback) {
    var that = this
    var animate = this.$element.hasClass('fade') ? 'fade' : ''

    if (this.isShown && this.options.backdrop) {
      var doAnimate = $.support.transition && animate

      this.$backdrop = $(document.createElement('div'))
        .addClass('modal-backdrop ' + animate)
        .appendTo(this.$body)

      this.$element.on('click.dismiss.bs.modal', $.proxy(function (e) {
        if (this.ignoreBackdropClick) {
          this.ignoreBackdropClick = false
          return
        }
        if (e.target !== e.currentTarget) return
        this.options.backdrop == 'static'
          ? this.$element[0].focus()
          : this.hide()
      }, this))

      if (doAnimate) this.$backdrop[0].offsetWidth // force reflow

      this.$backdrop.addClass('in')

      if (!callback) return

      doAnimate ?
        this.$backdrop
          .one('bsTransitionEnd', callback)
          .emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) :
        callback()

    } else if (!this.isShown && this.$backdrop) {
      this.$backdrop.removeClass('in')

      var callbackRemove = function () {
        that.removeBackdrop()
        callback && callback()
      }
      $.support.transition && this.$element.hasClass('fade') ?
        this.$backdrop
          .one('bsTransitionEnd', callbackRemove)
          .emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) :
        callbackRemove()

    } else if (callback) {
      callback()
    }
  }

  // these following methods are used to handle overflowing modals

  Modal.prototype.handleUpdate = function () {
    this.adjustDialog()
  }

  Modal.prototype.adjustDialog = function () {
    var modalIsOverflowing = this.$element[0].scrollHeight > document.documentElement.clientHeight

    this.$element.css({
      paddingLeft:  !this.bodyIsOverflowing && modalIsOverflowing ? this.scrollbarWidth : '',
      paddingRight: this.bodyIsOverflowing && !modalIsOverflowing ? this.scrollbarWidth : ''
    })
  }

  Modal.prototype.resetAdjustments = function () {
    this.$element.css({
      paddingLeft: '',
      paddingRight: ''
    })
  }

  Modal.prototype.checkScrollbar = function () {
    var fullWindowWidth = window.innerWidth
    if (!fullWindowWidth) { // workaround for missing window.innerWidth in IE8
      var documentElementRect = document.documentElement.getBoundingClientRect()
      fullWindowWidth = documentElementRect.right - Math.abs(documentElementRect.left)
    }
    this.bodyIsOverflowing = document.body.clientWidth < fullWindowWidth
    this.scrollbarWidth = this.measureScrollbar()
  }

  Modal.prototype.setScrollbar = function () {
    var bodyPad = parseInt((this.$body.css('padding-right') || 0), 10)
    this.originalBodyPad = document.body.style.paddingRight || ''
    if (this.bodyIsOverflowing) this.$body.css('padding-right', bodyPad + this.scrollbarWidth)
  }

  Modal.prototype.resetScrollbar = function () {
    this.$body.css('padding-right', this.originalBodyPad)
  }

  Modal.prototype.measureScrollbar = function () { // thx walsh
    var scrollDiv = document.createElement('div')
    scrollDiv.className = 'modal-scrollbar-measure'
    this.$body.append(scrollDiv)
    var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth
    this.$body[0].removeChild(scrollDiv)
    return scrollbarWidth
  }


  // MODAL PLUGIN DEFINITION
  // =======================

  function Plugin(option, _relatedTarget) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.modal')
      var options = $.extend({}, Modal.DEFAULTS, $this.data(), typeof option == 'object' && option)

      if (!data) $this.data('bs.modal', (data = new Modal(this, options)))
      if (typeof option == 'string') data[option](_relatedTarget)
      else if (options.show) data.show(_relatedTarget)
    })
  }

  var old = $.fn.modal

  $.fn.modal             = Plugin
  $.fn.modal.Constructor = Modal


  // MODAL NO CONFLICT
  // =================

  $.fn.modal.noConflict = function () {
    $.fn.modal = old
    return this
  }


  // MODAL DATA-API
  // ==============

  $(document).on('click.bs.modal.data-api', '[data-toggle="modal"]', function (e) {
    var $this   = $(this)
    var href    = $this.attr('href')
    var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) // strip for ie7
    var option  = $target.data('bs.modal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

    if ($this.is('a')) e.preventDefault()

    $target.one('show.bs.modal', function (showEvent) {
      if (showEvent.isDefaultPrevented()) return // only register focus restorer if modal will actually get shown
      $target.one('hidden.bs.modal', function () {
        $this.is(':visible') && $this.trigger('focus')
      })
    })
    Plugin.call($target, option, this)
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: tooltip.js v3.3.5
 * http://getbootstrap.com/javascript/#tooltip
 * Inspired by the original jQuery.tipsy by Jason Frame
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // TOOLTIP PUBLIC CLASS DEFINITION
  // ===============================

  var Tooltip = function (element, options) {
    this.type       = null
    this.options    = null
    this.enabled    = null
    this.timeout    = null
    this.hoverState = null
    this.$element   = null
    this.inState    = null

    this.init('tooltip', element, options)
  }

  Tooltip.VERSION  = '3.3.5'

  Tooltip.TRANSITION_DURATION = 150

  Tooltip.DEFAULTS = {
    animation: true,
    placement: 'top',
    selector: false,
    template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
    trigger: 'hover focus',
    title: '',
    delay: 0,
    html: false,
    container: false,
    viewport: {
      selector: 'body',
      padding: 0
    }
  }

  Tooltip.prototype.init = function (type, element, options) {
    this.enabled   = true
    this.type      = type
    this.$element  = $(element)
    this.options   = this.getOptions(options)
    this.$viewport = this.options.viewport && $($.isFunction(this.options.viewport) ? this.options.viewport.call(this, this.$element) : (this.options.viewport.selector || this.options.viewport))
    this.inState   = { click: false, hover: false, focus: false }

    if (this.$element[0] instanceof document.constructor && !this.options.selector) {
      throw new Error('`selector` option must be specified when initializing ' + this.type + ' on the window.document object!')
    }

    var triggers = this.options.trigger.split(' ')

    for (var i = triggers.length; i--;) {
      var trigger = triggers[i]

      if (trigger == 'click') {
        this.$element.on('click.' + this.type, this.options.selector, $.proxy(this.toggle, this))
      } else if (trigger != 'manual') {
        var eventIn  = trigger == 'hover' ? 'mouseenter' : 'focusin'
        var eventOut = trigger == 'hover' ? 'mouseleave' : 'focusout'

        this.$element.on(eventIn  + '.' + this.type, this.options.selector, $.proxy(this.enter, this))
        this.$element.on(eventOut + '.' + this.type, this.options.selector, $.proxy(this.leave, this))
      }
    }

    this.options.selector ?
      (this._options = $.extend({}, this.options, { trigger: 'manual', selector: '' })) :
      this.fixTitle()
  }

  Tooltip.prototype.getDefaults = function () {
    return Tooltip.DEFAULTS
  }

  Tooltip.prototype.getOptions = function (options) {
    options = $.extend({}, this.getDefaults(), this.$element.data(), options)

    if (options.delay && typeof options.delay == 'number') {
      options.delay = {
        show: options.delay,
        hide: options.delay
      }
    }

    return options
  }

  Tooltip.prototype.getDelegateOptions = function () {
    var options  = {}
    var defaults = this.getDefaults()

    this._options && $.each(this._options, function (key, value) {
      if (defaults[key] != value) options[key] = value
    })

    return options
  }

  Tooltip.prototype.enter = function (obj) {
    var self = obj instanceof this.constructor ?
      obj : $(obj.currentTarget).data('bs.' + this.type)

    if (!self) {
      self = new this.constructor(obj.currentTarget, this.getDelegateOptions())
      $(obj.currentTarget).data('bs.' + this.type, self)
    }

    if (obj instanceof $.Event) {
      self.inState[obj.type == 'focusin' ? 'focus' : 'hover'] = true
    }

    if (self.tip().hasClass('in') || self.hoverState == 'in') {
      self.hoverState = 'in'
      return
    }

    clearTimeout(self.timeout)

    self.hoverState = 'in'

    if (!self.options.delay || !self.options.delay.show) return self.show()

    self.timeout = setTimeout(function () {
      if (self.hoverState == 'in') self.show()
    }, self.options.delay.show)
  }

  Tooltip.prototype.isInStateTrue = function () {
    for (var key in this.inState) {
      if (this.inState[key]) return true
    }

    return false
  }

  Tooltip.prototype.leave = function (obj) {
    var self = obj instanceof this.constructor ?
      obj : $(obj.currentTarget).data('bs.' + this.type)

    if (!self) {
      self = new this.constructor(obj.currentTarget, this.getDelegateOptions())
      $(obj.currentTarget).data('bs.' + this.type, self)
    }

    if (obj instanceof $.Event) {
      self.inState[obj.type == 'focusout' ? 'focus' : 'hover'] = false
    }

    if (self.isInStateTrue()) return

    clearTimeout(self.timeout)

    self.hoverState = 'out'

    if (!self.options.delay || !self.options.delay.hide) return self.hide()

    self.timeout = setTimeout(function () {
      if (self.hoverState == 'out') self.hide()
    }, self.options.delay.hide)
  }

  Tooltip.prototype.show = function () {
    var e = $.Event('show.bs.' + this.type)

    if (this.hasContent() && this.enabled) {
      this.$element.trigger(e)

      var inDom = $.contains(this.$element[0].ownerDocument.documentElement, this.$element[0])
      if (e.isDefaultPrevented() || !inDom) return
      var that = this

      var $tip = this.tip()

      var tipId = this.getUID(this.type)

      this.setContent()
      $tip.attr('id', tipId)
      this.$element.attr('aria-describedby', tipId)

      if (this.options.animation) $tip.addClass('fade')

      var placement = typeof this.options.placement == 'function' ?
        this.options.placement.call(this, $tip[0], this.$element[0]) :
        this.options.placement

      var autoToken = /\s?auto?\s?/i
      var autoPlace = autoToken.test(placement)
      if (autoPlace) placement = placement.replace(autoToken, '') || 'top'

      $tip
        .detach()
        .css({ top: 0, left: 0, display: 'block' })
        .addClass(placement)
        .data('bs.' + this.type, this)

      this.options.container ? $tip.appendTo(this.options.container) : $tip.insertAfter(this.$element)
      this.$element.trigger('inserted.bs.' + this.type)

      var pos          = this.getPosition()
      var actualWidth  = $tip[0].offsetWidth
      var actualHeight = $tip[0].offsetHeight

      if (autoPlace) {
        var orgPlacement = placement
        var viewportDim = this.getPosition(this.$viewport)

        placement = placement == 'bottom' && pos.bottom + actualHeight > viewportDim.bottom ? 'top'    :
                    placement == 'top'    && pos.top    - actualHeight < viewportDim.top    ? 'bottom' :
                    placement == 'right'  && pos.right  + actualWidth  > viewportDim.width  ? 'left'   :
                    placement == 'left'   && pos.left   - actualWidth  < viewportDim.left   ? 'right'  :
                    placement

        $tip
          .removeClass(orgPlacement)
          .addClass(placement)
      }

      var calculatedOffset = this.getCalculatedOffset(placement, pos, actualWidth, actualHeight)

      this.applyPlacement(calculatedOffset, placement)

      var complete = function () {
        var prevHoverState = that.hoverState
        that.$element.trigger('shown.bs.' + that.type)
        that.hoverState = null

        if (prevHoverState == 'out') that.leave(that)
      }

      $.support.transition && this.$tip.hasClass('fade') ?
        $tip
          .one('bsTransitionEnd', complete)
          .emulateTransitionEnd(Tooltip.TRANSITION_DURATION) :
        complete()
    }
  }

  Tooltip.prototype.applyPlacement = function (offset, placement) {
    var $tip   = this.tip()
    var width  = $tip[0].offsetWidth
    var height = $tip[0].offsetHeight

    // manually read margins because getBoundingClientRect includes difference
    var marginTop = parseInt($tip.css('margin-top'), 10)
    var marginLeft = parseInt($tip.css('margin-left'), 10)

    // we must check for NaN for ie 8/9
    if (isNaN(marginTop))  marginTop  = 0
    if (isNaN(marginLeft)) marginLeft = 0

    offset.top  += marginTop
    offset.left += marginLeft

    // $.fn.offset doesn't round pixel values
    // so we use setOffset directly with our own function B-0
    $.offset.setOffset($tip[0], $.extend({
      using: function (props) {
        $tip.css({
          top: Math.round(props.top),
          left: Math.round(props.left)
        })
      }
    }, offset), 0)

    $tip.addClass('in')

    // check to see if placing tip in new offset caused the tip to resize itself
    var actualWidth  = $tip[0].offsetWidth
    var actualHeight = $tip[0].offsetHeight

    if (placement == 'top' && actualHeight != height) {
      offset.top = offset.top + height - actualHeight
    }

    var delta = this.getViewportAdjustedDelta(placement, offset, actualWidth, actualHeight)

    if (delta.left) offset.left += delta.left
    else offset.top += delta.top

    var isVertical          = /top|bottom/.test(placement)
    var arrowDelta          = isVertical ? delta.left * 2 - width + actualWidth : delta.top * 2 - height + actualHeight
    var arrowOffsetPosition = isVertical ? 'offsetWidth' : 'offsetHeight'

    $tip.offset(offset)
    this.replaceArrow(arrowDelta, $tip[0][arrowOffsetPosition], isVertical)
  }

  Tooltip.prototype.replaceArrow = function (delta, dimension, isVertical) {
    this.arrow()
      .css(isVertical ? 'left' : 'top', 50 * (1 - delta / dimension) + '%')
      .css(isVertical ? 'top' : 'left', '')
  }

  Tooltip.prototype.setContent = function () {
    var $tip  = this.tip()
    var title = this.getTitle()

    $tip.find('.tooltip-inner')[this.options.html ? 'html' : 'text'](title)
    $tip.removeClass('fade in top bottom left right')
  }

  Tooltip.prototype.hide = function (callback) {
    var that = this
    var $tip = $(this.$tip)
    var e    = $.Event('hide.bs.' + this.type)

    function complete() {
      if (that.hoverState != 'in') $tip.detach()
      that.$element
        .removeAttr('aria-describedby')
        .trigger('hidden.bs.' + that.type)
      callback && callback()
    }

    this.$element.trigger(e)

    if (e.isDefaultPrevented()) return

    $tip.removeClass('in')

    $.support.transition && $tip.hasClass('fade') ?
      $tip
        .one('bsTransitionEnd', complete)
        .emulateTransitionEnd(Tooltip.TRANSITION_DURATION) :
      complete()

    this.hoverState = null

    return this
  }

  Tooltip.prototype.fixTitle = function () {
    var $e = this.$element
    if ($e.attr('title') || typeof $e.attr('data-original-title') != 'string') {
      $e.attr('data-original-title', $e.attr('title') || '').attr('title', '')
    }
  }

  Tooltip.prototype.hasContent = function () {
    return this.getTitle()
  }

  Tooltip.prototype.getPosition = function ($element) {
    $element   = $element || this.$element

    var el     = $element[0]
    var isBody = el.tagName == 'BODY'

    var elRect    = el.getBoundingClientRect()
    if (elRect.width == null) {
      // width and height are missing in IE8, so compute them manually; see https://github.com/twbs/bootstrap/issues/14093
      elRect = $.extend({}, elRect, { width: elRect.right - elRect.left, height: elRect.bottom - elRect.top })
    }
    var elOffset  = isBody ? { top: 0, left: 0 } : $element.offset()
    var scroll    = { scroll: isBody ? document.documentElement.scrollTop || document.body.scrollTop : $element.scrollTop() }
    var outerDims = isBody ? { width: $(window).width(), height: $(window).height() } : null

    return $.extend({}, elRect, scroll, outerDims, elOffset)
  }

  Tooltip.prototype.getCalculatedOffset = function (placement, pos, actualWidth, actualHeight) {
    return placement == 'bottom' ? { top: pos.top + pos.height,   left: pos.left + pos.width / 2 - actualWidth / 2 } :
           placement == 'top'    ? { top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2 } :
           placement == 'left'   ? { top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth } :
        /* placement == 'right' */ { top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width }

  }

  Tooltip.prototype.getViewportAdjustedDelta = function (placement, pos, actualWidth, actualHeight) {
    var delta = { top: 0, left: 0 }
    if (!this.$viewport) return delta

    var viewportPadding = this.options.viewport && this.options.viewport.padding || 0
    var viewportDimensions = this.getPosition(this.$viewport)

    if (/right|left/.test(placement)) {
      var topEdgeOffset    = pos.top - viewportPadding - viewportDimensions.scroll
      var bottomEdgeOffset = pos.top + viewportPadding - viewportDimensions.scroll + actualHeight
      if (topEdgeOffset < viewportDimensions.top) { // top overflow
        delta.top = viewportDimensions.top - topEdgeOffset
      } else if (bottomEdgeOffset > viewportDimensions.top + viewportDimensions.height) { // bottom overflow
        delta.top = viewportDimensions.top + viewportDimensions.height - bottomEdgeOffset
      }
    } else {
      var leftEdgeOffset  = pos.left - viewportPadding
      var rightEdgeOffset = pos.left + viewportPadding + actualWidth
      if (leftEdgeOffset < viewportDimensions.left) { // left overflow
        delta.left = viewportDimensions.left - leftEdgeOffset
      } else if (rightEdgeOffset > viewportDimensions.right) { // right overflow
        delta.left = viewportDimensions.left + viewportDimensions.width - rightEdgeOffset
      }
    }

    return delta
  }

  Tooltip.prototype.getTitle = function () {
    var title
    var $e = this.$element
    var o  = this.options

    title = $e.attr('data-original-title')
      || (typeof o.title == 'function' ? o.title.call($e[0]) :  o.title)

    return title
  }

  Tooltip.prototype.getUID = function (prefix) {
    do prefix += ~~(Math.random() * 1000000)
    while (document.getElementById(prefix))
    return prefix
  }

  Tooltip.prototype.tip = function () {
    if (!this.$tip) {
      this.$tip = $(this.options.template)
      if (this.$tip.length != 1) {
        throw new Error(this.type + ' `template` option must consist of exactly 1 top-level element!')
      }
    }
    return this.$tip
  }

  Tooltip.prototype.arrow = function () {
    return (this.$arrow = this.$arrow || this.tip().find('.tooltip-arrow'))
  }

  Tooltip.prototype.enable = function () {
    this.enabled = true
  }

  Tooltip.prototype.disable = function () {
    this.enabled = false
  }

  Tooltip.prototype.toggleEnabled = function () {
    this.enabled = !this.enabled
  }

  Tooltip.prototype.toggle = function (e) {
    var self = this
    if (e) {
      self = $(e.currentTarget).data('bs.' + this.type)
      if (!self) {
        self = new this.constructor(e.currentTarget, this.getDelegateOptions())
        $(e.currentTarget).data('bs.' + this.type, self)
      }
    }

    if (e) {
      self.inState.click = !self.inState.click
      if (self.isInStateTrue()) self.enter(self)
      else self.leave(self)
    } else {
      self.tip().hasClass('in') ? self.leave(self) : self.enter(self)
    }
  }

  Tooltip.prototype.destroy = function () {
    var that = this
    clearTimeout(this.timeout)
    this.hide(function () {
      that.$element.off('.' + that.type).removeData('bs.' + that.type)
      if (that.$tip) {
        that.$tip.detach()
      }
      that.$tip = null
      that.$arrow = null
      that.$viewport = null
    })
  }


  // TOOLTIP PLUGIN DEFINITION
  // =========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.tooltip')
      var options = typeof option == 'object' && option

      if (!data && /destroy|hide/.test(option)) return
      if (!data) $this.data('bs.tooltip', (data = new Tooltip(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.tooltip

  $.fn.tooltip             = Plugin
  $.fn.tooltip.Constructor = Tooltip


  // TOOLTIP NO CONFLICT
  // ===================

  $.fn.tooltip.noConflict = function () {
    $.fn.tooltip = old
    return this
  }

}(jQuery);

/* ========================================================================
 * Bootstrap: popover.js v3.3.5
 * http://getbootstrap.com/javascript/#popovers
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // POPOVER PUBLIC CLASS DEFINITION
  // ===============================

  var Popover = function (element, options) {
    this.init('popover', element, options)
  }

  if (!$.fn.tooltip) throw new Error('Popover requires tooltip.js')

  Popover.VERSION  = '3.3.5'

  Popover.DEFAULTS = $.extend({}, $.fn.tooltip.Constructor.DEFAULTS, {
    placement: 'right',
    trigger: 'click',
    content: '',
    template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
  })


  // NOTE: POPOVER EXTENDS tooltip.js
  // ================================

  Popover.prototype = $.extend({}, $.fn.tooltip.Constructor.prototype)

  Popover.prototype.constructor = Popover

  Popover.prototype.getDefaults = function () {
    return Popover.DEFAULTS
  }

  Popover.prototype.setContent = function () {
    var $tip    = this.tip()
    var title   = this.getTitle()
    var content = this.getContent()

    $tip.find('.popover-title')[this.options.html ? 'html' : 'text'](title)
    $tip.find('.popover-content').children().detach().end()[ // we use append for html objects to maintain js events
      this.options.html ? (typeof content == 'string' ? 'html' : 'append') : 'text'
    ](content)

    $tip.removeClass('fade top bottom left right in')

    // IE8 doesn't accept hiding via the `:empty` pseudo selector, we have to do
    // this manually by checking the contents.
    if (!$tip.find('.popover-title').html()) $tip.find('.popover-title').hide()
  }

  Popover.prototype.hasContent = function () {
    return this.getTitle() || this.getContent()
  }

  Popover.prototype.getContent = function () {
    var $e = this.$element
    var o  = this.options

    return $e.attr('data-content')
      || (typeof o.content == 'function' ?
            o.content.call($e[0]) :
            o.content)
  }

  Popover.prototype.arrow = function () {
    return (this.$arrow = this.$arrow || this.tip().find('.arrow'))
  }


  // POPOVER PLUGIN DEFINITION
  // =========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.popover')
      var options = typeof option == 'object' && option

      if (!data && /destroy|hide/.test(option)) return
      if (!data) $this.data('bs.popover', (data = new Popover(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.popover

  $.fn.popover             = Plugin
  $.fn.popover.Constructor = Popover


  // POPOVER NO CONFLICT
  // ===================

  $.fn.popover.noConflict = function () {
    $.fn.popover = old
    return this
  }

}(jQuery);

/* ========================================================================
 * Bootstrap: scrollspy.js v3.3.5
 * http://getbootstrap.com/javascript/#scrollspy
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // SCROLLSPY CLASS DEFINITION
  // ==========================

  function ScrollSpy(element, options) {
    this.$body          = $(document.body)
    this.$scrollElement = $(element).is(document.body) ? $(window) : $(element)
    this.options        = $.extend({}, ScrollSpy.DEFAULTS, options)
    this.selector       = (this.options.target || '') + ' .nav li > a'
    this.offsets        = []
    this.targets        = []
    this.activeTarget   = null
    this.scrollHeight   = 0

    this.$scrollElement.on('scroll.bs.scrollspy', $.proxy(this.process, this))
    this.refresh()
    this.process()
  }

  ScrollSpy.VERSION  = '3.3.5'

  ScrollSpy.DEFAULTS = {
    offset: 10
  }

  ScrollSpy.prototype.getScrollHeight = function () {
    return this.$scrollElement[0].scrollHeight || Math.max(this.$body[0].scrollHeight, document.documentElement.scrollHeight)
  }

  ScrollSpy.prototype.refresh = function () {
    var that          = this
    var offsetMethod  = 'offset'
    var offsetBase    = 0

    this.offsets      = []
    this.targets      = []
    this.scrollHeight = this.getScrollHeight()

    if (!$.isWindow(this.$scrollElement[0])) {
      offsetMethod = 'position'
      offsetBase   = this.$scrollElement.scrollTop()
    }

    this.$body
      .find(this.selector)
      .map(function () {
        var $el   = $(this)
        var href  = $el.data('target') || $el.attr('href')
        var $href = /^#./.test(href) && $(href)

        return ($href
          && $href.length
          && $href.is(':visible')
          && [[$href[offsetMethod]().top + offsetBase, href]]) || null
      })
      .sort(function (a, b) { return a[0] - b[0] })
      .each(function () {
        that.offsets.push(this[0])
        that.targets.push(this[1])
      })
  }

  ScrollSpy.prototype.process = function () {
    var scrollTop    = this.$scrollElement.scrollTop() + this.options.offset
    var scrollHeight = this.getScrollHeight()
    var maxScroll    = this.options.offset + scrollHeight - this.$scrollElement.height()
    var offsets      = this.offsets
    var targets      = this.targets
    var activeTarget = this.activeTarget
    var i

    if (this.scrollHeight != scrollHeight) {
      this.refresh()
    }

    if (scrollTop >= maxScroll) {
      return activeTarget != (i = targets[targets.length - 1]) && this.activate(i)
    }

    if (activeTarget && scrollTop < offsets[0]) {
      this.activeTarget = null
      return this.clear()
    }

    for (i = offsets.length; i--;) {
      activeTarget != targets[i]
        && scrollTop >= offsets[i]
        && (offsets[i + 1] === undefined || scrollTop < offsets[i + 1])
        && this.activate(targets[i])
    }
  }

  ScrollSpy.prototype.activate = function (target) {
    this.activeTarget = target

    this.clear()

    var selector = this.selector +
      '[data-target="' + target + '"],' +
      this.selector + '[href="' + target + '"]'

    var active = $(selector)
      .parents('li')
      .addClass('active')

    if (active.parent('.dropdown-menu').length) {
      active = active
        .closest('li.dropdown')
        .addClass('active')
    }

    active.trigger('activate.bs.scrollspy')
  }

  ScrollSpy.prototype.clear = function () {
    $(this.selector)
      .parentsUntil(this.options.target, '.active')
      .removeClass('active')
  }


  // SCROLLSPY PLUGIN DEFINITION
  // ===========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.scrollspy')
      var options = typeof option == 'object' && option

      if (!data) $this.data('bs.scrollspy', (data = new ScrollSpy(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.scrollspy

  $.fn.scrollspy             = Plugin
  $.fn.scrollspy.Constructor = ScrollSpy


  // SCROLLSPY NO CONFLICT
  // =====================

  $.fn.scrollspy.noConflict = function () {
    $.fn.scrollspy = old
    return this
  }


  // SCROLLSPY DATA-API
  // ==================

  $(window).on('load.bs.scrollspy.data-api', function () {
    $('[data-spy="scroll"]').each(function () {
      var $spy = $(this)
      Plugin.call($spy, $spy.data())
    })
  })

}(jQuery);

/* ========================================================================
 * Bootstrap: tab.js v3.3.5
 * http://getbootstrap.com/javascript/#tabs
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // TAB CLASS DEFINITION
  // ====================

  var Tab = function (element) {
    // jscs:disable requireDollarBeforejQueryAssignment
    this.element = $(element)
    // jscs:enable requireDollarBeforejQueryAssignment
  }

  Tab.VERSION = '3.3.5'

  Tab.TRANSITION_DURATION = 150

  Tab.prototype.show = function () {
    var $this    = this.element
    var $ul      = $this.closest('ul:not(.dropdown-menu)')
    var selector = $this.data('target')

    if (!selector) {
      selector = $this.attr('href')
      selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
    }

    if ($this.parent('li').hasClass('active')) return

    var $previous = $ul.find('.active:last a')
    var hideEvent = $.Event('hide.bs.tab', {
      relatedTarget: $this[0]
    })
    var showEvent = $.Event('show.bs.tab', {
      relatedTarget: $previous[0]
    })

    $previous.trigger(hideEvent)
    $this.trigger(showEvent)

    if (showEvent.isDefaultPrevented() || hideEvent.isDefaultPrevented()) return

    var $target = $(selector)

    this.activate($this.closest('li'), $ul)
    this.activate($target, $target.parent(), function () {
      $previous.trigger({
        type: 'hidden.bs.tab',
        relatedTarget: $this[0]
      })
      $this.trigger({
        type: 'shown.bs.tab',
        relatedTarget: $previous[0]
      })
    })
  }

  Tab.prototype.activate = function (element, container, callback) {
    var $active    = container.find('> .active')
    var transition = callback
      && $.support.transition
      && ($active.length && $active.hasClass('fade') || !!container.find('> .fade').length)

    function next() {
      $active
        .removeClass('active')
        .find('> .dropdown-menu > .active')
          .removeClass('active')
        .end()
        .find('[data-toggle="tab"]')
          .attr('aria-expanded', false)

      element
        .addClass('active')
        .find('[data-toggle="tab"]')
          .attr('aria-expanded', true)

      if (transition) {
        element[0].offsetWidth // reflow for transition
        element.addClass('in')
      } else {
        element.removeClass('fade')
      }

      if (element.parent('.dropdown-menu').length) {
        element
          .closest('li.dropdown')
            .addClass('active')
          .end()
          .find('[data-toggle="tab"]')
            .attr('aria-expanded', true)
      }

      callback && callback()
    }

    $active.length && transition ?
      $active
        .one('bsTransitionEnd', next)
        .emulateTransitionEnd(Tab.TRANSITION_DURATION) :
      next()

    $active.removeClass('in')
  }


  // TAB PLUGIN DEFINITION
  // =====================

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this)
      var data  = $this.data('bs.tab')

      if (!data) $this.data('bs.tab', (data = new Tab(this)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.tab

  $.fn.tab             = Plugin
  $.fn.tab.Constructor = Tab


  // TAB NO CONFLICT
  // ===============

  $.fn.tab.noConflict = function () {
    $.fn.tab = old
    return this
  }


  // TAB DATA-API
  // ============

  var clickHandler = function (e) {
    e.preventDefault()
    Plugin.call($(this), 'show')
  }

  $(document)
    .on('click.bs.tab.data-api', '[data-toggle="tab"]', clickHandler)
    .on('click.bs.tab.data-api', '[data-toggle="pill"]', clickHandler)

}(jQuery);

/* ========================================================================
 * Bootstrap: affix.js v3.3.5
 * http://getbootstrap.com/javascript/#affix
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // AFFIX CLASS DEFINITION
  // ======================

  var Affix = function (element, options) {
    this.options = $.extend({}, Affix.DEFAULTS, options)

    this.$target = $(this.options.target)
      .on('scroll.bs.affix.data-api', $.proxy(this.checkPosition, this))
      .on('click.bs.affix.data-api',  $.proxy(this.checkPositionWithEventLoop, this))

    this.$element     = $(element)
    this.affixed      = null
    this.unpin        = null
    this.pinnedOffset = null

    this.checkPosition()
  }

  Affix.VERSION  = '3.3.5'

  Affix.RESET    = 'affix affix-top affix-bottom'

  Affix.DEFAULTS = {
    offset: 0,
    target: window
  }

  Affix.prototype.getState = function (scrollHeight, height, offsetTop, offsetBottom) {
    var scrollTop    = this.$target.scrollTop()
    var position     = this.$element.offset()
    var targetHeight = this.$target.height()

    if (offsetTop != null && this.affixed == 'top') return scrollTop < offsetTop ? 'top' : false

    if (this.affixed == 'bottom') {
      if (offsetTop != null) return (scrollTop + this.unpin <= position.top) ? false : 'bottom'
      return (scrollTop + targetHeight <= scrollHeight - offsetBottom) ? false : 'bottom'
    }

    var initializing   = this.affixed == null
    var colliderTop    = initializing ? scrollTop : position.top
    var colliderHeight = initializing ? targetHeight : height

    if (offsetTop != null && scrollTop <= offsetTop) return 'top'
    if (offsetBottom != null && (colliderTop + colliderHeight >= scrollHeight - offsetBottom)) return 'bottom'

    return false
  }

  Affix.prototype.getPinnedOffset = function () {
    if (this.pinnedOffset) return this.pinnedOffset
    this.$element.removeClass(Affix.RESET).addClass('affix')
    var scrollTop = this.$target.scrollTop()
    var position  = this.$element.offset()
    return (this.pinnedOffset = position.top - scrollTop)
  }

  Affix.prototype.checkPositionWithEventLoop = function () {
    setTimeout($.proxy(this.checkPosition, this), 1)
  }

  Affix.prototype.checkPosition = function () {
    if (!this.$element.is(':visible')) return

    var height       = this.$element.height()
    var offset       = this.options.offset
    var offsetTop    = offset.top
    var offsetBottom = offset.bottom
    var scrollHeight = Math.max($(document).height(), $(document.body).height())

    if (typeof offset != 'object')         offsetBottom = offsetTop = offset
    if (typeof offsetTop == 'function')    offsetTop    = offset.top(this.$element)
    if (typeof offsetBottom == 'function') offsetBottom = offset.bottom(this.$element)

    var affix = this.getState(scrollHeight, height, offsetTop, offsetBottom)

    if (this.affixed != affix) {
      if (this.unpin != null) this.$element.css('top', '')

      var affixType = 'affix' + (affix ? '-' + affix : '')
      var e         = $.Event(affixType + '.bs.affix')

      this.$element.trigger(e)

      if (e.isDefaultPrevented()) return

      this.affixed = affix
      this.unpin = affix == 'bottom' ? this.getPinnedOffset() : null

      this.$element
        .removeClass(Affix.RESET)
        .addClass(affixType)
        .trigger(affixType.replace('affix', 'affixed') + '.bs.affix')
    }

    if (affix == 'bottom') {
      this.$element.offset({
        top: scrollHeight - height - offsetBottom
      })
    }
  }


  // AFFIX PLUGIN DEFINITION
  // =======================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.affix')
      var options = typeof option == 'object' && option

      if (!data) $this.data('bs.affix', (data = new Affix(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.affix

  $.fn.affix             = Plugin
  $.fn.affix.Constructor = Affix


  // AFFIX NO CONFLICT
  // =================

  $.fn.affix.noConflict = function () {
    $.fn.affix = old
    return this
  }


  // AFFIX DATA-API
  // ==============

  $(window).on('load', function () {
    $('[data-spy="affix"]').each(function () {
      var $spy = $(this)
      var data = $spy.data()

      data.offset = data.offset || {}

      if (data.offsetBottom != null) data.offset.bottom = data.offsetBottom
      if (data.offsetTop    != null) data.offset.top    = data.offsetTop

      Plugin.call($spy, data)
    })
  })

}(jQuery);

(function($, undefined) {

/**
 * Unobtrusive scripting adapter for jQuery
 * https://github.com/rails/jquery-ujs
 *
 * Requires jQuery 1.8.0 or later.
 *
 * Released under the MIT license
 *
 */

  // Cut down on the number of issues from people inadvertently including jquery_ujs twice
  // by detecting and raising an error when it happens.
  'use strict';

  if ( $.rails !== undefined ) {
    $.error('jquery-ujs has already been loaded!');
  }

  // Shorthand to make it a little easier to call public rails functions from within rails.js
  var rails;
  var $document = $(document);

  $.rails = rails = {
    // Link elements bound by jquery-ujs
    linkClickSelector: 'a[data-confirm], a[data-method], a[data-remote], a[data-disable-with], a[data-disable]',

    // Button elements bound by jquery-ujs
    buttonClickSelector: 'button[data-remote]:not(form button), button[data-confirm]:not(form button)',

    // Select elements bound by jquery-ujs
    inputChangeSelector: 'select[data-remote], input[data-remote], textarea[data-remote]',

    // Form elements bound by jquery-ujs
    formSubmitSelector: 'form',

    // Form input elements bound by jquery-ujs
    formInputClickSelector: 'form input[type=submit], form input[type=image], form button[type=submit], form button:not([type]), input[type=submit][form], input[type=image][form], button[type=submit][form], button[form]:not([type])',

    // Form input elements disabled during form submission
    disableSelector: 'input[data-disable-with]:enabled, button[data-disable-with]:enabled, textarea[data-disable-with]:enabled, input[data-disable]:enabled, button[data-disable]:enabled, textarea[data-disable]:enabled',

    // Form input elements re-enabled after form submission
    enableSelector: 'input[data-disable-with]:disabled, button[data-disable-with]:disabled, textarea[data-disable-with]:disabled, input[data-disable]:disabled, button[data-disable]:disabled, textarea[data-disable]:disabled',

    // Form required input elements
    requiredInputSelector: 'input[name][required]:not([disabled]),textarea[name][required]:not([disabled])',

    // Form file input elements
    fileInputSelector: 'input[type=file]',

    // Link onClick disable selector with possible reenable after remote submission
    linkDisableSelector: 'a[data-disable-with], a[data-disable]',

    // Button onClick disable selector with possible reenable after remote submission
    buttonDisableSelector: 'button[data-remote][data-disable-with], button[data-remote][data-disable]',

    // Up-to-date Cross-Site Request Forgery token
    csrfToken: function() {
     return $('meta[name=csrf-token]').attr('content');
    },

    // URL param that must contain the CSRF token
    csrfParam: function() {
     return $('meta[name=csrf-param]').attr('content');
    },

    // Make sure that every Ajax request sends the CSRF token
    CSRFProtection: function(xhr) {
      var token = rails.csrfToken();
      if (token) xhr.setRequestHeader('X-CSRF-Token', token);
    },

    // making sure that all forms have actual up-to-date token(cached forms contain old one)
    refreshCSRFTokens: function(){
      $('form input[name="' + rails.csrfParam() + '"]').val(rails.csrfToken());
    },

    // Triggers an event on an element and returns false if the event result is false
    fire: function(obj, name, data) {
      var event = $.Event(name);
      obj.trigger(event, data);
      return event.result !== false;
    },

    // Default confirm dialog, may be overridden with custom confirm dialog in $.rails.confirm
    confirm: function(message) {
      return confirm(message);
    },

    // Default ajax function, may be overridden with custom function in $.rails.ajax
    ajax: function(options) {
      return $.ajax(options);
    },

    // Default way to get an element's href. May be overridden at $.rails.href.
    href: function(element) {
      return element[0].href;
    },

    // Checks "data-remote" if true to handle the request through a XHR request.
    isRemote: function(element) {
      return element.data('remote') !== undefined && element.data('remote') !== false;
    },

    // Submits "remote" forms and links with ajax
    handleRemote: function(element) {
      var method, url, data, withCredentials, dataType, options;

      if (rails.fire(element, 'ajax:before')) {
        withCredentials = element.data('with-credentials') || null;
        dataType = element.data('type') || ($.ajaxSettings && $.ajaxSettings.dataType);

        if (element.is('form')) {
          method = element.attr('method');
          url = element.attr('action');
          data = element.serializeArray();
          // memoized value from clicked submit button
          var button = element.data('ujs:submit-button');
          if (button) {
            data.push(button);
            element.data('ujs:submit-button', null);
          }
        } else if (element.is(rails.inputChangeSelector)) {
          method = element.data('method');
          url = element.data('url');
          data = element.serialize();
          if (element.data('params')) data = data + '&' + element.data('params');
        } else if (element.is(rails.buttonClickSelector)) {
          method = element.data('method') || 'get';
          url = element.data('url');
          data = element.serialize();
          if (element.data('params')) data = data + '&' + element.data('params');
        } else {
          method = element.data('method');
          url = rails.href(element);
          data = element.data('params') || null;
        }

        options = {
          type: method || 'GET', data: data, dataType: dataType,
          // stopping the "ajax:beforeSend" event will cancel the ajax request
          beforeSend: function(xhr, settings) {
            if (settings.dataType === undefined) {
              xhr.setRequestHeader('accept', '*/*;q=0.5, ' + settings.accepts.script);
            }
            if (rails.fire(element, 'ajax:beforeSend', [xhr, settings])) {
              element.trigger('ajax:send', xhr);
            } else {
              return false;
            }
          },
          success: function(data, status, xhr) {
            element.trigger('ajax:success', [data, status, xhr]);
          },
          complete: function(xhr, status) {
            element.trigger('ajax:complete', [xhr, status]);
          },
          error: function(xhr, status, error) {
            element.trigger('ajax:error', [xhr, status, error]);
          },
          crossDomain: rails.isCrossDomain(url)
        };

        // There is no withCredentials for IE6-8 when
        // "Enable native XMLHTTP support" is disabled
        if (withCredentials) {
          options.xhrFields = {
            withCredentials: withCredentials
          };
        }

        // Only pass url to `ajax` options if not blank
        if (url) { options.url = url; }

        return rails.ajax(options);
      } else {
        return false;
      }
    },

    // Determines if the request is a cross domain request.
    isCrossDomain: function(url) {
      var originAnchor = document.createElement('a');
      originAnchor.href = location.href;
      var urlAnchor = document.createElement('a');

      try {
        urlAnchor.href = url;
        // This is a workaround to a IE bug.
        urlAnchor.href = urlAnchor.href;

        // Make sure that the browser parses the URL and that the protocols and hosts match.
        return !urlAnchor.protocol || !urlAnchor.host ||
          (originAnchor.protocol + '//' + originAnchor.host !==
            urlAnchor.protocol + '//' + urlAnchor.host);
      } catch (e) {
        // If there is an error parsing the URL, assume it is crossDomain.
        return true;
      }
    },

    // Handles "data-method" on links such as:
    // <a href="/users/5" data-method="delete" rel="nofollow" data-confirm="Are you sure?">Delete</a>
    handleMethod: function(link) {
      var href = rails.href(link),
        method = link.data('method'),
        target = link.attr('target'),
        csrfToken = rails.csrfToken(),
        csrfParam = rails.csrfParam(),
        form = $('<form method="post" action="' + href + '"></form>'),
        metadataInput = '<input name="_method" value="' + method + '" type="hidden" />';

      if (csrfParam !== undefined && csrfToken !== undefined && !rails.isCrossDomain(href)) {
        metadataInput += '<input name="' + csrfParam + '" value="' + csrfToken + '" type="hidden" />';
      }

      if (target) { form.attr('target', target); }

      form.hide().append(metadataInput).appendTo('body');
      form.submit();
    },

    // Helper function that returns form elements that match the specified CSS selector
    // If form is actually a "form" element this will return associated elements outside the from that have
    // the html form attribute set
    formElements: function(form, selector) {
      return form.is('form') ? $(form[0].elements).filter(selector) : form.find(selector);
    },

    /* Disables form elements:
      - Caches element value in 'ujs:enable-with' data store
      - Replaces element text with value of 'data-disable-with' attribute
      - Sets disabled property to true
    */
    disableFormElements: function(form) {
      rails.formElements(form, rails.disableSelector).each(function() {
        rails.disableFormElement($(this));
      });
    },

    disableFormElement: function(element) {
      var method, replacement;

      method = element.is('button') ? 'html' : 'val';
      replacement = element.data('disable-with');

      element.data('ujs:enable-with', element[method]());
      if (replacement !== undefined) {
        element[method](replacement);
      }

      element.prop('disabled', true);
    },

    /* Re-enables disabled form elements:
      - Replaces element text with cached value from 'ujs:enable-with' data store (created in `disableFormElements`)
      - Sets disabled property to false
    */
    enableFormElements: function(form) {
      rails.formElements(form, rails.enableSelector).each(function() {
        rails.enableFormElement($(this));
      });
    },

    enableFormElement: function(element) {
      var method = element.is('button') ? 'html' : 'val';
      if (element.data('ujs:enable-with')) element[method](element.data('ujs:enable-with'));
      element.prop('disabled', false);
    },

   /* For 'data-confirm' attribute:
      - Fires `confirm` event
      - Shows the confirmation dialog
      - Fires the `confirm:complete` event

      Returns `true` if no function stops the chain and user chose yes; `false` otherwise.
      Attaching a handler to the element's `confirm` event that returns a `falsy` value cancels the confirmation dialog.
      Attaching a handler to the element's `confirm:complete` event that returns a `falsy` value makes this function
      return false. The `confirm:complete` event is fired whether or not the user answered true or false to the dialog.
   */
    allowAction: function(element) {
      var message = element.data('confirm'),
          answer = false, callback;
      if (!message) { return true; }

      if (rails.fire(element, 'confirm')) {
        try {
          answer = rails.confirm(message);
        } catch (e) {
          (console.error || console.log).call(console, e.stack || e);
        }
        callback = rails.fire(element, 'confirm:complete', [answer]);
      }
      return answer && callback;
    },

    // Helper function which checks for blank inputs in a form that match the specified CSS selector
    blankInputs: function(form, specifiedSelector, nonBlank) {
      var inputs = $(), input, valueToCheck,
          selector = specifiedSelector || 'input,textarea',
          allInputs = form.find(selector);

      allInputs.each(function() {
        input = $(this);
        valueToCheck = input.is('input[type=checkbox],input[type=radio]') ? input.is(':checked') : !!input.val();
        if (valueToCheck === nonBlank) {

          // Don't count unchecked required radio if other radio with same name is checked
          if (input.is('input[type=radio]') && allInputs.filter('input[type=radio]:checked[name="' + input.attr('name') + '"]').length) {
            return true; // Skip to next input
          }

          inputs = inputs.add(input);
        }
      });
      return inputs.length ? inputs : false;
    },

    // Helper function which checks for non-blank inputs in a form that match the specified CSS selector
    nonBlankInputs: function(form, specifiedSelector) {
      return rails.blankInputs(form, specifiedSelector, true); // true specifies nonBlank
    },

    // Helper function, needed to provide consistent behavior in IE
    stopEverything: function(e) {
      $(e.target).trigger('ujs:everythingStopped');
      e.stopImmediatePropagation();
      return false;
    },

    //  replace element's html with the 'data-disable-with' after storing original html
    //  and prevent clicking on it
    disableElement: function(element) {
      var replacement = element.data('disable-with');

      element.data('ujs:enable-with', element.html()); // store enabled state
      if (replacement !== undefined) {
        element.html(replacement);
      }

      element.bind('click.railsDisable', function(e) { // prevent further clicking
        return rails.stopEverything(e);
      });
    },

    // restore element to its original state which was disabled by 'disableElement' above
    enableElement: function(element) {
      if (element.data('ujs:enable-with') !== undefined) {
        element.html(element.data('ujs:enable-with')); // set to old enabled state
        element.removeData('ujs:enable-with'); // clean up cache
      }
      element.unbind('click.railsDisable'); // enable element
    }
  };

  if (rails.fire($document, 'rails:attachBindings')) {

    $.ajaxPrefilter(function(options, originalOptions, xhr){ if ( !options.crossDomain ) { rails.CSRFProtection(xhr); }});

    // This event works the same as the load event, except that it fires every
    // time the page is loaded.
    //
    // See https://github.com/rails/jquery-ujs/issues/357
    // See https://developer.mozilla.org/en-US/docs/Using_Firefox_1.5_caching
    $(window).on('pageshow.rails', function () {
      $($.rails.enableSelector).each(function () {
        var element = $(this);

        if (element.data('ujs:enable-with')) {
          $.rails.enableFormElement(element);
        }
      });

      $($.rails.linkDisableSelector).each(function () {
        var element = $(this);

        if (element.data('ujs:enable-with')) {
          $.rails.enableElement(element);
        }
      });
    });

    $document.delegate(rails.linkDisableSelector, 'ajax:complete', function() {
        rails.enableElement($(this));
    });

    $document.delegate(rails.buttonDisableSelector, 'ajax:complete', function() {
        rails.enableFormElement($(this));
    });

    $document.delegate(rails.linkClickSelector, 'click.rails', function(e) {
      var link = $(this), method = link.data('method'), data = link.data('params'), metaClick = e.metaKey || e.ctrlKey;
      if (!rails.allowAction(link)) return rails.stopEverything(e);

      if (!metaClick && link.is(rails.linkDisableSelector)) rails.disableElement(link);

      if (rails.isRemote(link)) {
        if (metaClick && (!method || method === 'GET') && !data) { return true; }

        var handleRemote = rails.handleRemote(link);
        // response from rails.handleRemote() will either be false or a deferred object promise.
        if (handleRemote === false) {
          rails.enableElement(link);
        } else {
          handleRemote.fail( function() { rails.enableElement(link); } );
        }
        return false;

      } else if (method) {
        rails.handleMethod(link);
        return false;
      }
    });

    $document.delegate(rails.buttonClickSelector, 'click.rails', function(e) {
      var button = $(this);

      if (!rails.allowAction(button) || !rails.isRemote(button)) return rails.stopEverything(e);

      if (button.is(rails.buttonDisableSelector)) rails.disableFormElement(button);

      var handleRemote = rails.handleRemote(button);
      // response from rails.handleRemote() will either be false or a deferred object promise.
      if (handleRemote === false) {
        rails.enableFormElement(button);
      } else {
        handleRemote.fail( function() { rails.enableFormElement(button); } );
      }
      return false;
    });

    $document.delegate(rails.inputChangeSelector, 'change.rails', function(e) {
      var link = $(this);
      if (!rails.allowAction(link) || !rails.isRemote(link)) return rails.stopEverything(e);

      rails.handleRemote(link);
      return false;
    });

    $document.delegate(rails.formSubmitSelector, 'submit.rails', function(e) {
      var form = $(this),
        remote = rails.isRemote(form),
        blankRequiredInputs,
        nonBlankFileInputs;

      if (!rails.allowAction(form)) return rails.stopEverything(e);

      // skip other logic when required values are missing or file upload is present
      if (form.attr('novalidate') === undefined) {
        blankRequiredInputs = rails.blankInputs(form, rails.requiredInputSelector, false);
        if (blankRequiredInputs && rails.fire(form, 'ajax:aborted:required', [blankRequiredInputs])) {
          return rails.stopEverything(e);
        }
      }

      if (remote) {
        nonBlankFileInputs = rails.nonBlankInputs(form, rails.fileInputSelector);
        if (nonBlankFileInputs) {
          // slight timeout so that the submit button gets properly serialized
          // (make it easy for event handler to serialize form without disabled values)
          setTimeout(function(){ rails.disableFormElements(form); }, 13);
          var aborted = rails.fire(form, 'ajax:aborted:file', [nonBlankFileInputs]);

          // re-enable form elements if event bindings return false (canceling normal form submission)
          if (!aborted) { setTimeout(function(){ rails.enableFormElements(form); }, 13); }

          return aborted;
        }

        rails.handleRemote(form);
        return false;

      } else {
        // slight timeout so that the submit button gets properly serialized
        setTimeout(function(){ rails.disableFormElements(form); }, 13);
      }
    });

    $document.delegate(rails.formInputClickSelector, 'click.rails', function(event) {
      var button = $(this);

      if (!rails.allowAction(button)) return rails.stopEverything(event);

      // register the pressed submit button
      var name = button.attr('name'),
        data = name ? {name:name, value:button.val()} : null;

      button.closest('form').data('ujs:submit-button', data);
    });

    $document.delegate(rails.formSubmitSelector, 'ajax:send.rails', function(event) {
      if (this === event.target) rails.disableFormElements($(this));
    });

    $document.delegate(rails.formSubmitSelector, 'ajax:complete.rails', function(event) {
      if (this === event.target) rails.enableFormElements($(this));
    });

    $(function(){
      rails.refreshCSRFTokens();
    });
  }

})( jQuery );

/**
 * sifter.js
 * Copyright (c) 2013 Brian Reavis & contributors
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this
 * file except in compliance with the License. You may obtain a copy of the License at:
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under
 * the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF
 * ANY KIND, either express or implied. See the License for the specific language
 * governing permissions and limitations under the License.
 *
 * @author Brian Reavis <brian@thirdroute.com>
 */

(function(root, factory) {
  if (typeof define === 'function' && define.amd) {
    define('sifter', factory);
  } else if (typeof exports === 'object') {
    module.exports = factory();
  } else {
    root.Sifter = factory();
  }
}(this, function() {

  /**
   * Textually searches arrays and hashes of objects
   * by property (or multiple properties). Designed
   * specifically for autocomplete.
   *
   * @constructor
   * @param {array|object} items
   * @param {object} items
   */
  var Sifter = function(items, settings) {
    this.items = items;
    this.settings = settings || {diacritics: true};
  };

  /**
   * Splits a search string into an array of individual
   * regexps to be used to match results.
   *
   * @param {string} query
   * @returns {array}
   */
  Sifter.prototype.tokenize = function(query) {
    query = trim(String(query || '').toLowerCase());
    if (!query || !query.length) return [];

    var i, n, regex, letter;
    var tokens = [];
    var words = query.split(/ +/);

    for (i = 0, n = words.length; i < n; i++) {
      regex = escape_regex(words[i]);
      if (this.settings.diacritics) {
        for (letter in DIACRITICS) {
          if (DIACRITICS.hasOwnProperty(letter)) {
            regex = regex.replace(new RegExp(letter, 'g'), DIACRITICS[letter]);
          }
        }
      }
      tokens.push({
        string : words[i],
        regex  : new RegExp(regex, 'i')
      });
    }

    return tokens;
  };

  /**
   * Iterates over arrays and hashes.
   *
   * ```
   * this.iterator(this.items, function(item, id) {
   *    // invoked for each item
   * });
   * ```
   *
   * @param {array|object} object
   */
  Sifter.prototype.iterator = function(object, callback) {
    var iterator;
    if (is_array(object)) {
      iterator = Array.prototype.forEach || function(callback) {
        for (var i = 0, n = this.length; i < n; i++) {
          callback(this[i], i, this);
        }
      };
    } else {
      iterator = function(callback) {
        for (var key in this) {
          if (this.hasOwnProperty(key)) {
            callback(this[key], key, this);
          }
        }
      };
    }

    iterator.apply(object, [callback]);
  };

  /**
   * Returns a function to be used to score individual results.
   *
   * Good matches will have a higher score than poor matches.
   * If an item is not a match, 0 will be returned by the function.
   *
   * @param {object|string} search
   * @param {object} options (optional)
   * @returns {function}
   */
  Sifter.prototype.getScoreFunction = function(search, options) {
    var self, fields, tokens, token_count;

    self        = this;
    search      = self.prepareSearch(search, options);
    tokens      = search.tokens;
    fields      = search.options.fields;
    token_count = tokens.length;

    /**
     * Calculates how close of a match the
     * given value is against a search token.
     *
     * @param {mixed} value
     * @param {object} token
     * @return {number}
     */
    var scoreValue = function(value, token) {
      var score, pos;

      if (!value) return 0;
      value = String(value || '');
      pos = value.search(token.regex);
      if (pos === -1) return 0;
      score = token.string.length / value.length;
      if (pos === 0) score += 0.5;
      return score;
    };

    /**
     * Calculates the score of an object
     * against the search query.
     *
     * @param {object} token
     * @param {object} data
     * @return {number}
     */
    var scoreObject = (function() {
      var field_count = fields.length;
      if (!field_count) {
        return function() { return 0; };
      }
      if (field_count === 1) {
        return function(token, data) {
          return scoreValue(data[fields[0]], token);
        };
      }
      return function(token, data) {
        for (var i = 0, sum = 0; i < field_count; i++) {
          sum += scoreValue(data[fields[i]], token);
        }
        return sum / field_count;
      };
    })();

    if (!token_count) {
      return function() { return 0; };
    }
    if (token_count === 1) {
      return function(data) {
        return scoreObject(tokens[0], data);
      };
    }

    if (search.options.conjunction === 'and') {
      return function(data) {
        var score;
        for (var i = 0, sum = 0; i < token_count; i++) {
          score = scoreObject(tokens[i], data);
          if (score <= 0) return 0;
          sum += score;
        }
        return sum / token_count;
      };
    } else {
      return function(data) {
        for (var i = 0, sum = 0; i < token_count; i++) {
          sum += scoreObject(tokens[i], data);
        }
        return sum / token_count;
      };
    }
  };

  /**
   * Returns a function that can be used to compare two
   * results, for sorting purposes. If no sorting should
   * be performed, `null` will be returned.
   *
   * @param {string|object} search
   * @param {object} options
   * @return function(a,b)
   */
  Sifter.prototype.getSortFunction = function(search, options) {
    var i, n, self, field, fields, fields_count, multiplier, multipliers, get_field, implicit_score, sort;

    self   = this;
    search = self.prepareSearch(search, options);
    sort   = (!search.query && options.sort_empty) || options.sort;

    /**
     * Fetches the specified sort field value
     * from a search result item.
     *
     * @param  {string} name
     * @param  {object} result
     * @return {mixed}
     */
    get_field = function(name, result) {
      if (name === '$score') return result.score;
      return self.items[result.id][name];
    };

    // parse options
    fields = [];
    if (sort) {
      for (i = 0, n = sort.length; i < n; i++) {
        if (search.query || sort[i].field !== '$score') {
          fields.push(sort[i]);
        }
      }
    }

    // the "$score" field is implied to be the primary
    // sort field, unless it's manually specified
    if (search.query) {
      implicit_score = true;
      for (i = 0, n = fields.length; i < n; i++) {
        if (fields[i].field === '$score') {
          implicit_score = false;
          break;
        }
      }
      if (implicit_score) {
        fields.unshift({field: '$score', direction: 'desc'});
      }
    } else {
      for (i = 0, n = fields.length; i < n; i++) {
        if (fields[i].field === '$score') {
          fields.splice(i, 1);
          break;
        }
      }
    }

    multipliers = [];
    for (i = 0, n = fields.length; i < n; i++) {
      multipliers.push(fields[i].direction === 'desc' ? -1 : 1);
    }

    // build function
    fields_count = fields.length;
    if (!fields_count) {
      return null;
    } else if (fields_count === 1) {
      field = fields[0].field;
      multiplier = multipliers[0];
      return function(a, b) {
        return multiplier * cmp(
          get_field(field, a),
          get_field(field, b)
        );
      };
    } else {
      return function(a, b) {
        var i, result, a_value, b_value, field;
        for (i = 0; i < fields_count; i++) {
          field = fields[i].field;
          result = multipliers[i] * cmp(
            get_field(field, a),
            get_field(field, b)
          );
          if (result) return result;
        }
        return 0;
      };
    }
  };

  /**
   * Parses a search query and returns an object
   * with tokens and fields ready to be populated
   * with results.
   *
   * @param {string} query
   * @param {object} options
   * @returns {object}
   */
  Sifter.prototype.prepareSearch = function(query, options) {
    if (typeof query === 'object') return query;

    options = extend({}, options);

    var option_fields     = options.fields;
    var option_sort       = options.sort;
    var option_sort_empty = options.sort_empty;

    if (option_fields && !is_array(option_fields)) options.fields = [option_fields];
    if (option_sort && !is_array(option_sort)) options.sort = [option_sort];
    if (option_sort_empty && !is_array(option_sort_empty)) options.sort_empty = [option_sort_empty];

    return {
      options : options,
      query   : String(query || '').toLowerCase(),
      tokens  : this.tokenize(query),
      total   : 0,
      items   : []
    };
  };

  /**
   * Searches through all items and returns a sorted array of matches.
   *
   * The `options` parameter can contain:
   *
   *   - fields {string|array}
   *   - sort {array}
   *   - score {function}
   *   - filter {bool}
   *   - limit {integer}
   *
   * Returns an object containing:
   *
   *   - options {object}
   *   - query {string}
   *   - tokens {array}
   *   - total {int}
   *   - items {array}
   *
   * @param {string} query
   * @param {object} options
   * @returns {object}
   */
  Sifter.prototype.search = function(query, options) {
    var self = this, value, score, search, calculateScore;
    var fn_sort;
    var fn_score;

    search  = this.prepareSearch(query, options);
    options = search.options;
    query   = search.query;

    // generate result scoring function
    fn_score = options.score || self.getScoreFunction(search);

    // perform search and sort
    if (query.length) {
      self.iterator(self.items, function(item, id) {
        score = fn_score(item);
        if (options.filter === false || score > 0) {
          search.items.push({'score': score, 'id': id});
        }
      });
    } else {
      self.iterator(self.items, function(item, id) {
        search.items.push({'score': 1, 'id': id});
      });
    }

    fn_sort = self.getSortFunction(search, options);
    if (fn_sort) search.items.sort(fn_sort);

    // apply limits
    search.total = search.items.length;
    if (typeof options.limit === 'number') {
      search.items = search.items.slice(0, options.limit);
    }

    return search;
  };

  // utilities
  // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

  var cmp = function(a, b) {
    if (typeof a === 'number' && typeof b === 'number') {
      return a > b ? 1 : (a < b ? -1 : 0);
    }
    a = asciifold(String(a || ''));
    b = asciifold(String(b || ''));
    if (a > b) return 1;
    if (b > a) return -1;
    return 0;
  };

  var extend = function(a, b) {
    var i, n, k, object;
    for (i = 1, n = arguments.length; i < n; i++) {
      object = arguments[i];
      if (!object) continue;
      for (k in object) {
        if (object.hasOwnProperty(k)) {
          a[k] = object[k];
        }
      }
    }
    return a;
  };

  var trim = function(str) {
    return (str + '').replace(/^\s+|\s+$|/g, '');
  };

  var escape_regex = function(str) {
    return (str + '').replace(/([.?*+^$[\]\\(){}|-])/g, '\\$1');
  };

  var is_array = Array.isArray || ($ && $.isArray) || function(object) {
    return Object.prototype.toString.call(object) === '[object Array]';
  };

  var DIACRITICS = {
    'a': '[aÀÁÂÃÄÅàáâãäåĀāąĄ]',
    'c': '[cÇçćĆčČ]',
    'd': '[dđĐďĎ]',
    'e': '[eÈÉÊËèéêëěĚĒēęĘ]',
    'i': '[iÌÍÎÏìíîïĪī]',
    'l': '[lłŁ]',
    'n': '[nÑñňŇńŃ]',
    'o': '[oÒÓÔÕÕÖØòóôõöøŌō]',
    'r': '[rřŘ]',
    's': '[sŠšśŚ]',
    't': '[tťŤ]',
    'u': '[uÙÚÛÜùúûüůŮŪū]',
    'y': '[yŸÿýÝ]',
    'z': '[zŽžżŻźŹ]'
  };

  var asciifold = (function() {
    var i, n, k, chunk;
    var foreignletters = '';
    var lookup = {};
    for (k in DIACRITICS) {
      if (DIACRITICS.hasOwnProperty(k)) {
        chunk = DIACRITICS[k].substring(2, DIACRITICS[k].length - 1);
        foreignletters += chunk;
        for (i = 0, n = chunk.length; i < n; i++) {
          lookup[chunk.charAt(i)] = k;
        }
      }
    }
    var regexp = new RegExp('[' +  foreignletters + ']', 'g');
    return function(str) {
      return str.replace(regexp, function(foreignletter) {
        return lookup[foreignletter];
      }).toLowerCase();
    };
  })();


  // export
  // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

  return Sifter;
}));



/**
 * microplugin.js
 * Copyright (c) 2013 Brian Reavis & contributors
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this
 * file except in compliance with the License. You may obtain a copy of the License at:
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under
 * the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF
 * ANY KIND, either express or implied. See the License for the specific language
 * governing permissions and limitations under the License.
 *
 * @author Brian Reavis <brian@thirdroute.com>
 */

(function(root, factory) {
  if (typeof define === 'function' && define.amd) {
    define('microplugin', factory);
  } else if (typeof exports === 'object') {
    module.exports = factory();
  } else {
    root.MicroPlugin = factory();
  }
}(this, function() {
  var MicroPlugin = {};

  MicroPlugin.mixin = function(Interface) {
    Interface.plugins = {};

    /**
     * Initializes the listed plugins (with options).
     * Acceptable formats:
     *
     * List (without options):
     *   ['a', 'b', 'c']
     *
     * List (with options):
     *   [{'name': 'a', options: {}}, {'name': 'b', options: {}}]
     *
     * Hash (with options):
     *   {'a': { ... }, 'b': { ... }, 'c': { ... }}
     *
     * @param {mixed} plugins
     */
    Interface.prototype.initializePlugins = function(plugins) {
      var i, n, key;
      var self  = this;
      var queue = [];

      self.plugins = {
        names     : [],
        settings  : {},
        requested : {},
        loaded    : {}
      };

      if (utils.isArray(plugins)) {
        for (i = 0, n = plugins.length; i < n; i++) {
          if (typeof plugins[i] === 'string') {
            queue.push(plugins[i]);
          } else {
            self.plugins.settings[plugins[i].name] = plugins[i].options;
            queue.push(plugins[i].name);
          }
        }
      } else if (plugins) {
        for (key in plugins) {
          if (plugins.hasOwnProperty(key)) {
            self.plugins.settings[key] = plugins[key];
            queue.push(key);
          }
        }
      }

      while (queue.length) {
        self.require(queue.shift());
      }
    };

    Interface.prototype.loadPlugin = function(name) {
      var self    = this;
      var plugins = self.plugins;
      var plugin  = Interface.plugins[name];

      if (!Interface.plugins.hasOwnProperty(name)) {
        throw new Error('Unable to find "' +  name + '" plugin');
      }

      plugins.requested[name] = true;
      plugins.loaded[name] = plugin.fn.apply(self, [self.plugins.settings[name] || {}]);
      plugins.names.push(name);
    };

    /**
     * Initializes a plugin.
     *
     * @param {string} name
     */
    Interface.prototype.require = function(name) {
      var self = this;
      var plugins = self.plugins;

      if (!self.plugins.loaded.hasOwnProperty(name)) {
        if (plugins.requested[name]) {
          throw new Error('Plugin has circular dependency ("' + name + '")');
        }
        self.loadPlugin(name);
      }

      return plugins.loaded[name];
    };

    /**
     * Registers a plugin.
     *
     * @param {string} name
     * @param {function} fn
     */
    Interface.define = function(name, fn) {
      Interface.plugins[name] = {
        'name' : name,
        'fn'   : fn
      };
    };
  };

  var utils = {
    isArray: Array.isArray || function(vArg) {
      return Object.prototype.toString.call(vArg) === '[object Array]';
    }
  };

  return MicroPlugin;
}));

/**
 * selectize.js (v0.12.1)
 * Copyright (c) 2013–2015 Brian Reavis & contributors
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this
 * file except in compliance with the License. You may obtain a copy of the License at:
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under
 * the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF
 * ANY KIND, either express or implied. See the License for the specific language
 * governing permissions and limitations under the License.
 *
 * @author Brian Reavis <brian@thirdroute.com>
 */

/*jshint curly:false */
/*jshint browser:true */

(function(root, factory) {
  if (typeof define === 'function' && define.amd) {
    define('selectize', ['jquery','sifter','microplugin'], factory);
  } else if (typeof exports === 'object') {
    module.exports = factory(require('jquery'), require('sifter'), require('microplugin'));
  } else {
    root.Selectize = factory(root.jQuery, root.Sifter, root.MicroPlugin);
  }
}(this, function($, Sifter, MicroPlugin) {
  'use strict';

  var highlight = function($element, pattern) {
    if (typeof pattern === 'string' && !pattern.length) return;
    var regex = (typeof pattern === 'string') ? new RegExp(pattern, 'i') : pattern;

    var highlight = function(node) {
      var skip = 0;
      if (node.nodeType === 3) {
        var pos = node.data.search(regex);
        if (pos >= 0 && node.data.length > 0) {
          var match = node.data.match(regex);
          var spannode = document.createElement('span');
          spannode.className = 'highlight';
          var middlebit = node.splitText(pos);
          var endbit = middlebit.splitText(match[0].length);
          var middleclone = middlebit.cloneNode(true);
          spannode.appendChild(middleclone);
          middlebit.parentNode.replaceChild(spannode, middlebit);
          skip = 1;
        }
      } else if (node.nodeType === 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
        for (var i = 0; i < node.childNodes.length; ++i) {
          i += highlight(node.childNodes[i]);
        }
      }
      return skip;
    };

    return $element.each(function() {
      highlight(this);
    });
  };

  var MicroEvent = function() {};
  MicroEvent.prototype = {
    on: function(event, fct){
      this._events = this._events || {};
      this._events[event] = this._events[event] || [];
      this._events[event].push(fct);
    },
    off: function(event, fct){
      var n = arguments.length;
      if (n === 0) return delete this._events;
      if (n === 1) return delete this._events[event];

      this._events = this._events || {};
      if (event in this._events === false) return;
      this._events[event].splice(this._events[event].indexOf(fct), 1);
    },
    trigger: function(event /* , args... */){
      this._events = this._events || {};
      if (event in this._events === false) return;
      for (var i = 0; i < this._events[event].length; i++){
        this._events[event][i].apply(this, Array.prototype.slice.call(arguments, 1));
      }
    }
  };

  /**
   * Mixin will delegate all MicroEvent.js function in the destination object.
   *
   * - MicroEvent.mixin(Foobar) will make Foobar able to use MicroEvent
   *
   * @param {object} the object which will support MicroEvent
   */
  MicroEvent.mixin = function(destObject){
    var props = ['on', 'off', 'trigger'];
    for (var i = 0; i < props.length; i++){
      destObject.prototype[props[i]] = MicroEvent.prototype[props[i]];
    }
  };

  var IS_MAC        = /Mac/.test(navigator.userAgent);

  var KEY_A         = 65;
  var KEY_COMMA     = 188;
  var KEY_RETURN    = 13;
  var KEY_ESC       = 27;
  var KEY_LEFT      = 37;
  var KEY_UP        = 38;
  var KEY_P         = 80;
  var KEY_RIGHT     = 39;
  var KEY_DOWN      = 40;
  var KEY_N         = 78;
  var KEY_BACKSPACE = 8;
  var KEY_DELETE    = 46;
  var KEY_SHIFT     = 16;
  var KEY_CMD       = IS_MAC ? 91 : 17;
  var KEY_CTRL      = IS_MAC ? 18 : 17;
  var KEY_TAB       = 9;

  var TAG_SELECT    = 1;
  var TAG_INPUT     = 2;

  // for now, android support in general is too spotty to support validity
  var SUPPORTS_VALIDITY_API = !/android/i.test(window.navigator.userAgent) && !!document.createElement('form').validity;

  var isset = function(object) {
    return typeof object !== 'undefined';
  };

  /**
   * Converts a scalar to its best string representation
   * for hash keys and HTML attribute values.
   *
   * Transformations:
   *   'str'     -> 'str'
   *   null      -> ''
   *   undefined -> ''
   *   true      -> '1'
   *   false     -> '0'
   *   0         -> '0'
   *   1         -> '1'
   *
   * @param {string} value
   * @returns {string|null}
   */
  var hash_key = function(value) {
    if (typeof value === 'undefined' || value === null) return null;
    if (typeof value === 'boolean') return value ? '1' : '0';
    return value + '';
  };

  /**
   * Escapes a string for use within HTML.
   *
   * @param {string} str
   * @returns {string}
   */
  var escape_html = function(str) {
    return (str + '')
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  };

  /**
   * Escapes "$" characters in replacement strings.
   *
   * @param {string} str
   * @returns {string}
   */
  var escape_replace = function(str) {
    return (str + '').replace(/\$/g, '$$$$');
  };

  var hook = {};

  /**
   * Wraps `method` on `self` so that `fn`
   * is invoked before the original method.
   *
   * @param {object} self
   * @param {string} method
   * @param {function} fn
   */
  hook.before = function(self, method, fn) {
    var original = self[method];
    self[method] = function() {
      fn.apply(self, arguments);
      return original.apply(self, arguments);
    };
  };

  /**
   * Wraps `method` on `self` so that `fn`
   * is invoked after the original method.
   *
   * @param {object} self
   * @param {string} method
   * @param {function} fn
   */
  hook.after = function(self, method, fn) {
    var original = self[method];
    self[method] = function() {
      var result = original.apply(self, arguments);
      fn.apply(self, arguments);
      return result;
    };
  };

  /**
   * Wraps `fn` so that it can only be invoked once.
   *
   * @param {function} fn
   * @returns {function}
   */
  var once = function(fn) {
    var called = false;
    return function() {
      if (called) return;
      called = true;
      fn.apply(this, arguments);
    };
  };

  /**
   * Wraps `fn` so that it can only be called once
   * every `delay` milliseconds (invoked on the falling edge).
   *
   * @param {function} fn
   * @param {int} delay
   * @returns {function}
   */
  var debounce = function(fn, delay) {
    var timeout;
    return function() {
      var self = this;
      var args = arguments;
      window.clearTimeout(timeout);
      timeout = window.setTimeout(function() {
        fn.apply(self, args);
      }, delay);
    };
  };

  /**
   * Debounce all fired events types listed in `types`
   * while executing the provided `fn`.
   *
   * @param {object} self
   * @param {array} types
   * @param {function} fn
   */
  var debounce_events = function(self, types, fn) {
    var type;
    var trigger = self.trigger;
    var event_args = {};

    // override trigger method
    self.trigger = function() {
      var type = arguments[0];
      if (types.indexOf(type) !== -1) {
        event_args[type] = arguments;
      } else {
        return trigger.apply(self, arguments);
      }
    };

    // invoke provided function
    fn.apply(self, []);
    self.trigger = trigger;

    // trigger queued events
    for (type in event_args) {
      if (event_args.hasOwnProperty(type)) {
        trigger.apply(self, event_args[type]);
      }
    }
  };

  /**
   * A workaround for http://bugs.jquery.com/ticket/6696
   *
   * @param {object} $parent - Parent element to listen on.
   * @param {string} event - Event name.
   * @param {string} selector - Descendant selector to filter by.
   * @param {function} fn - Event handler.
   */
  var watchChildEvent = function($parent, event, selector, fn) {
    $parent.on(event, selector, function(e) {
      var child = e.target;
      while (child && child.parentNode !== $parent[0]) {
        child = child.parentNode;
      }
      e.currentTarget = child;
      return fn.apply(this, [e]);
    });
  };

  /**
   * Determines the current selection within a text input control.
   * Returns an object containing:
   *   - start
   *   - length
   *
   * @param {object} input
   * @returns {object}
   */
  var getSelection = function(input) {
    var result = {};
    if ('selectionStart' in input) {
      result.start = input.selectionStart;
      result.length = input.selectionEnd - result.start;
    } else if (document.selection) {
      input.focus();
      var sel = document.selection.createRange();
      var selLen = document.selection.createRange().text.length;
      sel.moveStart('character', -input.value.length);
      result.start = sel.text.length - selLen;
      result.length = selLen;
    }
    return result;
  };

  /**
   * Copies CSS properties from one element to another.
   *
   * @param {object} $from
   * @param {object} $to
   * @param {array} properties
   */
  var transferStyles = function($from, $to, properties) {
    var i, n, styles = {};
    if (properties) {
      for (i = 0, n = properties.length; i < n; i++) {
        styles[properties[i]] = $from.css(properties[i]);
      }
    } else {
      styles = $from.css();
    }
    $to.css(styles);
  };

  /**
   * Measures the width of a string within a
   * parent element (in pixels).
   *
   * @param {string} str
   * @param {object} $parent
   * @returns {int}
   */
  var measureString = function(str, $parent) {
    if (!str) {
      return 0;
    }

    var $test = $('<test>').css({
      position: 'absolute',
      top: -99999,
      left: -99999,
      width: 'auto',
      padding: 0,
      whiteSpace: 'pre'
    }).text(str).appendTo('body');

    transferStyles($parent, $test, [
      'letterSpacing',
      'fontSize',
      'fontFamily',
      'fontWeight',
      'textTransform'
    ]);

    var width = $test.width();
    $test.remove();

    return width;
  };

  /**
   * Sets up an input to grow horizontally as the user
   * types. If the value is changed manually, you can
   * trigger the "update" handler to resize:
   *
   * $input.trigger('update');
   *
   * @param {object} $input
   */
  var autoGrow = function($input) {
    var currentWidth = null;

    var update = function(e, options) {
      var value, keyCode, printable, placeholder, width;
      var shift, character, selection;
      e = e || window.event || {};
      options = options || {};

      if (e.metaKey || e.altKey) return;
      if (!options.force && $input.data('grow') === false) return;

      value = $input.val();
      if (e.type && e.type.toLowerCase() === 'keydown') {
        keyCode = e.keyCode;
        printable = (
          (keyCode >= 97 && keyCode <= 122) || // a-z
          (keyCode >= 65 && keyCode <= 90)  || // A-Z
          (keyCode >= 48 && keyCode <= 57)  || // 0-9
          keyCode === 32 // space
        );

        if (keyCode === KEY_DELETE || keyCode === KEY_BACKSPACE) {
          selection = getSelection($input[0]);
          if (selection.length) {
            value = value.substring(0, selection.start) + value.substring(selection.start + selection.length);
          } else if (keyCode === KEY_BACKSPACE && selection.start) {
            value = value.substring(0, selection.start - 1) + value.substring(selection.start + 1);
          } else if (keyCode === KEY_DELETE && typeof selection.start !== 'undefined') {
            value = value.substring(0, selection.start) + value.substring(selection.start + 1);
          }
        } else if (printable) {
          shift = e.shiftKey;
          character = String.fromCharCode(e.keyCode);
          if (shift) character = character.toUpperCase();
          else character = character.toLowerCase();
          value += character;
        }
      }

      placeholder = $input.attr('placeholder');
      if (!value && placeholder) {
        value = placeholder;
      }

      width = measureString(value, $input) + 4;
      if (width !== currentWidth) {
        currentWidth = width;
        $input.width(width);
        $input.triggerHandler('resize');
      }
    };

    $input.on('keydown keyup update blur', update);
    update();
  };

  var Selectize = function($input, settings) {
    var key, i, n, dir, input, self = this;
    input = $input[0];
    input.selectize = self;

    // detect rtl environment
    var computedStyle = window.getComputedStyle && window.getComputedStyle(input, null);
    dir = computedStyle ? computedStyle.getPropertyValue('direction') : input.currentStyle && input.currentStyle.direction;
    dir = dir || $input.parents('[dir]:first').attr('dir') || '';

    // setup default state
    $.extend(self, {
      order            : 0,
      settings         : settings,
      $input           : $input,
      tabIndex         : $input.attr('tabindex') || '',
      tagType          : input.tagName.toLowerCase() === 'select' ? TAG_SELECT : TAG_INPUT,
      rtl              : /rtl/i.test(dir),

      eventNS          : '.selectize' + (++Selectize.count),
      highlightedValue : null,
      isOpen           : false,
      isDisabled       : false,
      isRequired       : $input.is('[required]'),
      isInvalid        : false,
      isLocked         : false,
      isFocused        : false,
      isInputHidden    : false,
      isSetup          : false,
      isShiftDown      : false,
      isCmdDown        : false,
      isCtrlDown       : false,
      ignoreFocus      : false,
      ignoreBlur       : false,
      ignoreHover      : false,
      hasOptions       : false,
      currentResults   : null,
      lastValue        : '',
      caretPos         : 0,
      loading          : 0,
      loadedSearches   : {},

      $activeOption    : null,
      $activeItems     : [],

      optgroups        : {},
      options          : {},
      userOptions      : {},
      items            : [],
      renderCache      : {},
      onSearchChange   : settings.loadThrottle === null ? self.onSearchChange : debounce(self.onSearchChange, settings.loadThrottle)
    });

    // search system
    self.sifter = new Sifter(this.options, {diacritics: settings.diacritics});

    // build options table
    if (self.settings.options) {
      for (i = 0, n = self.settings.options.length; i < n; i++) {
        self.registerOption(self.settings.options[i]);
      }
      delete self.settings.options;
    }

    // build optgroup table
    if (self.settings.optgroups) {
      for (i = 0, n = self.settings.optgroups.length; i < n; i++) {
        self.registerOptionGroup(self.settings.optgroups[i]);
      }
      delete self.settings.optgroups;
    }

    // option-dependent defaults
    self.settings.mode = self.settings.mode || (self.settings.maxItems === 1 ? 'single' : 'multi');
    if (typeof self.settings.hideSelected !== 'boolean') {
      self.settings.hideSelected = self.settings.mode === 'multi';
    }

    self.initializePlugins(self.settings.plugins);
    self.setupCallbacks();
    self.setupTemplates();
    self.setup();
  };

  // mixins
  // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

  MicroEvent.mixin(Selectize);
  MicroPlugin.mixin(Selectize);

  // methods
  // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

  $.extend(Selectize.prototype, {

    /**
     * Creates all elements and sets up event bindings.
     */
    setup: function() {
      var self      = this;
      var settings  = self.settings;
      var eventNS   = self.eventNS;
      var $window   = $(window);
      var $document = $(document);
      var $input    = self.$input;

      var $wrapper;
      var $control;
      var $control_input;
      var $dropdown;
      var $dropdown_content;
      var $dropdown_parent;
      var inputMode;
      var timeout_blur;
      var timeout_focus;
      var classes;
      var classes_plugins;

      inputMode         = self.settings.mode;
      classes           = $input.attr('class') || '';

      $wrapper          = $('<div>').addClass(settings.wrapperClass).addClass(classes).addClass(inputMode);
      $control          = $('<div>').addClass(settings.inputClass).addClass('items').appendTo($wrapper);
      $control_input    = $('<input type="text" autocomplete="off" />').appendTo($control).attr('tabindex', $input.is(':disabled') ? '-1' : self.tabIndex);
      $dropdown_parent  = $(settings.dropdownParent || $wrapper);
      $dropdown         = $('<div>').addClass(settings.dropdownClass).addClass(inputMode).hide().appendTo($dropdown_parent);
      $dropdown_content = $('<div>').addClass(settings.dropdownContentClass).appendTo($dropdown);

      if(self.settings.copyClassesToDropdown) {
        $dropdown.addClass(classes);
      }

      $wrapper.css({
        width: $input[0].style.width
      });

      if (self.plugins.names.length) {
        classes_plugins = 'plugin-' + self.plugins.names.join(' plugin-');
        $wrapper.addClass(classes_plugins);
        $dropdown.addClass(classes_plugins);
      }

      if ((settings.maxItems === null || settings.maxItems > 1) && self.tagType === TAG_SELECT) {
        $input.attr('multiple', 'multiple');
      }

      if (self.settings.placeholder) {
        $control_input.attr('placeholder', settings.placeholder);
      }

      // if splitOn was not passed in, construct it from the delimiter to allow pasting universally
      if (!self.settings.splitOn && self.settings.delimiter) {
        var delimiterEscaped = self.settings.delimiter.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
        self.settings.splitOn = new RegExp('\\s*' + delimiterEscaped + '+\\s*');
      }

      if ($input.attr('autocorrect')) {
        $control_input.attr('autocorrect', $input.attr('autocorrect'));
      }

      if ($input.attr('autocapitalize')) {
        $control_input.attr('autocapitalize', $input.attr('autocapitalize'));
      }

      self.$wrapper          = $wrapper;
      self.$control          = $control;
      self.$control_input    = $control_input;
      self.$dropdown         = $dropdown;
      self.$dropdown_content = $dropdown_content;

      $dropdown.on('mouseenter', '[data-selectable]', function() { return self.onOptionHover.apply(self, arguments); });
      $dropdown.on('mousedown click', '[data-selectable]', function() { return self.onOptionSelect.apply(self, arguments); });
      watchChildEvent($control, 'mousedown', '*:not(input)', function() { return self.onItemSelect.apply(self, arguments); });
      autoGrow($control_input);

      $control.on({
        mousedown : function() { return self.onMouseDown.apply(self, arguments); },
        click     : function() { return self.onClick.apply(self, arguments); }
      });

      $control_input.on({
        mousedown : function(e) { e.stopPropagation(); },
        keydown   : function() { return self.onKeyDown.apply(self, arguments); },
        keyup     : function() { return self.onKeyUp.apply(self, arguments); },
        keypress  : function() { return self.onKeyPress.apply(self, arguments); },
        resize    : function() { self.positionDropdown.apply(self, []); },
        blur      : function() { return self.onBlur.apply(self, arguments); },
        focus     : function() { self.ignoreBlur = false; return self.onFocus.apply(self, arguments); },
        paste     : function() { return self.onPaste.apply(self, arguments); }
      });

      $document.on('keydown' + eventNS, function(e) {
        self.isCmdDown = e[IS_MAC ? 'metaKey' : 'ctrlKey'];
        self.isCtrlDown = e[IS_MAC ? 'altKey' : 'ctrlKey'];
        self.isShiftDown = e.shiftKey;
      });

      $document.on('keyup' + eventNS, function(e) {
        if (e.keyCode === KEY_CTRL) self.isCtrlDown = false;
        if (e.keyCode === KEY_SHIFT) self.isShiftDown = false;
        if (e.keyCode === KEY_CMD) self.isCmdDown = false;
      });

      $document.on('mousedown' + eventNS, function(e) {
        if (self.isFocused) {
          // prevent events on the dropdown scrollbar from causing the control to blur
          if (e.target === self.$dropdown[0] || e.target.parentNode === self.$dropdown[0]) {
            return false;
          }
          // blur on click outside
          if (!self.$control.has(e.target).length && e.target !== self.$control[0]) {
            self.blur(e.target);
          }
        }
      });

      $window.on(['scroll' + eventNS, 'resize' + eventNS].join(' '), function() {
        if (self.isOpen) {
          self.positionDropdown.apply(self, arguments);
        }
      });
      $window.on('mousemove' + eventNS, function() {
        self.ignoreHover = false;
      });

      // store original children and tab index so that they can be
      // restored when the destroy() method is called.
      this.revertSettings = {
        $children : $input.children().detach(),
        tabindex  : $input.attr('tabindex')
      };

      $input.attr('tabindex', -1).hide().after(self.$wrapper);

      if ($.isArray(settings.items)) {
        self.setValue(settings.items);
        delete settings.items;
      }

      // feature detect for the validation API
      if (SUPPORTS_VALIDITY_API) {
        $input.on('invalid' + eventNS, function(e) {
          e.preventDefault();
          self.isInvalid = true;
          self.refreshState();
        });
      }

      self.updateOriginalInput();
      self.refreshItems();
      self.refreshState();
      self.updatePlaceholder();
      self.isSetup = true;

      if ($input.is(':disabled')) {
        self.disable();
      }

      self.on('change', this.onChange);

      $input.data('selectize', self);
      $input.addClass('selectized');
      self.trigger('initialize');

      // preload options
      if (settings.preload === true) {
        self.onSearchChange('');
      }

    },

    /**
     * Sets up default rendering functions.
     */
    setupTemplates: function() {
      var self = this;
      var field_label = self.settings.labelField;
      var field_optgroup = self.settings.optgroupLabelField;

      var templates = {
        'optgroup': function(data) {
          return '<div class="optgroup">' + data.html + '</div>';
        },
        'optgroup_header': function(data, escape) {
          return '<div class="optgroup-header">' + escape(data[field_optgroup]) + '</div>';
        },
        'option': function(data, escape) {
          return '<div class="option">' + escape(data[field_label]) + '</div>';
        },
        'item': function(data, escape) {
          return '<div class="item">' + escape(data[field_label]) + '</div>';
        },
        'option_create': function(data, escape) {
          return '<div class="create">Add <strong>' + escape(data.input) + '</strong>&hellip;</div>';
        }
      };

      self.settings.render = $.extend({}, templates, self.settings.render);
    },

    /**
     * Maps fired events to callbacks provided
     * in the settings used when creating the control.
     */
    setupCallbacks: function() {
      var key, fn, callbacks = {
        'initialize'      : 'onInitialize',
        'change'          : 'onChange',
        'item_add'        : 'onItemAdd',
        'item_remove'     : 'onItemRemove',
        'clear'           : 'onClear',
        'option_add'      : 'onOptionAdd',
        'option_remove'   : 'onOptionRemove',
        'option_clear'    : 'onOptionClear',
        'optgroup_add'    : 'onOptionGroupAdd',
        'optgroup_remove' : 'onOptionGroupRemove',
        'optgroup_clear'  : 'onOptionGroupClear',
        'dropdown_open'   : 'onDropdownOpen',
        'dropdown_close'  : 'onDropdownClose',
        'type'            : 'onType',
        'load'            : 'onLoad',
        'focus'           : 'onFocus',
        'blur'            : 'onBlur'
      };

      for (key in callbacks) {
        if (callbacks.hasOwnProperty(key)) {
          fn = this.settings[callbacks[key]];
          if (fn) this.on(key, fn);
        }
      }
    },

    /**
     * Triggered when the main control element
     * has a click event.
     *
     * @param {object} e
     * @return {boolean}
     */
    onClick: function(e) {
      var self = this;

      // necessary for mobile webkit devices (manual focus triggering
      // is ignored unless invoked within a click event)
      if (!self.isFocused) {
        self.focus();
        e.preventDefault();
      }
    },

    /**
     * Triggered when the main control element
     * has a mouse down event.
     *
     * @param {object} e
     * @return {boolean}
     */
    onMouseDown: function(e) {
      var self = this;
      var defaultPrevented = e.isDefaultPrevented();
      var $target = $(e.target);

      if (self.isFocused) {
        // retain focus by preventing native handling. if the
        // event target is the input it should not be modified.
        // otherwise, text selection within the input won't work.
        if (e.target !== self.$control_input[0]) {
          if (self.settings.mode === 'single') {
            // toggle dropdown
            self.isOpen ? self.close() : self.open();
          } else if (!defaultPrevented) {
            self.setActiveItem(null);
          }
          return false;
        }
      } else {
        // give control focus
        if (!defaultPrevented) {
          window.setTimeout(function() {
            self.focus();
          }, 0);
        }
      }
    },

    /**
     * Triggered when the value of the control has been changed.
     * This should propagate the event to the original DOM
     * input / select element.
     */
    onChange: function() {
      this.$input.trigger('change');
    },

    /**
     * Triggered on <input> paste.
     *
     * @param {object} e
     * @returns {boolean}
     */
    onPaste: function(e) {
      var self = this;
      if (self.isFull() || self.isInputHidden || self.isLocked) {
        e.preventDefault();
      } else {
        // If a regex or string is included, this will split the pasted
        // input and create Items for each separate value
        if (self.settings.splitOn) {
          setTimeout(function() {
            var splitInput = $.trim(self.$control_input.val() || '').split(self.settings.splitOn);
            for (var i = 0, n = splitInput.length; i < n; i++) {
              self.createItem(splitInput[i]);
            }
          }, 0);
        }
      }
    },

    /**
     * Triggered on <input> keypress.
     *
     * @param {object} e
     * @returns {boolean}
     */
    onKeyPress: function(e) {
      if (this.isLocked) return e && e.preventDefault();
      var character = String.fromCharCode(e.keyCode || e.which);
      if (this.settings.create && this.settings.mode === 'multi' && character === this.settings.delimiter) {
        this.createItem();
        e.preventDefault();
        return false;
      }
    },

    /**
     * Triggered on <input> keydown.
     *
     * @param {object} e
     * @returns {boolean}
     */
    onKeyDown: function(e) {
      var isInput = e.target === this.$control_input[0];
      var self = this;

      if (self.isLocked) {
        if (e.keyCode !== KEY_TAB) {
          e.preventDefault();
        }
        return;
      }

      switch (e.keyCode) {
        case KEY_A:
          if (self.isCmdDown) {
            self.selectAll();
            return;
          }
          break;
        case KEY_ESC:
          if (self.isOpen) {
            e.preventDefault();
            e.stopPropagation();
            self.close();
          }
          return;
        case KEY_N:
          if (!e.ctrlKey || e.altKey) break;
        case KEY_DOWN:
          if (!self.isOpen && self.hasOptions) {
            self.open();
          } else if (self.$activeOption) {
            self.ignoreHover = true;
            var $next = self.getAdjacentOption(self.$activeOption, 1);
            if ($next.length) self.setActiveOption($next, true, true);
          }
          e.preventDefault();
          return;
        case KEY_P:
          if (!e.ctrlKey || e.altKey) break;
        case KEY_UP:
          if (self.$activeOption) {
            self.ignoreHover = true;
            var $prev = self.getAdjacentOption(self.$activeOption, -1);
            if ($prev.length) self.setActiveOption($prev, true, true);
          }
          e.preventDefault();
          return;
        case KEY_RETURN:
          if (self.isOpen && self.$activeOption) {
            self.onOptionSelect({currentTarget: self.$activeOption});
            e.preventDefault();
          }
          return;
        case KEY_LEFT:
          self.advanceSelection(-1, e);
          return;
        case KEY_RIGHT:
          self.advanceSelection(1, e);
          return;
        case KEY_TAB:
          if (self.settings.selectOnTab && self.isOpen && self.$activeOption) {
            self.onOptionSelect({currentTarget: self.$activeOption});

            // Default behaviour is to jump to the next field, we only want this
            // if the current field doesn't accept any more entries
            if (!self.isFull()) {
              e.preventDefault();
            }
          }
          if (self.settings.create && self.createItem()) {
            e.preventDefault();
          }
          return;
        case KEY_BACKSPACE:
        case KEY_DELETE:
          self.deleteSelection(e);
          return;
      }

      if ((self.isFull() || self.isInputHidden) && !(IS_MAC ? e.metaKey : e.ctrlKey)) {
        e.preventDefault();
        return;
      }
    },

    /**
     * Triggered on <input> keyup.
     *
     * @param {object} e
     * @returns {boolean}
     */
    onKeyUp: function(e) {
      var self = this;

      if (self.isLocked) return e && e.preventDefault();
      var value = self.$control_input.val() || '';
      if (self.lastValue !== value) {
        self.lastValue = value;
        self.onSearchChange(value);
        self.refreshOptions();
        self.trigger('type', value);
      }
    },

    /**
     * Invokes the user-provide option provider / loader.
     *
     * Note: this function is debounced in the Selectize
     * constructor (by `settings.loadDelay` milliseconds)
     *
     * @param {string} value
     */
    onSearchChange: function(value) {
      var self = this;
      var fn = self.settings.load;
      if (!fn) return;
      if (self.loadedSearches.hasOwnProperty(value)) return;
      self.loadedSearches[value] = true;
      self.load(function(callback) {
        fn.apply(self, [value, callback]);
      });
    },

    /**
     * Triggered on <input> focus.
     *
     * @param {object} e (optional)
     * @returns {boolean}
     */
    onFocus: function(e) {
      var self = this;
      var wasFocused = self.isFocused;

      if (self.isDisabled) {
        self.blur();
        e && e.preventDefault();
        return false;
      }

      if (self.ignoreFocus) return;
      self.isFocused = true;
      if (self.settings.preload === 'focus') self.onSearchChange('');

      if (!wasFocused) self.trigger('focus');

      if (!self.$activeItems.length) {
        self.showInput();
        self.setActiveItem(null);
        self.refreshOptions(!!self.settings.openOnFocus);
      }

      self.refreshState();
    },

    /**
     * Triggered on <input> blur.
     *
     * @param {object} e
     * @param {Element} dest
     */
    onBlur: function(e, dest) {
      var self = this;
      if (!self.isFocused) return;
      self.isFocused = false;

      if (self.ignoreFocus) {
        return;
      } else if (!self.ignoreBlur && document.activeElement === self.$dropdown_content[0]) {
        // necessary to prevent IE closing the dropdown when the scrollbar is clicked
        self.ignoreBlur = true;
        self.onFocus(e);
        return;
      }

      var deactivate = function() {
        self.close();
        self.setTextboxValue('');
        self.setActiveItem(null);
        self.setActiveOption(null);
        self.setCaret(self.items.length);
        self.refreshState();

        // IE11 bug: element still marked as active
        (dest || document.body).focus();

        self.ignoreFocus = false;
        self.trigger('blur');
      };

      self.ignoreFocus = true;
      if (self.settings.create && self.settings.createOnBlur) {
        self.createItem(null, false, deactivate);
      } else {
        deactivate();
      }
    },

    /**
     * Triggered when the user rolls over
     * an option in the autocomplete dropdown menu.
     *
     * @param {object} e
     * @returns {boolean}
     */
    onOptionHover: function(e) {
      if (this.ignoreHover) return;
      this.setActiveOption(e.currentTarget, false);
    },

    /**
     * Triggered when the user clicks on an option
     * in the autocomplete dropdown menu.
     *
     * @param {object} e
     * @returns {boolean}
     */
    onOptionSelect: function(e) {
      var value, $target, $option, self = this;

      if (e.preventDefault) {
        e.preventDefault();
        e.stopPropagation();
      }

      $target = $(e.currentTarget);
      if ($target.hasClass('create')) {
        self.createItem(null, function() {
          if (self.settings.closeAfterSelect) {
            self.close();
          }
        });
      } else {
        value = $target.attr('data-value');
        if (typeof value !== 'undefined') {
          self.lastQuery = null;
          self.setTextboxValue('');
          self.addItem(value);
          if (self.settings.closeAfterSelect) {
            self.close();
          } else if (!self.settings.hideSelected && e.type && /mouse/.test(e.type)) {
            self.setActiveOption(self.getOption(value));
          }
        }
      }
    },

    /**
     * Triggered when the user clicks on an item
     * that has been selected.
     *
     * @param {object} e
     * @returns {boolean}
     */
    onItemSelect: function(e) {
      var self = this;

      if (self.isLocked) return;
      if (self.settings.mode === 'multi') {
        e.preventDefault();
        self.setActiveItem(e.currentTarget, e);
      }
    },

    /**
     * Invokes the provided method that provides
     * results to a callback---which are then added
     * as options to the control.
     *
     * @param {function} fn
     */
    load: function(fn) {
      var self = this;
      var $wrapper = self.$wrapper.addClass(self.settings.loadingClass);

      self.loading++;
      fn.apply(self, [function(results) {
        self.loading = Math.max(self.loading - 1, 0);
        if (results && results.length) {
          self.addOption(results);
          self.refreshOptions(self.isFocused && !self.isInputHidden);
        }
        if (!self.loading) {
          $wrapper.removeClass(self.settings.loadingClass);
        }
        self.trigger('load', results);
      }]);
    },

    /**
     * Sets the input field of the control to the specified value.
     *
     * @param {string} value
     */
    setTextboxValue: function(value) {
      var $input = this.$control_input;
      var changed = $input.val() !== value;
      if (changed) {
        $input.val(value).triggerHandler('update');
        this.lastValue = value;
      }
    },

    /**
     * Returns the value of the control. If multiple items
     * can be selected (e.g. <select multiple>), this returns
     * an array. If only one item can be selected, this
     * returns a string.
     *
     * @returns {mixed}
     */
    getValue: function() {
      if (this.tagType === TAG_SELECT && this.$input.attr('multiple')) {
        return this.items;
      } else {
        return this.items.join(this.settings.delimiter);
      }
    },

    /**
     * Resets the selected items to the given value.
     *
     * @param {mixed} value
     */
    setValue: function(value, silent) {
      var events = silent ? [] : ['change'];

      debounce_events(this, events, function() {
        this.clear(silent);
        this.addItems(value, silent);
      });
    },

    /**
     * Sets the selected item.
     *
     * @param {object} $item
     * @param {object} e (optional)
     */
    setActiveItem: function($item, e) {
      var self = this;
      var eventName;
      var i, idx, begin, end, item, swap;
      var $last;

      if (self.settings.mode === 'single') return;
      $item = $($item);

      // clear the active selection
      if (!$item.length) {
        $(self.$activeItems).removeClass('active');
        self.$activeItems = [];
        if (self.isFocused) {
          self.showInput();
        }
        return;
      }

      // modify selection
      eventName = e && e.type.toLowerCase();

      if (eventName === 'mousedown' && self.isShiftDown && self.$activeItems.length) {
        $last = self.$control.children('.active:last');
        begin = Array.prototype.indexOf.apply(self.$control[0].childNodes, [$last[0]]);
        end   = Array.prototype.indexOf.apply(self.$control[0].childNodes, [$item[0]]);
        if (begin > end) {
          swap  = begin;
          begin = end;
          end   = swap;
        }
        for (i = begin; i <= end; i++) {
          item = self.$control[0].childNodes[i];
          if (self.$activeItems.indexOf(item) === -1) {
            $(item).addClass('active');
            self.$activeItems.push(item);
          }
        }
        e.preventDefault();
      } else if ((eventName === 'mousedown' && self.isCtrlDown) || (eventName === 'keydown' && this.isShiftDown)) {
        if ($item.hasClass('active')) {
          idx = self.$activeItems.indexOf($item[0]);
          self.$activeItems.splice(idx, 1);
          $item.removeClass('active');
        } else {
          self.$activeItems.push($item.addClass('active')[0]);
        }
      } else {
        $(self.$activeItems).removeClass('active');
        self.$activeItems = [$item.addClass('active')[0]];
      }

      // ensure control has focus
      self.hideInput();
      if (!this.isFocused) {
        self.focus();
      }
    },

    /**
     * Sets the selected item in the dropdown menu
     * of available options.
     *
     * @param {object} $object
     * @param {boolean} scroll
     * @param {boolean} animate
     */
    setActiveOption: function($option, scroll, animate) {
      var height_menu, height_item, y;
      var scroll_top, scroll_bottom;
      var self = this;

      if (self.$activeOption) self.$activeOption.removeClass('active');
      self.$activeOption = null;

      $option = $($option);
      if (!$option.length) return;

      self.$activeOption = $option.addClass('active');

      if (scroll || !isset(scroll)) {

        height_menu   = self.$dropdown_content.height();
        height_item   = self.$activeOption.outerHeight(true);
        scroll        = self.$dropdown_content.scrollTop() || 0;
        y             = self.$activeOption.offset().top - self.$dropdown_content.offset().top + scroll;
        scroll_top    = y;
        scroll_bottom = y - height_menu + height_item;

        if (y + height_item > height_menu + scroll) {
          self.$dropdown_content.stop().animate({scrollTop: scroll_bottom}, animate ? self.settings.scrollDuration : 0);
        } else if (y < scroll) {
          self.$dropdown_content.stop().animate({scrollTop: scroll_top}, animate ? self.settings.scrollDuration : 0);
        }

      }
    },

    /**
     * Selects all items (CTRL + A).
     */
    selectAll: function() {
      var self = this;
      if (self.settings.mode === 'single') return;

      self.$activeItems = Array.prototype.slice.apply(self.$control.children(':not(input)').addClass('active'));
      if (self.$activeItems.length) {
        self.hideInput();
        self.close();
      }
      self.focus();
    },

    /**
     * Hides the input element out of view, while
     * retaining its focus.
     */
    hideInput: function() {
      var self = this;

      self.setTextboxValue('');
      self.$control_input.css({opacity: 0, position: 'absolute', left: self.rtl ? 10000 : -10000});
      self.isInputHidden = true;
    },

    /**
     * Restores input visibility.
     */
    showInput: function() {
      this.$control_input.css({opacity: 1, position: 'relative', left: 0});
      this.isInputHidden = false;
    },

    /**
     * Gives the control focus.
     */
    focus: function() {
      var self = this;
      if (self.isDisabled) return;

      self.ignoreFocus = true;
      self.$control_input[0].focus();
      window.setTimeout(function() {
        self.ignoreFocus = false;
        self.onFocus();
      }, 0);
    },

    /**
     * Forces the control out of focus.
     *
     * @param {Element} dest
     */
    blur: function(dest) {
      this.$control_input[0].blur();
      this.onBlur(null, dest);
    },

    /**
     * Returns a function that scores an object
     * to show how good of a match it is to the
     * provided query.
     *
     * @param {string} query
     * @param {object} options
     * @return {function}
     */
    getScoreFunction: function(query) {
      return this.sifter.getScoreFunction(query, this.getSearchOptions());
    },

    /**
     * Returns search options for sifter (the system
     * for scoring and sorting results).
     *
     * @see https://github.com/brianreavis/sifter.js
     * @return {object}
     */
    getSearchOptions: function() {
      var settings = this.settings;
      var sort = settings.sortField;
      if (typeof sort === 'string') {
        sort = [{field: sort}];
      }

      return {
        fields      : settings.searchField,
        conjunction : settings.searchConjunction,
        sort        : sort
      };
    },

    /**
     * Searches through available options and returns
     * a sorted array of matches.
     *
     * Returns an object containing:
     *
     *   - query {string}
     *   - tokens {array}
     *   - total {int}
     *   - items {array}
     *
     * @param {string} query
     * @returns {object}
     */
    search: function(query) {
      var i, value, score, result, calculateScore;
      var self     = this;
      var settings = self.settings;
      var options  = this.getSearchOptions();

      // validate user-provided result scoring function
      if (settings.score) {
        calculateScore = self.settings.score.apply(this, [query]);
        if (typeof calculateScore !== 'function') {
          throw new Error('Selectize "score" setting must be a function that returns a function');
        }
      }

      // perform search
      if (query !== self.lastQuery) {
        self.lastQuery = query;
        result = self.sifter.search(query, $.extend(options, {score: calculateScore}));
        self.currentResults = result;
      } else {
        result = $.extend(true, {}, self.currentResults);
      }

      // filter out selected items
      if (settings.hideSelected) {
        for (i = result.items.length - 1; i >= 0; i--) {
          if (self.items.indexOf(hash_key(result.items[i].id)) !== -1) {
            result.items.splice(i, 1);
          }
        }
      }

      return result;
    },

    /**
     * Refreshes the list of available options shown
     * in the autocomplete dropdown menu.
     *
     * @param {boolean} triggerDropdown
     */
    refreshOptions: function(triggerDropdown) {
      var i, j, k, n, groups, groups_order, option, option_html, optgroup, optgroups, html, html_children, has_create_option;
      var $active, $active_before, $create;

      if (typeof triggerDropdown === 'undefined') {
        triggerDropdown = true;
      }

      var self              = this;
      var query             = $.trim(self.$control_input.val());
      var results           = self.search(query);
      var $dropdown_content = self.$dropdown_content;
      var active_before     = self.$activeOption && hash_key(self.$activeOption.attr('data-value'));

      // build markup
      n = results.items.length;
      if (typeof self.settings.maxOptions === 'number') {
        n = Math.min(n, self.settings.maxOptions);
      }

      // render and group available options individually
      groups = {};
      groups_order = [];

      for (i = 0; i < n; i++) {
        option      = self.options[results.items[i].id];
        option_html = self.render('option', option);
        optgroup    = option[self.settings.optgroupField] || '';
        optgroups   = $.isArray(optgroup) ? optgroup : [optgroup];

        for (j = 0, k = optgroups && optgroups.length; j < k; j++) {
          optgroup = optgroups[j];
          if (!self.optgroups.hasOwnProperty(optgroup)) {
            optgroup = '';
          }
          if (!groups.hasOwnProperty(optgroup)) {
            groups[optgroup] = [];
            groups_order.push(optgroup);
          }
          groups[optgroup].push(option_html);
        }
      }

      // sort optgroups
      if (this.settings.lockOptgroupOrder) {
        groups_order.sort(function(a, b) {
          var a_order = self.optgroups[a].$order || 0;
          var b_order = self.optgroups[b].$order || 0;
          return a_order - b_order;
        });
      }

      // render optgroup headers & join groups
      html = [];
      for (i = 0, n = groups_order.length; i < n; i++) {
        optgroup = groups_order[i];
        if (self.optgroups.hasOwnProperty(optgroup) && groups[optgroup].length) {
          // render the optgroup header and options within it,
          // then pass it to the wrapper template
          html_children = self.render('optgroup_header', self.optgroups[optgroup]) || '';
          html_children += groups[optgroup].join('');
          html.push(self.render('optgroup', $.extend({}, self.optgroups[optgroup], {
            html: html_children
          })));
        } else {
          html.push(groups[optgroup].join(''));
        }
      }

      $dropdown_content.html(html.join(''));

      // highlight matching terms inline
      if (self.settings.highlight && results.query.length && results.tokens.length) {
        for (i = 0, n = results.tokens.length; i < n; i++) {
          highlight($dropdown_content, results.tokens[i].regex);
        }
      }

      // add "selected" class to selected options
      if (!self.settings.hideSelected) {
        for (i = 0, n = self.items.length; i < n; i++) {
          self.getOption(self.items[i]).addClass('selected');
        }
      }

      // add create option
      has_create_option = self.canCreate(query);
      if (has_create_option) {
        $dropdown_content.prepend(self.render('option_create', {input: query}));
        $create = $($dropdown_content[0].childNodes[0]);
      }

      // activate
      self.hasOptions = results.items.length > 0 || has_create_option;
      if (self.hasOptions) {
        if (results.items.length > 0) {
          $active_before = active_before && self.getOption(active_before);
          if ($active_before && $active_before.length) {
            $active = $active_before;
          } else if (self.settings.mode === 'single' && self.items.length) {
            $active = self.getOption(self.items[0]);
          }
          if (!$active || !$active.length) {
            if ($create && !self.settings.addPrecedence) {
              $active = self.getAdjacentOption($create, 1);
            } else {
              $active = $dropdown_content.find('[data-selectable]:first');
            }
          }
        } else {
          $active = $create;
        }
        self.setActiveOption($active);
        if (triggerDropdown && !self.isOpen) { self.open(); }
      } else {
        self.setActiveOption(null);
        if (triggerDropdown && self.isOpen) { self.close(); }
      }
    },

    /**
     * Adds an available option. If it already exists,
     * nothing will happen. Note: this does not refresh
     * the options list dropdown (use `refreshOptions`
     * for that).
     *
     * Usage:
     *
     *   this.addOption(data)
     *
     * @param {object|array} data
     */
    addOption: function(data) {
      var i, n, value, self = this;

      if ($.isArray(data)) {
        for (i = 0, n = data.length; i < n; i++) {
          self.addOption(data[i]);
        }
        return;
      }

      if (value = self.registerOption(data)) {
        self.userOptions[value] = true;
        self.lastQuery = null;
        self.trigger('option_add', value, data);
      }
    },

    /**
     * Registers an option to the pool of options.
     *
     * @param {object} data
     * @return {boolean|string}
     */
    registerOption: function(data) {
      var key = hash_key(data[this.settings.valueField]);
      if (!key || this.options.hasOwnProperty(key)) return false;
      data.$order = data.$order || ++this.order;
      this.options[key] = data;
      return key;
    },

    /**
     * Registers an option group to the pool of option groups.
     *
     * @param {object} data
     * @return {boolean|string}
     */
    registerOptionGroup: function(data) {
      var key = hash_key(data[this.settings.optgroupValueField]);
      if (!key) return false;

      data.$order = data.$order || ++this.order;
      this.optgroups[key] = data;
      return key;
    },

    /**
     * Registers a new optgroup for options
     * to be bucketed into.
     *
     * @param {string} id
     * @param {object} data
     */
    addOptionGroup: function(id, data) {
      data[this.settings.optgroupValueField] = id;
      if (id = this.registerOptionGroup(data)) {
        this.trigger('optgroup_add', id, data);
      }
    },

    /**
     * Removes an existing option group.
     *
     * @param {string} id
     */
    removeOptionGroup: function(id) {
      if (this.optgroups.hasOwnProperty(id)) {
        delete this.optgroups[id];
        this.renderCache = {};
        this.trigger('optgroup_remove', id);
      }
    },

    /**
     * Clears all existing option groups.
     */
    clearOptionGroups: function() {
      this.optgroups = {};
      this.renderCache = {};
      this.trigger('optgroup_clear');
    },

    /**
     * Updates an option available for selection. If
     * it is visible in the selected items or options
     * dropdown, it will be re-rendered automatically.
     *
     * @param {string} value
     * @param {object} data
     */
    updateOption: function(value, data) {
      var self = this;
      var $item, $item_new;
      var value_new, index_item, cache_items, cache_options, order_old;

      value     = hash_key(value);
      value_new = hash_key(data[self.settings.valueField]);

      // sanity checks
      if (value === null) return;
      if (!self.options.hasOwnProperty(value)) return;
      if (typeof value_new !== 'string') throw new Error('Value must be set in option data');

      order_old = self.options[value].$order;

      // update references
      if (value_new !== value) {
        delete self.options[value];
        index_item = self.items.indexOf(value);
        if (index_item !== -1) {
          self.items.splice(index_item, 1, value_new);
        }
      }
      data.$order = data.$order || order_old;
      self.options[value_new] = data;

      // invalidate render cache
      cache_items = self.renderCache['item'];
      cache_options = self.renderCache['option'];

      if (cache_items) {
        delete cache_items[value];
        delete cache_items[value_new];
      }
      if (cache_options) {
        delete cache_options[value];
        delete cache_options[value_new];
      }

      // update the item if it's selected
      if (self.items.indexOf(value_new) !== -1) {
        $item = self.getItem(value);
        $item_new = $(self.render('item', data));
        if ($item.hasClass('active')) $item_new.addClass('active');
        $item.replaceWith($item_new);
      }

      // invalidate last query because we might have updated the sortField
      self.lastQuery = null;

      // update dropdown contents
      if (self.isOpen) {
        self.refreshOptions(false);
      }
    },

    /**
     * Removes a single option.
     *
     * @param {string} value
     * @param {boolean} silent
     */
    removeOption: function(value, silent) {
      var self = this;
      value = hash_key(value);

      var cache_items = self.renderCache['item'];
      var cache_options = self.renderCache['option'];
      if (cache_items) delete cache_items[value];
      if (cache_options) delete cache_options[value];

      delete self.userOptions[value];
      delete self.options[value];
      self.lastQuery = null;
      self.trigger('option_remove', value);
      self.removeItem(value, silent);
    },

    /**
     * Clears all options.
     */
    clearOptions: function() {
      var self = this;

      self.loadedSearches = {};
      self.userOptions = {};
      self.renderCache = {};
      self.options = self.sifter.items = {};
      self.lastQuery = null;
      self.trigger('option_clear');
      self.clear();
    },

    /**
     * Returns the jQuery element of the option
     * matching the given value.
     *
     * @param {string} value
     * @returns {object}
     */
    getOption: function(value) {
      return this.getElementWithValue(value, this.$dropdown_content.find('[data-selectable]'));
    },

    /**
     * Returns the jQuery element of the next or
     * previous selectable option.
     *
     * @param {object} $option
     * @param {int} direction  can be 1 for next or -1 for previous
     * @return {object}
     */
    getAdjacentOption: function($option, direction) {
      var $options = this.$dropdown.find('[data-selectable]');
      var index    = $options.index($option) + direction;

      return index >= 0 && index < $options.length ? $options.eq(index) : $();
    },

    /**
     * Finds the first element with a "data-value" attribute
     * that matches the given value.
     *
     * @param {mixed} value
     * @param {object} $els
     * @return {object}
     */
    getElementWithValue: function(value, $els) {
      value = hash_key(value);

      if (typeof value !== 'undefined' && value !== null) {
        for (var i = 0, n = $els.length; i < n; i++) {
          if ($els[i].getAttribute('data-value') === value) {
            return $($els[i]);
          }
        }
      }

      return $();
    },

    /**
     * Returns the jQuery element of the item
     * matching the given value.
     *
     * @param {string} value
     * @returns {object}
     */
    getItem: function(value) {
      return this.getElementWithValue(value, this.$control.children());
    },

    /**
     * "Selects" multiple items at once. Adds them to the list
     * at the current caret position.
     *
     * @param {string} value
     * @param {boolean} silent
     */
    addItems: function(values, silent) {
      var items = $.isArray(values) ? values : [values];
      for (var i = 0, n = items.length; i < n; i++) {
        this.isPending = (i < n - 1);
        this.addItem(items[i], silent);
      }
    },

    /**
     * "Selects" an item. Adds it to the list
     * at the current caret position.
     *
     * @param {string} value
     * @param {boolean} silent
     */
    addItem: function(value, silent) {
      var events = silent ? [] : ['change'];

      debounce_events(this, events, function() {
        var $item, $option, $options;
        var self = this;
        var inputMode = self.settings.mode;
        var i, active, value_next, wasFull;
        value = hash_key(value);

        if (self.items.indexOf(value) !== -1) {
          if (inputMode === 'single') self.close();
          return;
        }

        if (!self.options.hasOwnProperty(value)) return;
        if (inputMode === 'single') self.clear(silent);
        if (inputMode === 'multi' && self.isFull()) return;

        $item = $(self.render('item', self.options[value]));
        wasFull = self.isFull();
        self.items.splice(self.caretPos, 0, value);
        self.insertAtCaret($item);
        if (!self.isPending || (!wasFull && self.isFull())) {
          self.refreshState();
        }

        if (self.isSetup) {
          $options = self.$dropdown_content.find('[data-selectable]');

          // update menu / remove the option (if this is not one item being added as part of series)
          if (!self.isPending) {
            $option = self.getOption(value);
            value_next = self.getAdjacentOption($option, 1).attr('data-value');
            self.refreshOptions(self.isFocused && inputMode !== 'single');
            if (value_next) {
              self.setActiveOption(self.getOption(value_next));
            }
          }

          // hide the menu if the maximum number of items have been selected or no options are left
          if (!$options.length || self.isFull()) {
            self.close();
          } else {
            self.positionDropdown();
          }

          self.updatePlaceholder();
          self.trigger('item_add', value, $item);
          self.updateOriginalInput({silent: silent});
        }
      });
    },

    /**
     * Removes the selected item matching
     * the provided value.
     *
     * @param {string} value
     */
    removeItem: function(value, silent) {
      var self = this;
      var $item, i, idx;

      $item = (typeof value === 'object') ? value : self.getItem(value);
      value = hash_key($item.attr('data-value'));
      i = self.items.indexOf(value);

      if (i !== -1) {
        $item.remove();
        if ($item.hasClass('active')) {
          idx = self.$activeItems.indexOf($item[0]);
          self.$activeItems.splice(idx, 1);
        }

        self.items.splice(i, 1);
        self.lastQuery = null;
        if (!self.settings.persist && self.userOptions.hasOwnProperty(value)) {
          self.removeOption(value, silent);
        }

        if (i < self.caretPos) {
          self.setCaret(self.caretPos - 1);
        }

        self.refreshState();
        self.updatePlaceholder();
        self.updateOriginalInput({silent: silent});
        self.positionDropdown();
        self.trigger('item_remove', value, $item);
      }
    },

    /**
     * Invokes the `create` method provided in the
     * selectize options that should provide the data
     * for the new item, given the user input.
     *
     * Once this completes, it will be added
     * to the item list.
     *
     * @param {string} value
     * @param {boolean} [triggerDropdown]
     * @param {function} [callback]
     * @return {boolean}
     */
    createItem: function(input, triggerDropdown) {
      var self  = this;
      var caret = self.caretPos;
      input = input || $.trim(self.$control_input.val() || '');

      var callback = arguments[arguments.length - 1];
      if (typeof callback !== 'function') callback = function() {};

      if (typeof triggerDropdown !== 'boolean') {
        triggerDropdown = true;
      }

      if (!self.canCreate(input)) {
        callback();
        return false;
      }

      self.lock();

      var setup = (typeof self.settings.create === 'function') ? this.settings.create : function(input) {
        var data = {};
        data[self.settings.labelField] = input;
        data[self.settings.valueField] = input;
        return data;
      };

      var create = once(function(data) {
        self.unlock();

        if (!data || typeof data !== 'object') return callback();
        var value = hash_key(data[self.settings.valueField]);
        if (typeof value !== 'string') return callback();

        self.setTextboxValue('');
        self.addOption(data);
        self.setCaret(caret);
        self.addItem(value);
        self.refreshOptions(triggerDropdown && self.settings.mode !== 'single');
        callback(data);
      });

      var output = setup.apply(this, [input, create]);
      if (typeof output !== 'undefined') {
        create(output);
      }

      return true;
    },

    /**
     * Re-renders the selected item lists.
     */
    refreshItems: function() {
      this.lastQuery = null;

      if (this.isSetup) {
        this.addItem(this.items);
      }

      this.refreshState();
      this.updateOriginalInput();
    },

    /**
     * Updates all state-dependent attributes
     * and CSS classes.
     */
    refreshState: function() {
      var invalid, self = this;
      if (self.isRequired) {
        if (self.items.length) self.isInvalid = false;
        self.$control_input.prop('required', invalid);
      }
      self.refreshClasses();
    },

    /**
     * Updates all state-dependent CSS classes.
     */
    refreshClasses: function() {
      var self     = this;
      var isFull   = self.isFull();
      var isLocked = self.isLocked;

      self.$wrapper
        .toggleClass('rtl', self.rtl);

      self.$control
        .toggleClass('focus', self.isFocused)
        .toggleClass('disabled', self.isDisabled)
        .toggleClass('required', self.isRequired)
        .toggleClass('invalid', self.isInvalid)
        .toggleClass('locked', isLocked)
        .toggleClass('full', isFull).toggleClass('not-full', !isFull)
        .toggleClass('input-active', self.isFocused && !self.isInputHidden)
        .toggleClass('dropdown-active', self.isOpen)
        .toggleClass('has-options', !$.isEmptyObject(self.options))
        .toggleClass('has-items', self.items.length > 0);

      self.$control_input.data('grow', !isFull && !isLocked);
    },

    /**
     * Determines whether or not more items can be added
     * to the control without exceeding the user-defined maximum.
     *
     * @returns {boolean}
     */
    isFull: function() {
      return this.settings.maxItems !== null && this.items.length >= this.settings.maxItems;
    },

    /**
     * Refreshes the original <select> or <input>
     * element to reflect the current state.
     */
    updateOriginalInput: function(opts) {
      var i, n, options, label, self = this;
      opts = opts || {};

      if (self.tagType === TAG_SELECT) {
        options = [];
        for (i = 0, n = self.items.length; i < n; i++) {
          label = self.options[self.items[i]][self.settings.labelField] || '';
          options.push('<option value="' + escape_html(self.items[i]) + '" selected="selected">' + escape_html(label) + '</option>');
        }
        if (!options.length && !this.$input.attr('multiple')) {
          options.push('<option value="" selected="selected"></option>');
        }
        self.$input.html(options.join(''));
      } else {
        self.$input.val(self.getValue());
        self.$input.attr('value',self.$input.val());
      }

      if (self.isSetup) {
        if (!opts.silent) {
          self.trigger('change', self.$input.val());
        }
      }
    },

    /**
     * Shows/hide the input placeholder depending
     * on if there items in the list already.
     */
    updatePlaceholder: function() {
      if (!this.settings.placeholder) return;
      var $input = this.$control_input;

      if (this.items.length) {
        $input.removeAttr('placeholder');
      } else {
        $input.attr('placeholder', this.settings.placeholder);
      }
      $input.triggerHandler('update', {force: true});
    },

    /**
     * Shows the autocomplete dropdown containing
     * the available options.
     */
    open: function() {
      var self = this;

      if (self.isLocked || self.isOpen || (self.settings.mode === 'multi' && self.isFull())) return;
      self.focus();
      self.isOpen = true;
      self.refreshState();
      self.$dropdown.css({visibility: 'hidden', display: 'block'});
      self.positionDropdown();
      self.$dropdown.css({visibility: 'visible'});
      self.trigger('dropdown_open', self.$dropdown);
    },

    /**
     * Closes the autocomplete dropdown menu.
     */
    close: function() {
      var self = this;
      var trigger = self.isOpen;

      if (self.settings.mode === 'single' && self.items.length) {
        self.hideInput();
      }

      self.isOpen = false;
      self.$dropdown.hide();
      self.setActiveOption(null);
      self.refreshState();

      if (trigger) self.trigger('dropdown_close', self.$dropdown);
    },

    /**
     * Calculates and applies the appropriate
     * position of the dropdown.
     */
    positionDropdown: function() {
      var $control = this.$control;
      var offset = this.settings.dropdownParent === 'body' ? $control.offset() : $control.position();
      offset.top += $control.outerHeight(true);

      this.$dropdown.css({
        width : $control.outerWidth(),
        top   : offset.top,
        left  : offset.left
      });
    },

    /**
     * Resets / clears all selected items
     * from the control.
     *
     * @param {boolean} silent
     */
    clear: function(silent) {
      var self = this;

      if (!self.items.length) return;
      self.$control.children(':not(input)').remove();
      self.items = [];
      self.lastQuery = null;
      self.setCaret(0);
      self.setActiveItem(null);
      self.updatePlaceholder();
      self.updateOriginalInput({silent: silent});
      self.refreshState();
      self.showInput();
      self.trigger('clear');
    },

    /**
     * A helper method for inserting an element
     * at the current caret position.
     *
     * @param {object} $el
     */
    insertAtCaret: function($el) {
      var caret = Math.min(this.caretPos, this.items.length);
      if (caret === 0) {
        this.$control.prepend($el);
      } else {
        $(this.$control[0].childNodes[caret]).before($el);
      }
      this.setCaret(caret + 1);
    },

    /**
     * Removes the current selected item(s).
     *
     * @param {object} e (optional)
     * @returns {boolean}
     */
    deleteSelection: function(e) {
      var i, n, direction, selection, values, caret, option_select, $option_select, $tail;
      var self = this;

      direction = (e && e.keyCode === KEY_BACKSPACE) ? -1 : 1;
      selection = getSelection(self.$control_input[0]);

      if (self.$activeOption && !self.settings.hideSelected) {
        option_select = self.getAdjacentOption(self.$activeOption, -1).attr('data-value');
      }

      // determine items that will be removed
      values = [];

      if (self.$activeItems.length) {
        $tail = self.$control.children('.active:' + (direction > 0 ? 'last' : 'first'));
        caret = self.$control.children(':not(input)').index($tail);
        if (direction > 0) { caret++; }

        for (i = 0, n = self.$activeItems.length; i < n; i++) {
          values.push($(self.$activeItems[i]).attr('data-value'));
        }
        if (e) {
          e.preventDefault();
          e.stopPropagation();
        }
      } else if ((self.isFocused || self.settings.mode === 'single') && self.items.length) {
        if (direction < 0 && selection.start === 0 && selection.length === 0) {
          values.push(self.items[self.caretPos - 1]);
        } else if (direction > 0 && selection.start === self.$control_input.val().length) {
          values.push(self.items[self.caretPos]);
        }
      }

      // allow the callback to abort
      if (!values.length || (typeof self.settings.onDelete === 'function' && self.settings.onDelete.apply(self, [values]) === false)) {
        return false;
      }

      // perform removal
      if (typeof caret !== 'undefined') {
        self.setCaret(caret);
      }
      while (values.length) {
        self.removeItem(values.pop());
      }

      self.showInput();
      self.positionDropdown();
      self.refreshOptions(true);

      // select previous option
      if (option_select) {
        $option_select = self.getOption(option_select);
        if ($option_select.length) {
          self.setActiveOption($option_select);
        }
      }

      return true;
    },

    /**
     * Selects the previous / next item (depending
     * on the `direction` argument).
     *
     * > 0 - right
     * < 0 - left
     *
     * @param {int} direction
     * @param {object} e (optional)
     */
    advanceSelection: function(direction, e) {
      var tail, selection, idx, valueLength, cursorAtEdge, $tail;
      var self = this;

      if (direction === 0) return;
      if (self.rtl) direction *= -1;

      tail = direction > 0 ? 'last' : 'first';
      selection = getSelection(self.$control_input[0]);

      if (self.isFocused && !self.isInputHidden) {
        valueLength = self.$control_input.val().length;
        cursorAtEdge = direction < 0
          ? selection.start === 0 && selection.length === 0
          : selection.start === valueLength;

        if (cursorAtEdge && !valueLength) {
          self.advanceCaret(direction, e);
        }
      } else {
        $tail = self.$control.children('.active:' + tail);
        if ($tail.length) {
          idx = self.$control.children(':not(input)').index($tail);
          self.setActiveItem(null);
          self.setCaret(direction > 0 ? idx + 1 : idx);
        }
      }
    },

    /**
     * Moves the caret left / right.
     *
     * @param {int} direction
     * @param {object} e (optional)
     */
    advanceCaret: function(direction, e) {
      var self = this, fn, $adj;

      if (direction === 0) return;

      fn = direction > 0 ? 'next' : 'prev';
      if (self.isShiftDown) {
        $adj = self.$control_input[fn]();
        if ($adj.length) {
          self.hideInput();
          self.setActiveItem($adj);
          e && e.preventDefault();
        }
      } else {
        self.setCaret(self.caretPos + direction);
      }
    },

    /**
     * Moves the caret to the specified index.
     *
     * @param {int} i
     */
    setCaret: function(i) {
      var self = this;

      if (self.settings.mode === 'single') {
        i = self.items.length;
      } else {
        i = Math.max(0, Math.min(self.items.length, i));
      }

      if(!self.isPending) {
        // the input must be moved by leaving it in place and moving the
        // siblings, due to the fact that focus cannot be restored once lost
        // on mobile webkit devices
        var j, n, fn, $children, $child;
        $children = self.$control.children(':not(input)');
        for (j = 0, n = $children.length; j < n; j++) {
          $child = $($children[j]).detach();
          if (j <  i) {
            self.$control_input.before($child);
          } else {
            self.$control.append($child);
          }
        }
      }

      self.caretPos = i;
    },

    /**
     * Disables user input on the control. Used while
     * items are being asynchronously created.
     */
    lock: function() {
      this.close();
      this.isLocked = true;
      this.refreshState();
    },

    /**
     * Re-enables user input on the control.
     */
    unlock: function() {
      this.isLocked = false;
      this.refreshState();
    },

    /**
     * Disables user input on the control completely.
     * While disabled, it cannot receive focus.
     */
    disable: function() {
      var self = this;
      self.$input.prop('disabled', true);
      self.$control_input.prop('disabled', true).prop('tabindex', -1);
      self.isDisabled = true;
      self.lock();
    },

    /**
     * Enables the control so that it can respond
     * to focus and user input.
     */
    enable: function() {
      var self = this;
      self.$input.prop('disabled', false);
      self.$control_input.prop('disabled', false).prop('tabindex', self.tabIndex);
      self.isDisabled = false;
      self.unlock();
    },

    /**
     * Completely destroys the control and
     * unbinds all event listeners so that it can
     * be garbage collected.
     */
    destroy: function() {
      var self = this;
      var eventNS = self.eventNS;
      var revertSettings = self.revertSettings;

      self.trigger('destroy');
      self.off();
      self.$wrapper.remove();
      self.$dropdown.remove();

      self.$input
        .html('')
        .append(revertSettings.$children)
        .removeAttr('tabindex')
        .removeClass('selectized')
        .attr({tabindex: revertSettings.tabindex})
        .show();

      self.$control_input.removeData('grow');
      self.$input.removeData('selectize');

      $(window).off(eventNS);
      $(document).off(eventNS);
      $(document.body).off(eventNS);

      delete self.$input[0].selectize;
    },

    /**
     * A helper method for rendering "item" and
     * "option" templates, given the data.
     *
     * @param {string} templateName
     * @param {object} data
     * @returns {string}
     */
    render: function(templateName, data) {
      var value, id, label;
      var html = '';
      var cache = false;
      var self = this;
      var regex_tag = /^[\t \r\n]*<([a-z][a-z0-9\-_]*(?:\:[a-z][a-z0-9\-_]*)?)/i;

      if (templateName === 'option' || templateName === 'item') {
        value = hash_key(data[self.settings.valueField]);
        cache = !!value;
      }

      // pull markup from cache if it exists
      if (cache) {
        if (!isset(self.renderCache[templateName])) {
          self.renderCache[templateName] = {};
        }
        if (self.renderCache[templateName].hasOwnProperty(value)) {
          return self.renderCache[templateName][value];
        }
      }

      // render markup
      html = self.settings.render[templateName].apply(this, [data, escape_html]);

      // add mandatory attributes
      if (templateName === 'option' || templateName === 'option_create') {
        html = html.replace(regex_tag, '<$1 data-selectable');
      }
      if (templateName === 'optgroup') {
        id = data[self.settings.optgroupValueField] || '';
        html = html.replace(regex_tag, '<$1 data-group="' + escape_replace(escape_html(id)) + '"');
      }
      if (templateName === 'option' || templateName === 'item') {
        html = html.replace(regex_tag, '<$1 data-value="' + escape_replace(escape_html(value || '')) + '"');
      }

      // update cache
      if (cache) {
        self.renderCache[templateName][value] = html;
      }

      return html;
    },

    /**
     * Clears the render cache for a template. If
     * no template is given, clears all render
     * caches.
     *
     * @param {string} templateName
     */
    clearCache: function(templateName) {
      var self = this;
      if (typeof templateName === 'undefined') {
        self.renderCache = {};
      } else {
        delete self.renderCache[templateName];
      }
    },

    /**
     * Determines whether or not to display the
     * create item prompt, given a user input.
     *
     * @param {string} input
     * @return {boolean}
     */
    canCreate: function(input) {
      var self = this;
      if (!self.settings.create) return false;
      var filter = self.settings.createFilter;
      return input.length
        && (typeof filter !== 'function' || filter.apply(self, [input]))
        && (typeof filter !== 'string' || new RegExp(filter).test(input))
        && (!(filter instanceof RegExp) || filter.test(input));
    }

  });


  Selectize.count = 0;
  Selectize.defaults = {
    options: [],
    optgroups: [],

    plugins: [],
    delimiter: ',',
    splitOn: null, // regexp or string for splitting up values from a paste command
    persist: true,
    diacritics: true,
    create: false,
    createOnBlur: false,
    createFilter: null,
    highlight: true,
    openOnFocus: true,
    maxOptions: 1000,
    maxItems: null,
    hideSelected: null,
    addPrecedence: false,
    selectOnTab: false,
    preload: false,
    allowEmptyOption: false,
    closeAfterSelect: false,

    scrollDuration: 60,
    loadThrottle: 300,
    loadingClass: 'loading',

    dataAttr: 'data-data',
    optgroupField: 'optgroup',
    valueField: 'value',
    labelField: 'text',
    optgroupLabelField: 'label',
    optgroupValueField: 'value',
    lockOptgroupOrder: false,

    sortField: '$order',
    searchField: ['text'],
    searchConjunction: 'and',

    mode: null,
    wrapperClass: 'selectize-control',
    inputClass: 'selectize-input',
    dropdownClass: 'selectize-dropdown',
    dropdownContentClass: 'selectize-dropdown-content',

    dropdownParent: null,

    copyClassesToDropdown: true,

    /*
    load                 : null, // function(query, callback) { ... }
    score                : null, // function(search) { ... }
    onInitialize         : null, // function() { ... }
    onChange             : null, // function(value) { ... }
    onItemAdd            : null, // function(value, $item) { ... }
    onItemRemove         : null, // function(value) { ... }
    onClear              : null, // function() { ... }
    onOptionAdd          : null, // function(value, data) { ... }
    onOptionRemove       : null, // function(value) { ... }
    onOptionClear        : null, // function() { ... }
    onOptionGroupAdd     : null, // function(id, data) { ... }
    onOptionGroupRemove  : null, // function(id) { ... }
    onOptionGroupClear   : null, // function() { ... }
    onDropdownOpen       : null, // function($dropdown) { ... }
    onDropdownClose      : null, // function($dropdown) { ... }
    onType               : null, // function(str) { ... }
    onDelete             : null, // function(values) { ... }
    */

    render: {
      /*
      item: null,
      optgroup: null,
      optgroup_header: null,
      option: null,
      option_create: null
      */
    }
  };


  $.fn.selectize = function(settings_user) {
    var defaults             = $.fn.selectize.defaults;
    var settings             = $.extend({}, defaults, settings_user);
    var attr_data            = settings.dataAttr;
    var field_label          = settings.labelField;
    var field_value          = settings.valueField;
    var field_optgroup       = settings.optgroupField;
    var field_optgroup_label = settings.optgroupLabelField;
    var field_optgroup_value = settings.optgroupValueField;

    /**
     * Initializes selectize from a <input type="text"> element.
     *
     * @param {object} $input
     * @param {object} settings_element
     */
    var init_textbox = function($input, settings_element) {
      var i, n, values, option;

      var data_raw = $input.attr(attr_data);

      if (!data_raw) {
        var value = $.trim($input.val() || '');
        if (!settings.allowEmptyOption && !value.length) return;
        values = value.split(settings.delimiter);
        for (i = 0, n = values.length; i < n; i++) {
          option = {};
          option[field_label] = values[i];
          option[field_value] = values[i];
          settings_element.options.push(option);
        }
        settings_element.items = values;
      } else {
        settings_element.options = JSON.parse(data_raw);
        for (i = 0, n = settings_element.options.length; i < n; i++) {
          settings_element.items.push(settings_element.options[i][field_value]);
        }
      }
    };

    /**
     * Initializes selectize from a <select> element.
     *
     * @param {object} $input
     * @param {object} settings_element
     */
    var init_select = function($input, settings_element) {
      var i, n, tagName, $children, order = 0;
      var options = settings_element.options;
      var optionsMap = {};

      var readData = function($el) {
        var data = attr_data && $el.attr(attr_data);
        if (typeof data === 'string' && data.length) {
          return JSON.parse(data);
        }
        return null;
      };

      var addOption = function($option, group) {
        $option = $($option);

        var value = hash_key($option.attr('value'));
        if (!value && !settings.allowEmptyOption) return;

        // if the option already exists, it's probably been
        // duplicated in another optgroup. in this case, push
        // the current group to the "optgroup" property on the
        // existing option so that it's rendered in both places.
        if (optionsMap.hasOwnProperty(value)) {
          if (group) {
            var arr = optionsMap[value][field_optgroup];
            if (!arr) {
              optionsMap[value][field_optgroup] = group;
            } else if (!$.isArray(arr)) {
              optionsMap[value][field_optgroup] = [arr, group];
            } else {
              arr.push(group);
            }
          }
          return;
        }

        var option             = readData($option) || {};
        option[field_label]    = option[field_label] || $option.text();
        option[field_value]    = option[field_value] || value;
        option[field_optgroup] = option[field_optgroup] || group;

        optionsMap[value] = option;
        options.push(option);

        if ($option.is(':selected')) {
          settings_element.items.push(value);
        }
      };

      var addGroup = function($optgroup) {
        var i, n, id, optgroup, $options;

        $optgroup = $($optgroup);
        id = $optgroup.attr('label');

        if (id) {
          optgroup = readData($optgroup) || {};
          optgroup[field_optgroup_label] = id;
          optgroup[field_optgroup_value] = id;
          settings_element.optgroups.push(optgroup);
        }

        $options = $('option', $optgroup);
        for (i = 0, n = $options.length; i < n; i++) {
          addOption($options[i], id);
        }
      };

      settings_element.maxItems = $input.attr('multiple') ? null : 1;

      $children = $input.children();
      for (i = 0, n = $children.length; i < n; i++) {
        tagName = $children[i].tagName.toLowerCase();
        if (tagName === 'optgroup') {
          addGroup($children[i]);
        } else if (tagName === 'option') {
          addOption($children[i]);
        }
      }
    };

    return this.each(function() {
      if (this.selectize) return;

      var instance;
      var $input = $(this);
      var tag_name = this.tagName.toLowerCase();
      var placeholder = $input.attr('placeholder') || $input.attr('data-placeholder');
      if (!placeholder && !settings.allowEmptyOption) {
        placeholder = $input.children('option[value=""]').text();
      }

      var settings_element = {
        'placeholder' : placeholder,
        'options'     : [],
        'optgroups'   : [],
        'items'       : []
      };

      if (tag_name === 'select') {
        init_select($input, settings_element);
      } else {
        init_textbox($input, settings_element);
      }

      instance = new Selectize($input, $.extend(true, {}, defaults, settings_element, settings_user));
    });
  };

  $.fn.selectize.defaults = Selectize.defaults;
  $.fn.selectize.support = {
    validity: SUPPORTS_VALIDITY_API
  };


  Selectize.define('drag_drop', function(options) {
    if (!$.fn.sortable) throw new Error('The "drag_drop" plugin requires jQuery UI "sortable".');
    if (this.settings.mode !== 'multi') return;
    var self = this;

    self.lock = (function() {
      var original = self.lock;
      return function() {
        var sortable = self.$control.data('sortable');
        if (sortable) sortable.disable();
        return original.apply(self, arguments);
      };
    })();

    self.unlock = (function() {
      var original = self.unlock;
      return function() {
        var sortable = self.$control.data('sortable');
        if (sortable) sortable.enable();
        return original.apply(self, arguments);
      };
    })();

    self.setup = (function() {
      var original = self.setup;
      return function() {
        original.apply(this, arguments);

        var $control = self.$control.sortable({
          items: '[data-value]',
          forcePlaceholderSize: true,
          disabled: self.isLocked,
          start: function(e, ui) {
            ui.placeholder.css('width', ui.helper.css('width'));
            $control.css({overflow: 'visible'});
          },
          stop: function() {
            $control.css({overflow: 'hidden'});
            var active = self.$activeItems ? self.$activeItems.slice() : null;
            var values = [];
            $control.children('[data-value]').each(function() {
              values.push($(this).attr('data-value'));
            });
            self.setValue(values);
            self.setActiveItem(active);
          }
        });
      };
    })();

  });

  Selectize.define('dropdown_header', function(options) {
    var self = this;

    options = $.extend({
      title         : 'Untitled',
      headerClass   : 'selectize-dropdown-header',
      titleRowClass : 'selectize-dropdown-header-title',
      labelClass    : 'selectize-dropdown-header-label',
      closeClass    : 'selectize-dropdown-header-close',

      html: function(data) {
        return (
          '<div class="' + data.headerClass + '">' +
            '<div class="' + data.titleRowClass + '">' +
              '<span class="' + data.labelClass + '">' + data.title + '</span>' +
              '<a href="javascript:void(0)" class="' + data.closeClass + '">&times;</a>' +
            '</div>' +
          '</div>'
        );
      }
    }, options);

    self.setup = (function() {
      var original = self.setup;
      return function() {
        original.apply(self, arguments);
        self.$dropdown_header = $(options.html(options));
        self.$dropdown.prepend(self.$dropdown_header);
      };
    })();

  });

  Selectize.define('optgroup_columns', function(options) {
    var self = this;

    options = $.extend({
      equalizeWidth  : true,
      equalizeHeight : true
    }, options);

    this.getAdjacentOption = function($option, direction) {
      var $options = $option.closest('[data-group]').find('[data-selectable]');
      var index    = $options.index($option) + direction;

      return index >= 0 && index < $options.length ? $options.eq(index) : $();
    };

    this.onKeyDown = (function() {
      var original = self.onKeyDown;
      return function(e) {
        var index, $option, $options, $optgroup;

        if (this.isOpen && (e.keyCode === KEY_LEFT || e.keyCode === KEY_RIGHT)) {
          self.ignoreHover = true;
          $optgroup = this.$activeOption.closest('[data-group]');
          index = $optgroup.find('[data-selectable]').index(this.$activeOption);

          if(e.keyCode === KEY_LEFT) {
            $optgroup = $optgroup.prev('[data-group]');
          } else {
            $optgroup = $optgroup.next('[data-group]');
          }

          $options = $optgroup.find('[data-selectable]');
          $option  = $options.eq(Math.min($options.length - 1, index));
          if ($option.length) {
            this.setActiveOption($option);
          }
          return;
        }

        return original.apply(this, arguments);
      };
    })();

    var getScrollbarWidth = function() {
      var div;
      var width = getScrollbarWidth.width;
      var doc = document;

      if (typeof width === 'undefined') {
        div = doc.createElement('div');
        div.innerHTML = '<div style="width:50px;height:50px;position:absolute;left:-50px;top:-50px;overflow:auto;"><div style="width:1px;height:100px;"></div></div>';
        div = div.firstChild;
        doc.body.appendChild(div);
        width = getScrollbarWidth.width = div.offsetWidth - div.clientWidth;
        doc.body.removeChild(div);
      }
      return width;
    };

    var equalizeSizes = function() {
      var i, n, height_max, width, width_last, width_parent, $optgroups;

      $optgroups = $('[data-group]', self.$dropdown_content);
      n = $optgroups.length;
      if (!n || !self.$dropdown_content.width()) return;

      if (options.equalizeHeight) {
        height_max = 0;
        for (i = 0; i < n; i++) {
          height_max = Math.max(height_max, $optgroups.eq(i).height());
        }
        $optgroups.css({height: height_max});
      }

      if (options.equalizeWidth) {
        width_parent = self.$dropdown_content.innerWidth() - getScrollbarWidth();
        width = Math.round(width_parent / n);
        $optgroups.css({width: width});
        if (n > 1) {
          width_last = width_parent - width * (n - 1);
          $optgroups.eq(n - 1).css({width: width_last});
        }
      }
    };

    if (options.equalizeHeight || options.equalizeWidth) {
      hook.after(this, 'positionDropdown', equalizeSizes);
      hook.after(this, 'refreshOptions', equalizeSizes);
    }


  });

  Selectize.define('remove_button', function(options) {
    if (this.settings.mode === 'single') return;

    options = $.extend({
      label     : '&times;',
      title     : 'Remove',
      className : 'remove',
      append    : true
    }, options);

    var self = this;
    var html = '<a href="javascript:void(0)" class="' + options.className + '" tabindex="-1" title="' + escape_html(options.title) + '">' + options.label + '</a>';

    /**
     * Appends an element as a child (with raw HTML).
     *
     * @param {string} html_container
     * @param {string} html_element
     * @return {string}
     */
    var append = function(html_container, html_element) {
      var pos = html_container.search(/(<\/[^>]+>\s*)$/);
      return html_container.substring(0, pos) + html_element + html_container.substring(pos);
    };

    this.setup = (function() {
      var original = self.setup;
      return function() {
        // override the item rendering method to add the button to each
        if (options.append) {
          var render_item = self.settings.render.item;
          self.settings.render.item = function(data) {
            return append(render_item.apply(this, arguments), html);
          };
        }

        original.apply(this, arguments);

        // add event listener
        this.$control.on('click', '.' + options.className, function(e) {
          e.preventDefault();
          if (self.isLocked) return;

          var $item = $(e.currentTarget).parent();
          self.setActiveItem($item);
          if (self.deleteSelection()) {
            self.setCaret(self.items.length);
          }
        });

      };
    })();

  });

  Selectize.define('restore_on_backspace', function(options) {
    var self = this;

    options.text = options.text || function(option) {
      return option[this.settings.labelField];
    };

    this.onKeyDown = (function() {
      var original = self.onKeyDown;
      return function(e) {
        var index, option;
        if (e.keyCode === KEY_BACKSPACE && this.$control_input.val() === '' && !this.$activeItems.length) {
          index = this.caretPos - 1;
          if (index >= 0 && index < this.items.length) {
            option = this.options[this.items[index]];
            if (this.deleteSelection(e)) {
              this.setTextboxValue(options.text.apply(this, [option]));
              this.refreshOptions(true);
            }
            e.preventDefault();
            return;
          }
        }
        return original.apply(this, arguments);
      };
    })();
  });


  return Selectize;
}));

(function($) {
  if ($('input[name=slug]').length && $('input[name=title], input[name=name]').length) {
    $('input[name=title], input[name=name]').on('keyup', function() {
      var slug = $(this).val()
        .toLowerCase()
        .replace(/[^\w ]+/g,'')
        .replace(/ +/g,'-');

      $('input[name=slug]').val(slug);
    });
  }

  $('input[name=tags]').selectize({
    plugins: ['remove_button'],
    persist: false,
    preload: true,
    valueField: 'name',
    labelField: 'name',
    searchField: 'name',
    create: function(input) {
      return {
        value: input,
        text: input
      };
    },
    load: function(query, callback) {
      $.getJSON('/admin/tags', { q: query }, function(response) {
        callback(response);
      });
    }
  });

  $('select[name=series_id]').selectize();
})(jQuery);

//# sourceMappingURL=app.js.map
