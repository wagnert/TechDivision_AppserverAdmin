/**
 * The main ember application class
 *
 * @class Appserver
 * @extends Ember.Application
 */
var Appserver = window.Appserver = Ember.Application.create({

    /**
     * Defines the url for rest api service
     *
     * @property apiUrl
     * @type {String}
     * @default ""
     */
    apiUrl: ''

});
/* Disable auto discover on dropzone */
Dropzone.autoDiscover = false;

/**
 * Requires local script if exists.
 *
 * You can use that to modify e.g. the apiUrl in local dev environment
 * by putting this into app/scripts/local.js file
 *
 * Appserver.apiUrl = 'http://127.0.0.1:8586';
 */
require('scripts/local');
// require all needed stuff
require('scripts/controllers/*');
require('scripts/store');
require('scripts/models/*');
require('scripts/routes/*');
require('scripts/views/widgets/*');
require('scripts/views/*');
require('scripts/router');