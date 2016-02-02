module.exports = function(grunt) {
    grunt.config.merge({
        watch: {
            sass: {
                files: '<%= config.scssPath %>/**/*.scss',
                tasks: ['sass']
            }
        }
    })
};
