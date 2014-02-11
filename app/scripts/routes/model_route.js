/**
 * Abstract model route
 *
 * @class Appserver.ModelRoute
 * @extends Ember.Route
 */
Appserver.ModelRoute = Ember.Route.extend({

    /**
     * Inits the store before load models
     *
     * This is because the appserver generates new id's on restart
     *
     * @method model
     * @return {Void}
     */
    beforeModel: function() {
        this.get('store').init();
    }

});