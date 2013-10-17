Appserver.App = DS.Model.extend({
    name: DS.attr('string'),
    thumbnail: DS.attr('string'),
    webappPath: DS.attr('string'),
    containers: DS.hasMany('Appserver.Container')
});

Appserver.App.FIXTURES = [
    {
        id: 1,
        name: 'admin',
        webappPath: '/opt/appserver/webapps',
        containers: [1, 2, 3]
    },
    {
        id: 2,
        name: 'demo',
        webappPath: '/opt/appserver/webapps',
        containers: [1, 2, 3]
    },
    {
        id: 3,
        name: 'testing',
        webappPath: '/opt/appserver/webapps',
        containers: [1, 2, 3]
    },
    {
        id: 4,
        name: 'example',
        webappPath: '/opt/appserver/webapps',
        containers: [1, 2, 3]
    },
    {
        id: 5,
        name: 'neos',
        thumbnail: 'images/app-thumbnail-neos.png',
        webappPath: '/opt/appserver/webapps',
        containers: [1, 2]
    },
    {
        id: 6,
        name: 'magento',
        thumbnail: 'images/app-thumbnail-magento.png',
        webappPath: '/opt/appserver/webapps',
        containers: [1, 2]
    }
];