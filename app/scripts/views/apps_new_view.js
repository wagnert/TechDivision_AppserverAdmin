/**
 * The view for upload / add new apps using dropzone
 *
 * @class Appserver.AppsNewView
 * @extends Ember.View
 */
Appserver.AppsNewView = Ember.View.extend({

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
            url: Appserver.apiUrl + "/api/apps/upload",
            acceptedFiles: ".phar,.PHAR",
            init: function () {
                var _dropzone = this;
                // do on success
                this.on("success", function(file) {
                    maxRetries = 5, retries = 0;

                    // wait appserver to come up again after app deployment
                    while(retries < maxRetries) {
                        console.log(retries);
                        // wait a little above 1 sec before checking appserver to be up
                        var start = new Date().getTime();
                        for (var i = 0; i < 1e7; i++) {
                            if ((new Date().getTime() - start) > 1234){
                                break;
                            }
                        }
                        // check if appserver is up
                        $.ajax({
                            type: 'GET',
                            url: Appserver.apiUrl,
                            async: false,
                            error: function(jqXHR){
                                // check if http status came back
                                if(jqXHR.status > 0) {
                                    retries = maxRetries;
                                }
                            },
                            success: function() {
                                retries = maxRetries;
                            }
                        });

                        // inc retries
                        retries = retries + 1;
                    }
                    return false;
                });

                // on complete reload apps
                this.on("complete", function(file) {
                    // clear whole store
                    _this.get('controller').get('controllers.apps').get('store').init();
                    // get apps
                    _this.get('controller').get('controllers.apps').set('content', Appserver.App.find());
                    // remove file from dropzone
                    _dropzone.removeFile(file);
                    // go back to apps overview
                    _this.get('controller').transitionToRoute('apps');
                });

            }
        });
    }
});