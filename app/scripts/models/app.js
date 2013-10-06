Appserver.App = DS.Model.extend({
    name: DS.attr('string'),
    webappPath: DS.attr('string'),
    containers: DS.hasMany('Appserver.Container')
});

Appserver.App.FIXTURES = [
    {
        id: 1,
        name: 'example',
        webappPath: '/opt/appserver/webapps',
        containers: [1, 2, 3]
    },
    {
        id: 2,
        name: 'neos',
        webappPath: '/opt/appserver/webapps',
        containers: [1, 2]
    },
    {
        id: 3,
        name: 'magento',
        webappPath: '/opt/appserver/webapps',
        containers: [1, 2]
    }
];