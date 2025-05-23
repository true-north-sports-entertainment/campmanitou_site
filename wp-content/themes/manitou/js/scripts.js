/*-----------------------------------------
	 	   ALL MANITOU SCRIPTS 
-----------------------------------------*/

/*------ ANCHOR LINKS ------*/

$('.anchorLink').click(function(){
    $('html, body').animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top
    }, 500);
    return false;
});


/*------ MOBILE SIDEBAR MENU------*/
$(document).ready(function() {
	    // show sidebar and overlay
	    function showSidebar() {
	        sidebar.css('margin-left', '0');
	
	        overlay.show(0, function() {
	            overlay.fadeTo('500', 0.5);
	        });   
	    }
	
	    // hide sidebar and overlay
	    function hideSidebar() {
	        sidebar.css('margin-left', sidebar.width() * -1 + 'px');
	
	        overlay.fadeTo('500', 0, function() {
	            overlay.hide();
	        });;
	    }
	
	    // selectors
	    var sidebar = $('[data-sidebar]');
	    var button = $('[data-sidebar-button]');
	    var overlay = $('[data-sidebar-overlay]');
	
	    // add height to content area
	    overlay.parent().css('min-height', 'inherit');
	
	    // hide sidebar on load
	    sidebar.css('margin-left', sidebar.width() * -1 + 'px');
	
	    sidebar.show(0, function() {
	        sidebar.css('transition', 'all 0.5s ease');
	    });
	
	    // toggle sidebar on click
	    button.click(function() {
	        if (overlay.is(':visible')) {
	            hideSidebar();
	        } else {
	            showSidebar();
	        }
	
	        return false;
	    });
	
	    // hide sidebar on overlay click
	    overlay.click(function() {
	        hideSidebar();
	    });
	});

/* ------ANIMATED HEADER ------*/
// var cbpAnimatedHeader = (function() {

// 	var docElem = document.documentElement,
// 		header = document.querySelector( '.outer-header' ),
// 		didScroll = false,
// 		changeHeaderOn = 50;

// 	function init() {
// 		window.addEventListener( 'scroll', function( event ) {
// 			if( !didScroll ) {
// 				didScroll = true;
// 				setTimeout( scrollPage, 250 );
// 			}
// 		}, false );
// 	}

// 	function scrollPage() {
// 		var sy = scrollY();
// 		if ( sy >= changeHeaderOn ) {
// 			classie.add( header, 'outer-header-shrink' );
// 		}
// 		else {
// 			classie.remove( header, 'outer-header-shrink' );
// 		}
// 		didScroll = false;
// 	}

// 	function scrollY() {
// 		return window.pageYOffset || docElem.scrollTop;
// 	}

// 	init();

// })();

/*!
 * classie - class helper functions
 * from bonzo https://github.com/ded/bonzo
 * 
 * classie.has( elem, 'my-class' ) -> true/false
 * classie.add( elem, 'my-new-class' )
 * classie.remove( elem, 'my-unwanted-class' )
 * classie.toggle( elem, 'my-class' )
 */

/*jshint browser: true, strict: true, undef: true */
/*global define: false */

( function( window ) {

'use strict';

// class helper functions from bonzo https://github.com/ded/bonzo

function classReg( className ) {
  return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
}

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
var hasClass, addClass, removeClass;

if ( 'classList' in document.documentElement ) {
  hasClass = function( elem, c ) {
    return elem.classList.contains( c );
  };
  addClass = function( elem, c ) {
    elem.classList.add( c );
  };
  removeClass = function( elem, c ) {
    elem.classList.remove( c );
  };
}
else {
  hasClass = function( elem, c ) {
    return classReg( c ).test( elem.className );
  };
  addClass = function( elem, c ) {
    if ( !hasClass( elem, c ) ) {
      elem.className = elem.className + ' ' + c;
    }
  };
  removeClass = function( elem, c ) {
    elem.className = elem.className.replace( classReg( c ), ' ' );
  };
}

function toggleClass( elem, c ) {
  var fn = hasClass( elem, c ) ? removeClass : addClass;
  fn( elem, c );
}

var classie = {
  // full names
  hasClass: hasClass,
  addClass: addClass,
  removeClass: removeClass,
  toggleClass: toggleClass,
  // short names
  has: hasClass,
  add: addClass,
  remove: removeClass,
  toggle: toggleClass
};

// transport
if ( typeof define === 'function' && define.amd ) {
  // AMD
  define( classie );
} else {
  // browser global
  window.classie = classie;
}

})( window );

/*---- ACCORDION ------*/

$('.collapse').on('shown.bs.collapse', function(){
$(this).parent().find(".icon-plus").removeClass("icon-plus").addClass("icon-minus");
}).on('hidden.bs.collapse', function(){
$(this).parent().find(".icon-minus").removeClass("icon-minus").addClass("icon-plus");
});



  // ADD SLIDEDOWN ANIMATION TO DROPDOWN //
  $('.dropdown').on('show.bs.dropdown', function(e){
    $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
  });

  // ADD SLIDEUP ANIMATION TO DROPDOWN //
  $('.dropdown').on('hide.bs.dropdown', function(e){
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
  });

/*---------------------------------------------- 
	ACCESSIBLE NAVIGATION (For Sub-menu)
----------------------------------------------*/

// Keyboard Menu Navigation
window.timber = window.timber || {};

$(function() {
  timber.cache = {
    // General
    $html: $('html'),
    $body: $('body'),

    // Navigation
    $navigation: $('#accessibleNav')
  };
});

timber.accessibleNav = function () {
  var $nav = timber.cache.$navigation,
      $allLinks = $nav.find('a'),
      $topLevel = $nav.children('li').find('a'),
      $parents = $nav.find('.menu-item-has-children'),
      $subMenuLinks = $nav.find('.sub-menu').find('a'),
      activeClass = 'nav-hover',
      focusClass = 'nav-focus';
  
  if ('ontouchstart' in window) {
    timber.cache.$html.removeClass('no-touch').addClass('supports-touch');
  }

  // Mouseenter
  $parents.on('mouseenter touchstart', function(evt) {
    var $el = $(this);

    if (!$el.hasClass(activeClass)) {
      evt.preventDefault();
    }

    showDropdown($el);
  });

  $parents.on('mouseleave', function() {
    hideDropdown($(this));
  });

  $subMenuLinks.on('touchstart', function(evt) {
    // Prevent touchstart on body from firing instead of link
    evt.stopImmediatePropagation();
  });

  $allLinks.focus(function() {
    handleFocus($(this));
  });

  $allLinks.blur(function() {
    removeFocus($topLevel);
  });

  // accessibleNav private methods
  function handleFocus ($el) {
    var $subMenu = $el.next('ul');
        hasSubMenu = $subMenu.hasClass('sub-menu') ? true : false,
        isSubItem = $('.sub-menu').has($el).length,
        $newFocus = null;

    // Add focus class for top level items, or keep menu shown
    if ( !isSubItem ) {
      removeFocus($topLevel);
      addFocus($el);
    } else {
      $newFocus = $el.closest('.menu-item-has-children').find('a');
      addFocus($newFocus);
    }
  }

  function showDropdown ($el) {
    $el.addClass(activeClass);

    setTimeout(function() {
      timber.cache.$body.on('touchstart', function() {
        hideDropdown($el);
      });
    }, 250);
  }

  function hideDropdown ($el) {
    $el.removeClass(activeClass);
    timber.cache.$body.off('touchstart');
  }

  function addFocus ($el) {
    $el.addClass(focusClass);
  }

  function removeFocus ($el) {
    $el.removeClass(focusClass);
  }
}

// Initialize Timber's JS on docready
$(function() {
  window.timber.accessibleNav();
});


/*------ BOOTSTRAP ------*/


if("undefined"==typeof jQuery)throw new Error("Bootstrap's JavaScript requires jQuery");+function(t){"use strict";var e=t.fn.jquery.split(" ")[0].split(".");if(e[0]<2&&e[1]<9||1==e[0]&&9==e[1]&&e[2]<1)throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher")}(jQuery),+function(t){"use strict";function e(e){var n=e.attr("data-target");n||(n=e.attr("href"),n=n&&/#[A-Za-z]/.test(n)&&n.replace(/.*(?=#[^\s]*$)/,""));var s=n&&t(n);return s&&s.length?s:e.parent()}function n(n){n&&3===n.which||(t(i).remove(),t(o).each(function(){var s=t(this),i=e(s),o={relatedTarget:this};i.hasClass("open")&&(n&&"click"==n.type&&/input|textarea/i.test(n.target.tagName)&&t.contains(i[0],n.target)||(i.trigger(n=t.Event("hide.bs.dropdown",o)),n.isDefaultPrevented()||(s.attr("aria-expanded","false"),i.removeClass("open").trigger("hidden.bs.dropdown",o))))}))}function s(e){return this.each(function(){var n=t(this),s=n.data("bs.dropdown");s||n.data("bs.dropdown",s=new r(this)),"string"==typeof e&&s[e].call(n)})}var i=".dropdown-backdrop",o='[data-toggle="dropdown"]',r=function(e){t(e).on("click.bs.dropdown",this.toggle)};r.VERSION="3.3.5",r.prototype.toggle=function(s){var i=t(this);if(!i.is(".disabled, :disabled")){var o=e(i),r=o.hasClass("open");if(n(),!r){"ontouchstart"in document.documentElement&&!o.closest(".navbar-nav").length&&t(document.createElement("div")).addClass("dropdown-backdrop").insertAfter(t(this)).on("click",n);var a={relatedTarget:this};if(o.trigger(s=t.Event("show.bs.dropdown",a)),s.isDefaultPrevented())return;i.trigger("focus").attr("aria-expanded","true"),o.toggleClass("open").trigger("shown.bs.dropdown",a)}return!1}},r.prototype.keydown=function(n){if(/(38|40|27|32)/.test(n.which)&&!/input|textarea/i.test(n.target.tagName)){var s=t(this);if(n.preventDefault(),n.stopPropagation(),!s.is(".disabled, :disabled")){var i=e(s),r=i.hasClass("open");if(!r&&27!=n.which||r&&27==n.which)return 27==n.which&&i.find(o).trigger("focus"),s.trigger("click");var a=" li:not(.disabled):visible a",l=i.find(".dropdown-menu"+a);if(l.length){var d=l.index(n.target);38==n.which&&d>0&&d--,40==n.which&&d<l.length-1&&d++,~d||(d=0),l.eq(d).trigger("focus")}}}};var a=t.fn.dropdown;t.fn.dropdown=s,t.fn.dropdown.Constructor=r,t.fn.dropdown.noConflict=function(){return t.fn.dropdown=a,this},t(document).on("click.bs.dropdown.data-api",n).on("click.bs.dropdown.data-api",".dropdown form",function(t){t.stopPropagation()}).on("click.bs.dropdown.data-api",o,r.prototype.toggle).on("keydown.bs.dropdown.data-api",o,r.prototype.keydown).on("keydown.bs.dropdown.data-api",".dropdown-menu",r.prototype.keydown)}(jQuery),+function(t){"use strict";function e(e){var n,s=e.attr("data-target")||(n=e.attr("href"))&&n.replace(/.*(?=#[^\s]+$)/,"");return t(s)}function n(e){return this.each(function(){var n=t(this),i=n.data("bs.collapse"),o=t.extend({},s.DEFAULTS,n.data(),"object"==typeof e&&e);!i&&o.toggle&&/show|hide/.test(e)&&(o.toggle=!1),i||n.data("bs.collapse",i=new s(this,o)),"string"==typeof e&&i[e]()})}var s=function(e,n){this.$element=t(e),this.options=t.extend({},s.DEFAULTS,n),this.$trigger=t('[data-toggle="collapse"][href="#'+e.id+'"],[data-toggle="collapse"][data-target="#'+e.id+'"]'),this.transitioning=null,this.options.parent?this.$parent=this.getParent():this.addAriaAndCollapsedClass(this.$element,this.$trigger),this.options.toggle&&this.toggle()};s.VERSION="3.3.5",s.TRANSITION_DURATION=350,s.DEFAULTS={toggle:!0},s.prototype.dimension=function(){var t=this.$element.hasClass("width");return t?"width":"height"},s.prototype.show=function(){if(!this.transitioning&&!this.$element.hasClass("in")){var e,i=this.$parent&&this.$parent.children(".panel").children(".in, .collapsing");if(!(i&&i.length&&(e=i.data("bs.collapse"),e&&e.transitioning))){var o=t.Event("show.bs.collapse");if(this.$element.trigger(o),!o.isDefaultPrevented()){i&&i.length&&(n.call(i,"hide"),e||i.data("bs.collapse",null));var r=this.dimension();this.$element.removeClass("collapse").addClass("collapsing")[r](0).attr("aria-expanded",!0),this.$trigger.removeClass("collapsed").attr("aria-expanded",!0),this.transitioning=1;var a=function(){this.$element.removeClass("collapsing").addClass("collapse in")[r](""),this.transitioning=0,this.$element.trigger("shown.bs.collapse")};if(!t.support.transition)return a.call(this);var l=t.camelCase(["scroll",r].join("-"));this.$element.one("bsTransitionEnd",t.proxy(a,this)).emulateTransitionEnd(s.TRANSITION_DURATION)[r](this.$element[0][l])}}}},s.prototype.hide=function(){if(!this.transitioning&&this.$element.hasClass("in")){var e=t.Event("hide.bs.collapse");if(this.$element.trigger(e),!e.isDefaultPrevented()){var n=this.dimension();this.$element[n](this.$element[n]())[0].offsetHeight,this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded",!1),this.$trigger.addClass("collapsed").attr("aria-expanded",!1),this.transitioning=1;var i=function(){this.transitioning=0,this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")};return t.support.transition?void this.$element[n](0).one("bsTransitionEnd",t.proxy(i,this)).emulateTransitionEnd(s.TRANSITION_DURATION):i.call(this)}}},s.prototype.toggle=function(){this[this.$element.hasClass("in")?"hide":"show"]()},s.prototype.getParent=function(){return t(this.options.parent).find('[data-toggle="collapse"][data-parent="'+this.options.parent+'"]').each(t.proxy(function(n,s){var i=t(s);this.addAriaAndCollapsedClass(e(i),i)},this)).end()},s.prototype.addAriaAndCollapsedClass=function(t,e){var n=t.hasClass("in");t.attr("aria-expanded",n),e.toggleClass("collapsed",!n).attr("aria-expanded",n)};var i=t.fn.collapse;t.fn.collapse=n,t.fn.collapse.Constructor=s,t.fn.collapse.noConflict=function(){return t.fn.collapse=i,this},t(document).on("click.bs.collapse.data-api",'[data-toggle="collapse"]',function(s){var i=t(this);i.attr("data-target")||s.preventDefault();var o=e(i),r=o.data("bs.collapse"),a=r?"toggle":i.data();n.call(o,a)})}(jQuery),+function(t){"use strict";function e(n,s){this.$body=t(document.body),this.$scrollElement=t(t(n).is(document.body)?window:n),this.options=t.extend({},e.DEFAULTS,s),this.selector=(this.options.target||"")+" .nav li > a",this.offsets=[],this.targets=[],this.activeTarget=null,this.scrollHeight=0,this.$scrollElement.on("scroll.bs.scrollspy",t.proxy(this.process,this)),this.refresh(),this.process()}function n(n){return this.each(function(){var s=t(this),i=s.data("bs.scrollspy"),o="object"==typeof n&&n;i||s.data("bs.scrollspy",i=new e(this,o)),"string"==typeof n&&i[n]()})}e.VERSION="3.3.5",e.DEFAULTS={offset:10},e.prototype.getScrollHeight=function(){return this.$scrollElement[0].scrollHeight||Math.max(this.$body[0].scrollHeight,document.documentElement.scrollHeight)},e.prototype.refresh=function(){var e=this,n="offset",s=0;this.offsets=[],this.targets=[],this.scrollHeight=this.getScrollHeight(),t.isWindow(this.$scrollElement[0])||(n="position",s=this.$scrollElement.scrollTop()),this.$body.find(this.selector).map(function(){var e=t(this),i=e.data("target")||e.attr("href"),o=/^#./.test(i)&&t(i);return o&&o.length&&o.is(":visible")&&[[o[n]().top+s,i]]||null}).sort(function(t,e){return t[0]-e[0]}).each(function(){e.offsets.push(this[0]),e.targets.push(this[1])})},e.prototype.process=function(){var t,e=this.$scrollElement.scrollTop()+this.options.offset,n=this.getScrollHeight(),s=this.options.offset+n-this.$scrollElement.height(),i=this.offsets,o=this.targets,r=this.activeTarget;if(this.scrollHeight!=n&&this.refresh(),e>=s)return r!=(t=o[o.length-1])&&this.activate(t);if(r&&e<i[0])return this.activeTarget=null,this.clear();for(t=i.length;t--;)r!=o[t]&&e>=i[t]&&(void 0===i[t+1]||e<i[t+1])&&this.activate(o[t])},e.prototype.activate=function(e){this.activeTarget=e,this.clear();var n=this.selector+'[data-target="'+e+'"],'+this.selector+'[href="'+e+'"]',s=t(n).parents("li").addClass("active");s.parent(".dropdown-menu").length&&(s=s.closest("li.dropdown").addClass("active")),s.trigger("activate.bs.scrollspy")},e.prototype.clear=function(){t(this.selector).parentsUntil(this.options.target,".active").removeClass("active")};var s=t.fn.scrollspy;t.fn.scrollspy=n,t.fn.scrollspy.Constructor=e,t.fn.scrollspy.noConflict=function(){return t.fn.scrollspy=s,this},t(window).on("load.bs.scrollspy.data-api",function(){t('[data-spy="scroll"]').each(function(){var e=t(this);n.call(e,e.data())})})}(jQuery),+function(t){"use strict";function e(){var t=document.createElement("bootstrap"),e={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var n in e)if(void 0!==t.style[n])return{end:e[n]};return!1}t.fn.emulateTransitionEnd=function(e){var n=!1,s=this;t(this).one("bsTransitionEnd",function(){n=!0});var i=function(){n||t(s).trigger(t.support.transition.end)};return setTimeout(i,e),this},t(function(){t.support.transition=e(),t.support.transition&&(t.event.special.bsTransitionEnd={bindType:t.support.transition.end,delegateType:t.support.transition.end,handle:function(e){return t(e.target).is(this)?e.handleObj.handler.apply(this,arguments):void 0}})})}(jQuery);
