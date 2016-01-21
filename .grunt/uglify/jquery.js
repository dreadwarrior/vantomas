module.exports = function(grunt) {
    grunt.config.merge({
        uglify: {
            jquery: {
                options: {
                    mangle: false,
                    compress: false
                },
                files: {
                    '<%= config.publicJsPath %>/vendor/jquery.min.js': [
                        'node_modules/foundation-sites/js/vendor/jquery.js'
                    ]
                }
            }
        }
    });
};
