Appserver.Store = DS.Store.extend({

    /*
     adapter: DS.RESTAdapter.create({
     host: 'http://192.168.1.8:8586',
     url: 'http://192.168.1.8:8586',
     namespace: 'api'
     })
     */

    adapter: DS.FixtureAdapter.extend()

});