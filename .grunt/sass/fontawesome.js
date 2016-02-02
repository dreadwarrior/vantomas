module.exports = function(grunt) {
    grunt.config.merge({
        sass: {
            fontawesome: {
                options: {
                    includePaths: [
                        'node_modules/font-awesome/scss',
                        '<%= config.scssPath %>/<%= env %>',
                    ],
                    outputStyle: 'compressed',
                    sourceComments: true,
                    sourceMap: true
                },
                files: {
                    '<%= config.publicCssPath %>/font-awesome.css': '<%= config.scssPath %>/font-awesome.scss'
                }
            }
        }
    });
};
