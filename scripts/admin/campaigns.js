App.Router.map(function() {
	this.resource('campaigns', function() {
		this.route('add');
		this.route('view', { path: '/view/:id' });
		this.route('edit', { path: '/edit/:id' });
	});
});

App.Campaigns = Ember.Model.extend({
	id: Ember.attr(),
	title: Ember.attr(),
	description: Ember.attr(),
	template: Ember.belongsTo('App.Templates', { key: 'template_id' }),
	isEdit: false
});

App.Campaigns.url = '/campaigns';
App.Campaigns.adapter = Ember.RESTAdapter.create();

App.CampaignsAddRoute = Ember.Route.extend({
	model: function() {
		return App.Campaigns.create();
	}
});

App.CampaignsEditRoute = Ember.Route.extend({
	model: function(param) {
		return App.Campaigns.find(param.id);
	}
});

App.CampaignsViewRoute = Ember.Route.extend({
	model: function(param) {
		return App.Campaigns.find(param.id);
	}
});

App.CampaignsFormController = Ember.ObjectController.extend({
	init: function() {
		this._super();
		this.set('template_id_array', App.Templates.find());
	},
	actions: {
		save: function() {
			this.get('model').save();
			this.transitionTo('campaigns');
		},

		cancel: function() {
			this.transitionTo('campaigns');
		}
	}
});

App.CampaignsAddController = App.CampaignsFormController.extend();
App.CampaignsEditController = App.CampaignsFormController.extend();

App.CampaignsFormView = Em.View.extend({
	didInsertElement: function() {
		Ember.run.sync();
		Ember.run.scheduleOnce('afterRender', this, 'processElements');
	},

	processElements: function() {
		var model = this.get('model');
		this.$('.type-date').datetimepicker({
			pickTime: false
		});

		this.$('#template_id').addClass('s2-enabled').select2({
			placeholder: "Select an option",
			ajax: {
				url: '/templates',
				dataType: 'json',
				data: function (term, page) {
					return {
						term: term,
						limit: 10,
						col: 'name'
					}
				},
				results: function (data, page) {
					return { results: data }
				}
			},
			initSelection: function(element, callback) {
				if (element.val() !== "") {
					$.getJSON('/templates/' + element.val(), function(data) {
						callback(data);
					});
				}
			},

			formatResult: function(obj, container, query) {
				return obj.name;
			},

			formatSelection: function(obj, container) {
				return obj.name;
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


App.CampaignsAddView = App.CampaignsFormView.extend();
App.CampaignsEditView = App.CampaignsFormView.extend();

App.CampaignsViewController = Ember.ObjectController.extend( {
	actions: {
		'edit': function(param) {
			this.transitionTo('campaigns.edit', param.id);
		},
		'confirmDelete': function(param) {
			this.get('model').set('isDeleting', true);
		}
	}
});

App.CampaignsIndexRoute = Ember.Route.extend();

App.CampaignsIndexView = Em.View.extend({
	didInsertElement: function() {
		this.$('#datatable').dataTable({
			"sDom": "ftprli",
			"bProcessing": true,
			"sAjaxSource": "/campaigns?dt=1",
			"aoColumns": [
				{
					"mData": null,
					"fnRender": function(obj) {
						return '<a href="#/campaigns/view/' + obj.aData.id + '">' + obj.aData.title + '</a>';
					}
				},
				{ "mData": "description" },
				{
					"mData": "template_id",
					"fnRender": function(obj) {
						return '<a href="#/templates/view/' + obj.aData.template_id + '">' + obj.aData.template + '</a>';
					}
				},
				{
					"mData": null,
					"sWidth": '120px',
					"fnRender": function(obj) {
						return '<a class="btn btn-info btn-sm" data-edit="' + obj.aData.id + ' " href="#/campaigns/edit/' + obj.aData.id + '"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;<button class="btn btn-danger btn-sm delete-btn" data-summary="' + obj.aData.title + '" data-delete="' + obj.aData.id + '"><span class="glyphicon glyphicon-remove"></span></button>';
					}
				}
			]
		});

		this.$('#datatable_filter input').addClass('form-control');

		this.$().on('click', '.delete-btn', function() {
			$('#context-message').html('Are you sure you want to delete <b>' + $(this).attr('data-summary') + '</b>?');
			$('#confirmDelete').attr('data-target', '/campaigns/' + $(this).attr('data-delete'));
			$('#confirm-deletion').modal();
		});
	}
});