Appserver.AppsNewView = Ember.View.extend({

    /**
     * Initialize javascript elements after view is rendered
     *
     * @return void
     */
    didInsertElement: function() {
        new Dropzone("div#upload", {
            url: "http://192.168.1.8:8586/api/apps/upload",
            dictDefaultMessage: "Drop your app here to upload",
            init: function () {
                this.on("complete", function (file) {
                    setTimeout(function () {
                        Appserver.App.find();
                    }, 2000);
                });
            }
        });
    }

});