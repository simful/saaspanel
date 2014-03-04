App.Router.map(function() {
	this.resource('templates', function() {
		this.route('add');
		this.route('view', { path: '/view/:id' });
		this.route('edit', { path: '/edit/:id' });
	});
});

App.Templates = Ember.Model.extend({
	id: Ember.attr(),
	name: Ember.attr(),
	protect: Ember.attr(),
	template: Ember.attr(),
	isEdit: false
});

App.Templates.url = '/templates';
App.Templates.adapter = Ember.RESTAdapter.create();

App.TemplatesAddRoute = Ember.Route.extend({
	model: function() {
		return App.Templates.create();
	}
});

App.TemplatesEditRoute = Ember.Route.extend({
	model: function(param) {
		return App.Templates.find(param.id);
	}
});

App.TemplatesViewRoute = Ember.Route.extend({
	model: function(param) {
		return App.Templates.find(param.id);
	}
});

App.TemplatesFormController = Ember.ObjectController.extend({
	init: function() {
		this._super();
	},
	actions: {
		save: function() {
			this.get('model').save();
			this.transitionTo('templates');
		},

		cancel: function() {
			this.transitionTo('templates');
		}
	}
});

App.TemplatesAddController = App.TemplatesFormController.extend();
App.TemplatesEditController = App.TemplatesFormController.extend();

App.TemplatesFormView = Em.View.extend({
	didInsertElement: function() {
		Ember.run.sync();
		Ember.run.scheduleOnce('afterRender', this, 'processElements');
	},

	processElements: function() {
		var model = this.get('model');
		this.$('.type-date').datetimepicker({
			pickTime: false
		});

	},

	willDestroyElement: function() {
		$('.s2-enabled').select2('destroy');
	}
});


App.TemplatesAddView = App.TemplatesFormView.extend();
App.TemplatesEditView = App.TemplatesFormView.extend();

App.TemplatesViewController = Ember.ObjectController.extend( {
	actions: {
		'edit': function(param) {
			this.transitionTo('templates.edit', param.id);
		},
		'confirmDelete': function(param) {
			this.get('model').set('isDeleting', true);
		}
	}
});

App.TemplatesIndexRoute = Ember.Route.extend();

App.TemplatesIndexView = Em.View.extend({
	didInsertElement: function() {
		this.$('#datatable').dataTable({
			"sDom": "ftprli",
			"bProcessing": true,
			"sAjaxSource": "/templates?dt=1",
			"aoColumns": [
				{
					"mData": null,
					"fnRender": function(obj) {
						return '<a href="#/templates/view/' + obj.aData.id + '">' + obj.aData.name + '</a>';
					}
				},
				{ "mData": "protect" },
				{ "mData": "template" },
				{
					"mData": null,
					"sWidth": '120px',
					"fnRender": function(obj) {
						return '<a class="btn btn-info btn-sm" data-edit="' + obj.aData.id + ' " href="#/templates/edit/' + obj.aData.id + '"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;<button class="btn btn-danger btn-sm delete-btn" data-summary="' + obj.aData.name + '" data-delete="' + obj.aData.id + '"><span class="glyphicon glyphicon-remove"></span></button>';
					}
				}
			]
		});

		this.$('#datatable_filter input').addClass('form-control');

		this.$().on('click', '.delete-btn', function() {
			$('#context-message').html('Are you sure you want to delete <b>' + $(this).attr('data-summary') + '</b>?');
			$('#confirmDelete').attr('data-target', '/templates/' + $(this).attr('data-delete'));
			$('#confirm-deletion').modal();
		});
	}
});