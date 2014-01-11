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
    appBase: DS.attr('string'),

    /**
     * Defines property containerName
     *
     * @property appBase
     * @type {Object}
     */
    containerName: DS.attr('string'),

    /**
     * Defines property port
     *
     * @property appBase
     * @type {Object}
     */
    port: DS.attr('string'),

    /**
     * Defines property address
     *
     * @property appBase
     * @type {Object}
     */
    address: DS.attr('string')
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
        appBase: '/site',
        containerName: '/http',
        port: '8586',
        address: '0.0.0.0'
    },
    {
        id: 2,
        name: 'neos.appserver.io',
        appBase: '/neos',
        containerName: '/http',
        port: '8586',
        address: '0.0.0.0'
    },
    {
        id: 3,
        name: 'admin.appserver.io',
        appBase: '/admin',
        containerName: '/http',
        port: '8586',
        address: '0.0.0.0'
    }
];
