/**
 * The main store class
 *
 * @class Appserver.Store
 * @extends DS.Store
 */
Appserver.Store = DS.Store.extend({

    /**
     * Defines the RESTAdapter as main adapter
     *
     * @property adapter
     * @type {DS.RESTAdapter}
     */
    adapter: DS.RESTAdapter.extend({
        url: Appserver.apiUrl,
        host: Appserver.apiUrl,
        namespace: 'api',
        buildURL: function(record, suffix) {
            var s = this._super(record, suffix);
            return s + ".do";
        }
    })

    /**
     * Defines the FixtureAdapter as main adapter
     *
     * You could uncomment this for testing reasons
     *
     * @property adapter
     * @type {DS.FixtureAdapter}
     */
    //adapter: DS.FixtureAdapter.extend()

});