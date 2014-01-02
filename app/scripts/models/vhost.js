/**
 * The vhost model definition
 *
 * @class Appserver.Vhost
 * @extends DS.Model
 */
Appserver.Vhost = DS.Model.extend({

    /**
     * Defines property name
     *
     * @property name
     * @type {Object}
     */
    name: DS.attr('string'),

    /**
     * Defines property appBase
     *
     * @property appBase
     * @type {Object}
     */
    appBase: DS.attr('string')
});

/**
 * Fixtures for testing purpose
 *
 * @property FIXTURES
 * @type {Array}
 */
Appserver.Vhost.FIXTURES = [
    {
        id: 1,
        name: 'appserver.io',
        appBase: '/site'
    },
    {
        id: 2,
        name: 'neos.appserver.io',
        appBase: '/neos'
    },
    {
        id: 3,
        name: 'admin.appserver.io',
        appBase: '/admin'
    }
];
