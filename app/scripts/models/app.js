/**
 * The app model definition
 *
 * @class Appserver.App
 * @extends DS.Model
 */
Appserver.App = DS.Model.extend({

    /**
     * Defines property name
     *
     * @property name
     * @type {Object}
     */
    name: DS.attr('string'),

    /**
     * Defines property thumbnail
     *
     * @property thumbnail
     * @type {Object}
     */
    thumbnail: DS.attr('string')
});

/**
 * Fixtures for testing purpose
 *
 * @property FIXTURES
 * @type {Array}
 */
Appserver.App.FIXTURES = [
    {
        id: '/admin',
        name: 'admin'
    },
    {
        id: '/demo',
        name: 'demo'
    },
    {
        id: '/testing',
        name: 'testing'
    },
    {
        id: '/example',
        name: 'example'
    },
    {
        id: '/neos',
        name: 'neos'
    },
    {
        id: '/magento',
        name: 'magento'
    }
];