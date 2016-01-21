module.exports = function(grunt) {
    grunt.config.merge({
        uglify: {
            shariff: {
                options: {
                    mangle: false,
                    compress: false
                },
                files: {
                    '<%= config.publicJsPath %>/vendor/shariff.min.js': [
                        'node_modules/shariff/build/shariff.min.js'
                    ]
                }
            }
        }
    });
};
