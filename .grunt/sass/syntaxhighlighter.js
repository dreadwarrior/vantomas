module.exports = function(grunt) {
    grunt.config.merge({
        sass: {
            syntaxhighlighter: {
                options: {
                    outputStyle: 'compressed',
                    sourceComments: false,
                    sourceMap: false
                },
                files: [
                    {
                        expand: true,
                        cwd: '<%= config.syntaxHighlighter.modulePath %>',
                        src: ['src/sass/shCore*.scss'],
                        dest: '<%= config.syntaxHighlighter.destPath.css %>',
                        ext: '.css',
                        flatten: true
                    }
                ]
            }
        }
    });
};
