module.exports = function(grunt) {
    grunt.config.merge({
        watch: {
            grunt: {
                options: {
                    reload: true
                },
                files: ['Gruntfile.js']
            }
        }
    })
};
