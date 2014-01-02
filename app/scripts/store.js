Appserver.Store = DS.Store.extend({

    adapter: DS.RESTAdapter.create({
    host: 'http://127.0.0.1:8586',
    url: 'http://127.0.0.1:8586',
    namespace: 'api'
    })

    // adapter: DS.FixtureAdapter.extend()

});