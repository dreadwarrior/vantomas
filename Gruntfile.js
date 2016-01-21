var path = require('path');

module.exports = function(grunt) {
  var
    globalConfig = {
      scssPath: 'web/typo3conf/ext/vantomas/Resources/Private/Sass',
      publicCssPath: 'web/typo3conf/ext/vantomas/Resources/Public/Css',
      publicFontsPath: 'web/typo3conf/ext/vantomas/Resources/Public/Fonts',
      publicJsPath: 'web/typo3conf/ext/vantomas/Resources/Public/Javascript'
    },

    syntaxHighlighter = {
      modulePath: 'node_modules/SyntaxHighlighter',
      includesPath: 'node_modules/SyntaxHighlighter/build/includes',
      destPath: {
        css: '<%= globalConfig.publicCssPath %>/syntax_highlighter/',
        js: '<%= globalConfig.publicJsPath %>/vendor/syntax_highlighter/'
      }
    };

  syntaxHighlighter.variables = {
    version: grunt.file.readJSON(syntaxHighlighter.modulePath + '/package.json').version,
    date: new Date().toUTCString()
  };

  syntaxHighlighter.banner = grunt.template.process(
      grunt.file.read(syntaxHighlighter.includesPath + '/header.txt'),
      {
        data: syntaxHighlighter.variables
      }
  );

  syntaxHighlighter.aboutDialog = grunt.template.process(
    grunt.file.read(
      syntaxHighlighter.includesPath + '/about.html'
    ).replace(
        /\r|\n|\t/g, ""
    ).replace(
        /"/g, "\\\""
    ),
    {
      data: syntaxHighlighter.variables
    }
  );

  grunt.config('env', grunt.option('env') || process.env.GRUNT_ENV || 'development');

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    globalConfig: globalConfig,

    sass: {
      app: {
        options: {
          includePaths: [
            'node_modules/foundation-sites/scss',
            grunt.template.process(
              '<%= globalConfig.scssPath %>/<%= env %>',
              {
                data: {
                  globalConfig: globalConfig,
                  env: grunt.config('env')
                }
              }
            )
          ],

          outputStyle: 'compressed',
          sourceComments: true,
          sourceMap: true,
          imagePath: 'web/typo3conf/ext/vantomas/Resources/Public/Images'
        },
        files: {
          '<%= globalConfig.publicCssPath %>/app.css': '<%= globalConfig.scssPath %>/app.scss'
        }
      },
      syntaxhighlighter: {
        options: {
          outputStyle: 'compressed',
          sourceComments: false,
          sourceMap: false
        },
        files: [
          {
            expand: true,
            cwd: syntaxHighlighter.modulePath,
            src: ['src/sass/shCore*.scss'],
            dest: syntaxHighlighter.destPath.css,
            ext: '.css',
            flatten: true
          }
        ]
      },
      fontawesome: {
        options: {
          includePaths: [
            'node_modules/font-awesome/scss',
            grunt.template.process(
                '<%= globalConfig.scssPath %>/<%= env %>',
                {
                  data: {
                    globalConfig: globalConfig,
                    env: grunt.config('env')
                  }
                }
            )
          ],
          outputStyle: 'compressed',
          sourceComments: true,
          sourceMap: true
        },
        files: {
          '<%= globalConfig.publicCssPath %>/font-awesome.css': '<%= globalConfig.scssPath %>/font-awesome.scss'
        }
      }
    },

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
                    about: syntaxHighlighter.aboutDialog
                  }
                }
            )
          }
        },
        files: [
          {
            src: ['node_modules/xregexp/xregexp-all.js', syntaxHighlighter.modulePath + '/src/js/shCore.js'],
            dest: syntaxHighlighter.destPath.js + 'shCore.min.js'
          },
          {
            expand: true,
            cwd: syntaxHighlighter.modulePath,
            src: ['src/js/sh*.js'],
            filter: function(filePath) {
              return (grunt.file.isFile(filePath) && !grunt.file.isMatch({ matchBase: true }, 'shCore.js', filePath));
            },
            dest: syntaxHighlighter.destPath.js,
            ext: '.min.js',
            flatten: true
          },
          {
            src: '<%= globalConfig.publicJsPath %>/shBrushTyposcript.js',
            dest: syntaxHighlighter.destPath.js + 'shBrushTyposcript.min.js'
          }
        ]
      },
      syntaxhighlighter_css: {
        options: {
          banner: syntaxHighlighter.banner
        },
        files: [
          {
            expand: true,
            cwd: syntaxHighlighter.destPath.css,
            src: ['*.css'],
            dest: syntaxHighlighter.destPath.css,
            ext: '.css',
            flatten: true
          }
        ]
      }
    },

    uglify: {
      modernizr: {
        files: {
          '<%= globalConfig.publicJsPath %>/vendor/modernizr.min.js': [
            'node_modules/foundation-sites/js/vendor/modernizr.js'
          ]
        }
      },
      jquery: {
        options: {
          mangle: false,
          compress: false
        },
        files: {
          '<%= globalConfig.publicJsPath %>/vendor/jquery.min.js': [
            'node_modules/foundation-sites/js/vendor/jquery.js'
          ]
        }
      },
      fastclick: {
        files: {
          '<%= globalConfig.publicJsPath %>/vendor/fastclick.min.js': [
            'node_modules/foundation-sites/js/vendor/fastclick.js'
          ]
        }
      },
      foundation: {
        files: {
          '<%= globalConfig.publicJsPath %>/vendor/foundation.min.js': [
            'node_modules/foundation-sites/js/foundation.js',
            'node_modules/foundation-sites/js/foundation/foundation.orbit.js',
            'node_modules/foundation-sites/js/foundation/foundation.tab.js'
          ]
        }
      },
      layzr: {
        files: {
          '<%= globalConfig.publicJsPath %>/vendor/layzr.min.js': [
            'node_modules/layzr.js/dist/layzr.min.js'
          ]
        }
      },
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
          banner: syntaxHighlighter.banner,
          screwIE8: true,
          mangleProperties: false,
          reserveDOMProperties: true
        },
        files: [
          {
            expand: true,
            cwd: syntaxHighlighter.destPath.js,
            src: ['*.min.js'],
            dest: syntaxHighlighter.destPath.js,
            ext: '.min.js',
            flatten: true
          }
        ]
      },
      shariff: {
        options: {
          mangle: false,
          compress: false
        },
        files: {
          '<%= globalConfig.publicJsPath %>/vendor/shariff.min.js': [
            'node_modules/shariff/build/shariff.min.js'
          ]
        }
      }
    },

    watch: {
      grunt: {
          options: {
              reload: true
          },
          files: ['Gruntfile.js']
      },

      sass: {
        files: '<%= globalConfig.scssPath %>/**/*.scss',
        tasks: ['sass']
      }
    }
  });

  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-concat');

  grunt.registerTask(
    'copy:shariff:min-css',
    'Copies the already minified (existing font awesome) shariff css into the application resource root.',
    function() {
      grunt.config.requires('globalConfig.publicCssPath');

      grunt.file.copy(
        'node_modules/shariff/build/shariff.min.css',
        grunt.config('globalConfig.publicCssPath') + '/shariff/shariff.min.css'
      );
    }
  );
  grunt.registerTask(
    'copy:shariff:complete-css',
    'Copies the complete (including font awesome) shariff css into the application resource root.',
    function() {
      grunt.config.requires('globalConfig.publicCssPath');

      grunt.file.copy(
        'node_modules/shariff/build/shariff.complete.css',
        grunt.config('globalConfig.publicCssPath') + '/shariff/shariff.min.css'
      );
    }
  );
  grunt.registerTask(
    'copy:fontawesome:fonts',
    'Copies the fontawesome fonts into the application resource root.',
    function() {
      grunt.config.requires('globalConfig.publicFontsPath');

      var fonts = grunt.file.expand('node_modules/font-awesome/fonts/*.*');
      fonts.forEach(function(file) {
        grunt.file.copy(
          file,
          grunt.config('globalConfig.publicFontsPath') + '/Fontawesome/' + path.basename(file)
        );
      });
    }
  );

  grunt.registerTask('build', [
    'sass',
    'concat',
    'uglify',
    'copy:shariff:min-css',
    'copy:fontawesome:fonts'
  ]);
  grunt.registerTask('default', ['build','watch']);
};
