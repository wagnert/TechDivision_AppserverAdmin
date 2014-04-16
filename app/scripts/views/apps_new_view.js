/**
 * The view for upload / add new apps using dropzone
 *
 * @class Appserver.AppsNewView
 * @extends Ember.View
 */
Appserver.AppsNewView = Ember.View.extend({

    retries: 0,
    maxRetries: 5,

    /**
     * Initialises the dropzone when ember rendering is finished
     *
     * @method didInsertElement
     * @return {Object}
     */
    didInsertElement: function() {
        var _this = this;

        // init dropzone.js
        Ember.$("div#upload").dropzone({
            url: Appserver.apiUrl + "/api/apps.do/upload",
            acceptedFiles: ".phar,.PHAR",
            maxFilesize: 500,
            init: function () {
                var _dropzone = this;
                // do on success
                this.on("success", function(file) {
                    _this.waitForServer();
                    return false;
                });
                // on complete reload apps
                this.on("complete", function(file) {
                    // complete file upload
                    _this.complete(_dropzone, file);
                });

            }
        });
    },

    /**
     * Waits for the appserver to come up after deployment
     *
     * @method waitForServer
     * @return {Object}
     */
    waitForServer: function() {
        // do while retries not eq maxRetries
        while(this.get('retries') < this.get('maxRetries')) {
            // wait a little above 1 sec before checking appserver to be up
            var start = new Date().getTime();
            for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > 1234){
                    break;
                }
            }
            this.pingServer();
            // inc retries
            this.set('retries', this.get('retries') + 1);
        }
    },

    /**
     * Pings the server and handles success and error responses
     *
     * @method pingServer
     * @return {Object}
     */
    pingServer: function() {
        var _this = this;
        // check if appserver is up
        Ember.$.ajax({
            type: 'GET',
            url: Appserver.apiUrl,
            async: false,
            error: function(jqXHR) {
                // check if http status came back
                if(jqXHR.status > 0) {
                    _this.set('retries', _this.get('maxRetries'));
                }
            },
            success: function() {
                _this.set('retries', _this.get('maxRetries'));
            }
        });
    },

    /**
     * Completes the waiting process
     *
     * @method didInsertElement
     * @return {Object}
     */
    complete: function(dropzone, file) {
        // clear whole store
        this.get('controller').get('controllers.apps').get('store').init();
        // reload apps
        this.get('controller').get('controllers.apps').set('content', Appserver.App.find());
        // remove file from dropzone
        dropzone.removeFile(file);
        // go back to apps overview
        this.get('controller').transitionToRoute('apps');
    }

});