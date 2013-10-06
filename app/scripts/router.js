Appserver.Router.map(function () {

    this.resource('dashboard');

    this.resource('apps', function () {
        this.route('new');
    });

    this.resource('vhosts', function () {
        this.route('new');
    });

    this.resource('containers', function () {
        this.route('new');
    });

    this.resource('logs');

});