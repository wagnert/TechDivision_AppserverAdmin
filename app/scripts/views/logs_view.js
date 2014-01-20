/**
 * The live log view with websockets
 *
 * @class Appserver.LogsView
 * @extends Ember.View
 */
Appserver.LogsView = Ember.View.extend({

    /**
     * Initialises the dropzone when ember rendering is finished
     *
     * @method didInsertElement
     * @return {Object}
     */
    didInsertElement: function () {


        // init websocket connection
        var logWebsocket = new WebSocket(
            Appserver.websocketUrl + '/admin/logging'
        );
        // display data on message on content
        logWebsocket.onmessage = function (evt) {
            Ember.$('#liveLogContent').prepend(
                evt.data + "</br>"
            );
        };



    }

});