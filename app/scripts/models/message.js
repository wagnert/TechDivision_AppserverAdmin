/**
 * Message Object
 * @type {*}
 */
Appserver.Message = DS.Model.extend({
    count: DS.attr('int', { defaultValue: 1 }),
    text: DS.attr('string'),
    type: DS.attr('string'),
    transitionLink: DS.attr('string'),
    transitionLinkText: DS.attr('string')
});

/**
 * Dummy data definition
 * @type {Array}
 */
Appserver.Message.FIXTURES = [
];