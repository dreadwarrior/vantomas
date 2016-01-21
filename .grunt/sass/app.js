module.exports = function(grunt) {
    grunt.config.merge({
        sass: {
            app: {
                options: {
                    includePaths: [
                        'node_modules/foundation-sites/scss',
                        '<%= config.scssPath %>/<%= env %>'
                    ],
                    outputStyle: 'compressed',
                    sourceComments: true,
                    sourceMap: true,
                    imagePath: 'web/typo3conf/ext/vantomas/Resources/Public/Images'
                },
                files: {
                    '<%= config.publicCssPath %>/app.css': '<%= config.scssPath %>/app.scss'
                }
            }
        }
    });
};
