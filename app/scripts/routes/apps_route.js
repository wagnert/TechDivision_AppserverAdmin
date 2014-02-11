require('scripts/routes/model_route');

/**
 * The route for managing apps
 *
 * @class Appserver.AppsRoute
 * @extends Ember.Route
 */
Appserver.AppsRoute = Appserver.ModelRoute.extend({

    /**
     *
     */
    beforeModel: function() {
        this.get('store').init();
    },

    /**
     * Initialises the model
     *
     * @method model
     * @return {Object}
     */
    model: function () {
        return Appserver.App.find();
    }
});