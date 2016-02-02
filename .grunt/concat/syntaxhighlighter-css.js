module.exports = function(grunt) {
    grunt.config.merge({
        concat: {
            syntaxhighlighter_css: {
                options: {
                    banner: '<%= config.syntaxHighlighter.banner %>'
                },
                files: [
                    {
                        expand: true,
                        cwd: '<%= config.syntaxHighlighter.destPath.css %>',
                        src: ['*.css'],
                        dest: '<%= config.syntaxHighlighter.destPath.css %>',
                        ext: '.css',
                        flatten: true
                    }
                ]
            }
        }
    });
};
