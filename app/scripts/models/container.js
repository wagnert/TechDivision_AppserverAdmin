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
        address: '0.0.0.0',
        name: 'http',
        port: '8586',
        workerNumber: '16'
    },
    {
        id: 2,
        address: '0.0.0.0',
        name: 'persistence',
        port: '8586',
        workerNumber: '16'
    },
    {
        id: 3,
        address: '0.0.0.0',
        name: 'web-socket',
        port: '8586',
        workerNumber: '16'
    }
];