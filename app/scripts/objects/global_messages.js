/**
 * GlobalMessages Object
 * @type {*}
 */
Appserver.GlobalMessages = Ember.Object.create({

    /**
     * Default message timeout
     * @var int
     */
    defaultTimeout: 5000,

    /**
     * Message timeout for danger messages
     */
    dangerTimeout: 10000,

    /**
     * Default message type
     * @var string
     */
    defaultType: 'info',

    /**
     * Add message to object
     *
     * @param messageText
     * @param messageType
     */
    add: function (json, messageType) {
        var _this = this;
        // if no text was given return without doing anything
        if (!json || !json.message) {
            return;
        }
        var messageText = json.message;

        // if no type was given use default type
        if (!messageType) {
            messageType = _this.defaultType;
        }

        var message = Appserver.Message.createRecord({
            id: Math.floor((Math.random()*1000)+1),
            text: messageText,
            type: messageType,
            transitionLink: json.transitionLink,
            transitionLinkText: json.transitionLinkText
        });


        // scroll to top for user to see the message
        Ember.$("body").animate({ scrollTop: 0 }, "slow");

        // register timeout for message to fade out and clear
        setTimeout(function () {
            Ember.$('#message-' + message.id).fadeOut("slow", function () {
                message.deleteRecord();
            });
        }, (messageType === 'danger') ? _this.dangerTimeout : _this.defaultTimeout);
    },

    /**
     * resets all active messages
     *
     * @method reset
     * @return {Void}
     */
    reset: function () {
        // if dom ready
        Ember.$(function () {
            // iterate through all messages and delete them
            Appserver.Message.find().forEach(function (message) {
                if (message) {
                    message.deleteRecord();
                    message.save();
                }
            });
        });
    }

});