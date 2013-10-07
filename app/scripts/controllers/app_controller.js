Appserver.AppController = Appserver.AbstractController.extend({

    url: function () {
        return "http://localhost:8586/" + this.get('name');
    }.property()

});
