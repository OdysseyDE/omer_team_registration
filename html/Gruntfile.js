module.exports = function(grunt) {
    
    // Project configuration.
    grunt.initConfig({
        concat: {
            css: {
                src: ['Style/theme.css',
                      'Style/bluetooth.css'],
                dest: 'dist/bluetooth.concat.css'
            },
            js: {
                src: ['js/jquery-2.1.3.js',
                      'js/plugins.js',
                      'js/jquery/superfish.js',
                      'js/jquery-ui.js',
                      'js/scripts.js',
                      'js/jquery.validate.js',
                      'js/language_support/jquery.ui.datepicker-de.js',
                      'js/bluetooth.js'],
                dest: 'dist/bluetooth.concat.js'
            }
        },
        uglify: {
            js: {
                src: ['<%= concat.js.dest %>'],
                dest: 'dist/bluetooth.js'
            }
        },
        cssmin: {
            css: {
                src: ['<%= concat.css.dest %>'],
                dest: 'dist/bluetooth.css'
            }
        }
    });
    
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    
    // Default task.
    grunt.registerTask('default', ['concat','uglify','cssmin']);
};
