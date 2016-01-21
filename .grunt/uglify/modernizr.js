module.exports = function(grunt) {
    grunt.config.merge({
        uglify: {
            modernizr: {
                files: {
                    '<%= config.publicJsPath %>/vendor/modernizr.min.js': [
                        'node_modules/foundation-sites/js/vendor/modernizr.js'
                    ]
                }
            }
        }
    });
};
