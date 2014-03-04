App = Ember.Application.create();

Ember.Handlebars.helper('timeago', function(value, options) {
	return new moment(value).fromNow(true);
});

Ember.Handlebars.helper('money', function(value, options) {
	return accounting.formatMoney(value);
});

App.ApplicationRoute = Ember.Route.extend({
	model: function() {
		return new Ember.RSVP.Promise(function(resolve) {
			$.getJSON('/me', function(data) {
				resolve(data);
			});
		});
	}
});

App.ApplicationView = Ember.View.extend({
	didInsertElement: function() {
		// delete confirmation
		this.$('#confirmDelete').click(function() {
			var btn = $(this);

			if (btn.attr('data-target')) {
				$.ajax({
					type: 'delete',
					url: btn.attr('data-target'),
					success: function(data) {
						$('#confirm-deletion').modal('hide');
					}
				});
			}
		});
	}
});

App.EditorView = Em.TextArea.extend({
	didInsertElement: function() {
		this._super();
		var self = this;

		var elementId = self.get('elementId');

		var editor = CKEDITOR.replace(elementId, { allowedContent: true });

		editor.on('change', function(e) {
			if (e.editor.checkDirty()) {
				self.set('value', editor.getData());
			}
		});
	}
});

App.DateField = Ember.TextField.extend({
	didInsertElement: function() {
		this.$().datetimepicker({
			pickTime: false,
			format: 'YYYY-MM-DD'
		});
	}
});

App.IndexRoute = Ember.Route.extend({
	model: function() {
		return new Ember.RSVP.Promise(function(resolve) {
			$.getJSON('/dashboard', function(data) {
				resolve(data);
			});
		});
	}
});

App.Select2 = Ember.Select.extend({
	didInsertElement: function() {
		Ember.run.scheduleOnce('afterRender', this, 'processChildElements');
 	},

	processChildElements: function() {
		var options = {};

		options.placeholder = 'Select an option';
		options.allowClear = true;
		options.closeOnSelect = true;
		options.width ='100%';
		this.$().select2(options);
	},

	willDestroyElement: function () {
		this.$().select2("destroy");
	},

	valueDidChange : function(){
		this.$().select2('val', this.$().val());
	}.observes('value')
	

});

App.Router.map(function() {
	this.resource('profile');
});

App.ProfileRoute = Ember.Route.extend({
	model: function() {
		return new Ember.RSVP.Promise(function(resolve) {
			$.getJSON('/me', function(data) {
				resolve(data);
			});
		});
	}
});