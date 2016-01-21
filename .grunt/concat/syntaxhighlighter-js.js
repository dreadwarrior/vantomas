module.exports = function(grunt) {
    grunt.config.merge({
        concat: {
            syntaxhighlighter_js: {
                options: {
                    process: function(src, filepath) {
                        if (!grunt.file.isMatch({ matchBase: true }, 'sh*.js', filepath)) {
                            return src;
                        }

                        return grunt.template.process(
                            src.replace(/<%\-/g, "<%="), // convert from ejs to lodash
                            {
                                data: {
                                    about: grunt.config.get('config.syntaxHighlighter.aboutDialog')
                                }
                            }
                        )
                    }
                },
                files: [
                    {
                        src: [
                            'node_modules/xregexp/xregexp-all.js',
                            '<%= config.syntaxHighlighter.modulePath %>/src/js/shCore.js'
                        ],
                        dest: '<%= config.syntaxHighlighter.destPath.js %>shCore.min.js'
                    },
                    {
                        expand: true,
                        cwd: '<%= config.syntaxHighlighter.modulePath %>',
                        src: ['src/js/sh*.js'],
                        filter: function(filePath) {
                            return (grunt.file.isFile(filePath) && !grunt.file.isMatch({ matchBase: true }, 'shCore.js', filePath));
                        },
                        dest: '<%= config.syntaxHighlighter.destPath.js %>',
                        ext: '.min.js',
                        flatten: true
                    },
                    {
                        src: '<%= config.publicJsPath %>/shBrushTyposcript.js',
                        dest: '<%= config.syntaxHighlighter.destPath.js %>shBrushTyposcript.min.js'
                    }
                ]
            }
        }
    });
};
