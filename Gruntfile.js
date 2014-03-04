module.exports = function (grunt) {
	grunt.loadNpmTasks('grunt-ember-templates');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		emberTemplates: {
			options: {
				templateBasePath: 'templates/admin/',
				precompile: false
			},
			compile: {
				files: {
					"public/js/admin_tpl.js": [ "templates/admin/*.hbs", "templates/admin/**/*.hbs" ],
					"public/js/client_tpl.js": [ "templates/client/*.hbs", "templates/client/**/*.hbs" ]
				}
			}
		},

		concat: {
			admin: {
				src: 'scripts/admin/**/*.js',
				dest: 'public/js/admin.js'
			},
			client: {
				src: 'scripts/client/**/*.js',
				dest: 'public/js/client.js'
			}
		},

		watch: {
			templates: {
				files: ['templates/**/*'],
				tasks: ['emberTemplates']
			},
			scripts: {
				files: ['scripts/**/*'],
				tasks: ['concat']
			}
		}
	});

	grunt.registerTask('default', [
		'emberTemplates',
		'concat',
		'watch'
	]);
}