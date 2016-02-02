module.exports = function(grunt) {
    grunt.config.merge({
        uglify: {
            syntaxhighlighter: {
                options: {
                    compress: {
                        sequences: true,
                        properties: false,
                        dead_code: true,
                        drop_debugger: true,
                        conditionals: true,
                        comparisons: true,
                        booleans: false,
                        loops: true,
                        unused: false,
                        if_return: true,
                        join_vars: true,
                        cascade: true,
                        warnings: true,
                        negate_iife: true,
                        drop_console: true
                    },
                    banner: '<%= config.syntaxHighlighter.banner %>',
                    screwIE8: true,
                    mangleProperties: false,
                    reserveDOMProperties: true
                },
                files: [
                    {
                        expand: true,
                        cwd: '<%= config.syntaxHighlighter.destPath.js %>',
                        src: ['*.min.js'],
                        dest: '<%= config.syntaxHighlighter.destPath.js %>',
                        ext: '.min.js',
                        flatten: true
                    }
                ]
            }
        }
    });
};
