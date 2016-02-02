module.exports = function(grunt) {
    grunt.config.merge({
        uglify: {
            layzr: {
                files: {
                    '<%= config.publicJsPath %>/vendor/layzr.min.js': [
                        'node_modules/layzr.js/dist/layzr.min.js'
                    ]
                }
            }
        }
    });
};
