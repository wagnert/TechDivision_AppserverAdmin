/**
 * A controller for app functionality
 *
 * @class Appserver.AppController
 * @extends Appserver.AbstractController
 */
Appserver.AppController = Appserver.AbstractController.extend({

    url: function () {
        return Appserver.apiUrl + '/' + this.get('name');
    }.property()

});
