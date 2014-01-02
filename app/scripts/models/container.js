/**
 * The container model definition
 *
 * @class Appserver.Container
 * @extends DS.Model
 */
Appserver.Container = DS.Model.extend({

    /**
     * Defines property name
     *
     * @property name
     * @type {Object}
     */
    name: DS.attr('string'),

    /**
     * Defines property address
     *
     * @property address
     * @type {Object}
     */
    address: DS.attr('string'),

    /**
     * Defines property port
     *
     * @property port
     * @type {Object}
     */
    port: DS.attr('string'),

    /**
     * Defines property workerNumber
     *
     * @property workerNumber
     * @type {Object}
     */
    workerNumber: DS.attr('string')
});

/**
 * Fixtures for testing purpose
 *
 * @property FIXTURES
 * @type {Array}
 */
Appserver.Container.FIXTURES = [
    {
        id: 1,
        socket: '0.0.0.0:8586',
        name: 'http'
    },
    {
        id: 2,
        socket: '0.0.0.0:8587',
        name: 'persistence'
    },
    {
        id: 3,
        socket: '0.0.0.0:8588',
        name: 'web-socket'
    }
];