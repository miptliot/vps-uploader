module.exports = function (grunt) {
	grunt.initConfig({
		pkg : grunt.file.readJSON('package.json'),
		less : {
			app : {
				options : '<%= pkg.lessc %>',
				files : { 'css/uploader.min.css' : 'less/uploader.less' }
			}
		},
		watch : {
			less : {
				files : [ 'less/*.less' ],
				tasks : [ 'less' ]
			},
			uglify : {
				files : [ '<%= uglify.js.src %>' ],
				tasks : [ 'uglify:js' ]
			}
		},
		uglify : {
			js : {
				src : 'js/uploader.js',
				dest : 'js/uploader.min.js'
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-uglify');

	grunt.registerTask('default', [ 'less', 'uglify', 'watch' ]);
};