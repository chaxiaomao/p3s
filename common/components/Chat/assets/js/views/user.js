Chat.Views.UserView = Backbone.View.extend({
    model: Chat.Models.User,
    template: '#user-tpl',
    tagName: 'a',
    className: 'list-group-item',
    attributes: {
        href: '#',
        'data-toggle': 'tooltip',
        'data-placement': 'right',
        title: Helper.t('Send message')
    },
    events: {
        'click': 'selectItem'
    },
    initialize: function() {
        this.model.on('remove', this.remove, this);
    },
    render: function() {
        var template = _.template($(this.template).html());
//        console.log(this.model.toJSON());
//        console.log(template(this.model.toJSON()));
        this.$el.html(template(this.model.toJSON()));
        return this;
    },
    remove: function() {
        this.$el.remove();
    },
    selectItem: function(e) {
        e.preventDefault();
        Chat.vent.trigger('user:select', this.$el.text().trim());
    }
});