window.Popper = require('popper.js/dist/umd/popper');

try {
    window.$ = window.jQuery = require('jquery/dist/jquery.slim');

    require('bootstrap');
} catch (e) {}