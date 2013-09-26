Appserver.App = DS.Model.extend({
	name: DS.attr('string'),
	webappPath: DS.attr('string'),
	containers: DS.hasMany('Appserver.Container')
});
