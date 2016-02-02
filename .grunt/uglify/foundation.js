module.exports = function(grunt) {
    grunt.config.merge({
        uglify: {
            foundation: {
                files: {
                    '<%= config.publicJsPath %>/vendor/foundation.min.js': [
                        'node_modules/foundation-sites/js/foundation.js',
                        'node_modules/foundation-sites/js/foundation/foundation.orbit.js',
                        'node_modules/foundation-sites/js/foundation/foundation.tab.js'
                    ]
                }
            }
        }
    });
};
