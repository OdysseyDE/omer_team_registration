module.exports = function(grunt) {
    
    // Project configuration.
    grunt.initConfig({
        concat: {
            css: {
                src: ['Style/theme.css',
                      'Style/omer_team_registration.css'],
                dest: 'dist/omer_team_registration.concat.css'
            },
            js: {
                src: ['js/jquery-2.1.3.js',
                      'js/plugins.js',
                      'js/jquery/superfish.js',
                      'js/jquery-ui.js',
                      'js/scripts.js',
                      'js/jquery.validate.js',
                      'js/language_support/jquery.ui.datepicker-de.js',
                      'js/omer_team_registration.js'],
                dest: 'dist/omer_team_registration.concat.js'
            }
        },
        uglify: {
            js: {
                src: ['<%= concat.js.dest %>'],
                dest: 'dist/omer_team_registration.js'
            }
        },
        cssmin: {
            css: {
                src: ['<%= concat.css.dest %>'],
                dest: 'dist/omer_team_registration.css'
            }
        }
    });
    
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    
    // Default task.
    grunt.registerTask('default', ['concat','uglify','cssmin']);
};
