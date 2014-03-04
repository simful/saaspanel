App.Router.map(function() {
	this.resource('service_options', function() {
		this.route('add');
		this.route('view', { path: '/view/:id' });
		this.route('edit', { path: '/edit/:id' });
	});
});

App.ServiceOptions = Ember.Model.extend({
	id: Ember.attr(),
	service: Ember.belongsTo('App.Services', { key: 'service_id' }),
	option_name: Ember.attr(),
	base_price: Ember.attr(),
	description: Ember.attr(),
	isEdit: false
});

App.ServiceOptions.url = '/service_options';
App.ServiceOptions.adapter = Ember.RESTAdapter.create();

App.ServiceOptionsAddRoute = Ember.Route.extend({
	model: function() {
		return App.ServiceOptions.create();
	}
});

App.ServiceOptionsEditRoute = Ember.Route.extend({
	model: function(param) {
		return App.ServiceOptions.find(param.id);
	}
});

App.ServiceOptionsViewRoute = Ember.Route.extend({
	model: function(param) {
		return App.ServiceOptions.find(param.id);
	}
});

App.ServiceOptionsFormController = Ember.ObjectController.extend({
	init: function() {
		this._super();
		this.set('service_id_array', App.Services.find());
	},
	actions: {
		save: function() {
			this.get('model').save();
			this.transitionTo('service_options');
		},

		cancel: function() {
			this.transitionTo('service_options');
		}
	}
});

App.ServiceOptionsAddController = App.ServiceOptionsFormController.extend();
App.ServiceOptionsEditController = App.ServiceOptionsFormController.extend();

App.ServiceOptionsFormView = Em.View.extend({
	didInsertElement: function() {
		Ember.run.sync();
		Ember.run.scheduleOnce('afterRender', this, 'processElements');
	},

	processElements: function() {
		var model = this.get('model');
		this.$('.type-date').datetimepicker({
			pickTime: false
		});

		this.$('#service_id').addClass('s2-enabled').select2({
			placeholder: "Select an option",
			ajax: {
				url: '/services',
				dataType: 'json',
				data: function (term, page) {
					return {
						term: term,
						limit: 10,
						col: 'id'
					}
				},
				results: function (data, page) {
					return { results: data }
				}
			},
			initSelection: function(element, callback) {
				if (element.val() !== "") {
					$.getJSON('/services/' + element.val(), function(data) {
						callback(data);
					});
				}
			},

			formatResult: function(obj, container, query) {
				return obj.id;
			},

			formatSelection: function(obj, container) {
				return obj.id;
			},

			id: function(obj) {
				return obj.id;
			},

			selectedDidChange : function(){
				this.$().select2('val', this.get('value').split(','));  
			}.observes('value')
		});
	},

	willDestroyElement: function() {
		$('.s2-enabled').select2('destroy');
	}
});


App.ServiceOptionsAddView = App.ServiceOptionsFormView.extend();
App.ServiceOptionsEditView = App.ServiceOptionsFormView.extend();

App.ServiceOptionsViewController = Ember.ObjectController.extend( {
	actions: {
		'edit': function(param) {
			this.transitionTo('service_options.edit', param.id);
		},
		'confirmDelete': function(param) {
			this.get('model').set('isDeleting', true);
		}
	}
});

App.ServiceOptionsIndexRoute = Ember.Route.extend();

App.ServiceOptionsIndexView = Em.View.extend({
	didInsertElement: function() {
		this.$('#datatable').dataTable({
			"sDom": "ftprli",
			"bProcessing": true,
			"sAjaxSource": "/service_options?dt=1",
			"aoColumns": [
				{
					"mData": "service_id",
					"fnRender": function(obj) {
						return '<a href="#/services/view/' + obj.aData.service_id + '">' + obj.aData.service + '</a>';
					}
				},
				{
					"mData": null,
					"fnRender": function(obj) {
						return '<a href="#/service_options/view/' + obj.aData.id + '">' + obj.aData.option_name + '</a>';
					}
				},
				{
					"mData": "base_price",
					"fnRender": function(obj) {
						return '$<span class="pull-right">' + accounting.formatNumber(obj.aData.base_price) + '</span>';
					}
				},
				{ "mData": "description" },
				{
					"mData": null,
					"sWidth": '120px',
					"fnRender": function(obj) {
						return '<a class="btn btn-info btn-sm" data-edit="' + obj.aData.id + ' " href="#/service_options/edit/' + obj.aData.id + '"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;<button class="btn btn-danger btn-sm delete-btn" data-summary="' + obj.aData.option_name + '" data-delete="' + obj.aData.id + '"><span class="glyphicon glyphicon-remove"></span></button>';
					}
				}
			]
		});

		this.$('#datatable_filter input').addClass('form-control');

		this.$().on('click', '.delete-btn', function() {
			$('#context-message').html('Are you sure you want to delete <b>' + $(this).attr('data-summary') + '</b>?');
			$('#confirmDelete').attr('data-target', '/service_options/' + $(this).attr('data-delete'));
			$('#confirm-deletion').modal();
		});
	}
});