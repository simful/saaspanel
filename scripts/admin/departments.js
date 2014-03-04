App.Router.map(function() {
	this.resource('departments', function() {
		this.route('add');
		this.route('view', { path: '/view/:id' });
		this.route('edit', { path: '/edit/:id' });
	});
});

App.Departments = Ember.Model.extend({
	name: Ember.attr(),
	isEdit: false
});

App.Departments.url = '/departments';
App.Departments.adapter = Ember.RESTAdapter.create();

App.DepartmentsAddRoute = Ember.Route.extend({
	model: function() {
		return App.Departments.create();
	}
});

App.DepartmentsEditRoute = Ember.Route.extend({
	model: function(param) {
		return App.Departments.find(param.id);
	}
});

App.DepartmentsViewRoute = Ember.Route.extend({
	model: function(param) {
		return App.Departments.find(param.id);
	}
});

App.DepartmentsFormController = Ember.ObjectController.extend({
	actions: {
		save: function() {
			this.get('model').save();
			this.transitionTo('departments');
		},

		cancel: function() {
			this.transitionTo('departments');
		}
	}
});

App.DepartmentsAddController = App.DepartmentsFormController.extend();
App.DepartmentsEditController = App.DepartmentsFormController.extend();

App.DepartmentsFormView = Em.View.extend({
	didInsertElement: function() {
		Ember.run.sync();
		Ember.run.scheduleOnce('afterRender', this, 'processElements');
		//this.addObserver('controller.model', this.processElements);
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


App.DepartmentsAddView = App.DepartmentsFormView.extend();
App.DepartmentsEditView = App.DepartmentsFormView.extend();

App.DepartmentsViewController = Ember.ObjectController.extend( {
	actions: {
		'edit': function(param) {
			this.transitionTo('departments.edit', param.id);
		},
		'confirmDelete': function(param) {
			this.get('model').set('isDeleting', true);
		}
	}
});

App.DepartmentsIndexRoute = Ember.Route.extend();

App.DepartmentsIndexView = Em.View.extend({
	didInsertElement: function() {
		this.$('#datatable').dataTable({
			"sDom": "ftprli",
			"bProcessing": true,
			"sAjaxSource": "/departments?dt=1",
			"aoColumns": [
				{
					"mData": null,
					"fnRender": function(obj) {
						return '<a href="#/departments/view/' + obj.aData.id + '">' + obj.aData.name + '</a>';
					}
				},
				{
					"mData": null,
					"sWidth": '120px',
					"fnRender": function(obj) {
						return '<a class="btn btn-info btn-sm" data-edit="' + obj.aData.id + ' " href="#/departments/edit/' + obj.aData.id + '"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;<button class="btn btn-danger btn-sm delete-btn" data-summary="' + obj.aData.name + '" data-delete="' + obj.aData.id + '"><span class="glyphicon glyphicon-remove"></span></button>';
					}
				}
			]
		});

		this.$('#datatable_filter input').addClass('form-control');

		this.$().on('click', '.delete-btn', function() {
			$('#context-message').html('Are you sure you want to delete <b>' + $(this).attr('data-summary') + '</b>?');
			$('#confirmDelete').attr('data-target', '/departments/' + $(this).attr('data-delete'));
			$('#confirm-deletion').modal();
		});
	}
});