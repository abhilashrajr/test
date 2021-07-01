/* -----------------------------------------------------------------------------

Soup - Restaurant with Online Ordering System Template

File:           JS Core
Version:        2.00
Last change:    22/05/2020
Author:         Suelo (Piotr Osmola)

-------------------------------------------------------------------------------- */

'use strict'



// Import Modules
import PageTransition from './modules/page-transition.js'
import BackToTop from './modules/back-to-top.js'
import Background from './modules/background.js'
import Carousel from './modules/carousel.js'
import Cart from './modules/cart.js'
import Collapse from './modules/collapse.js'
import Cookies from './modules/cookies.js'
import Components from './modules/components.js'
import CustomControl from './modules/custom-control.js'
import Forms from './modules/forms.js'
import GoogleMap from './modules/google-map.js'
import Navigation from './modules/navigation.js'
import Modal from './modules/modal.js'
import Parallax from './modules/parallax.js'
import Sticky from './modules/sticky.js'
import Twitter from './modules/twitter.js'
import Docs from './modules/docs.js'

// Document - Ready
$(function() {
  Background.init()
  BackToTop.init()
  Carousel.init()
  Cart.init()
  Collapse.init()
  Cookies.init()
  Components.init()
  CustomControl.init()
  Forms.init()
  GoogleMap.init()
  Navigation.init()
  Modal.init()
  PageTransition.init()
  Parallax.init()
  Sticky.init()
  Twitter.init()
  Docs.init()

  if (process.env.PREVIEW) {
    const Styleswitcher = require('./modules/styleswitcher')
    Styleswitcher.default.init()
  }
})

// Document - Click
$(document).on('click', function(e) {
  Navigation.handleClick(e)
  Cart.Panel.handleClick(e)
})

let scrolled = 0

// Window - Scroll
$(window).on('scroll', function() {
  scrolled = $(window).scrollTop()

  BackToTop.handleScroll(scrolled)
  Sticky.handleScroll(scrolled)
})
