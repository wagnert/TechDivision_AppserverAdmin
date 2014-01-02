/**
 * The application route
 *
 * @class Appserver.ApplicationRoute
 * @extends Ember.Route
 */
Appserver.ApplicationRoute = Ember.Route.extend({

    /**
     * Forwards the requested transition to dashboard
     *
     * @method redirect
     * @return {Void}
     */
    redirect: function() {
        this.transitionTo('dashboard');
    }
});
