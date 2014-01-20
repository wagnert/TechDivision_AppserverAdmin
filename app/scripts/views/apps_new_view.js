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
        Ember.$("div#upload").dropzone({
            url: "/api/apps/upload",
            init: function () {

                // reinit App collection after new app was uploaded
                this.on("complete", function (file) {
                    Appserver.GlobalMessages.add({message: 'the app is uploaded'}, 'success');
                    setTimeout(function () {
                        Appserver.App.find();
                    }, 2000);
                });
            }
        });
    }

});