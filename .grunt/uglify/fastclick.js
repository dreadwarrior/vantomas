module.exports = function(grunt) {
    grunt.config.merge({
        uglify: {
            fastclick: {
                files: {
                    '<%= config.publicJsPath %>/vendor/fastclick.min.js': [
                        'node_modules/foundation-sites/js/vendor/fastclick.js'
                    ]
                }
            }
        }
    });
};
