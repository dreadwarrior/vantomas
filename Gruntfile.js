module.exports = function(grunt) {
  var globalConfig = {
    scssPath: 'web/typo3conf/ext/vantomas/Resources/Private/Sass',
    publicCssPath: 'web/typo3conf/ext/vantomas/Resources/Public/Css',
    publicJsPath: 'web/typo3conf/ext/vantomas/Resources/Public/Javascript'
  };

  grunt.config('env', grunt.option('env') || process.env.GRUNT_ENV || 'development');

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    globalConfig: globalConfig,

    sass: {
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
        ]
      },
      dist: {
        options: {
          outputStyle: 'compressed',
          sourceComments: true,
          sourceMap: true,
          imagePath: 'web/typo3conf/ext/vantomas/Resources/Public/Images'
        },
        files: {
          '<%= globalConfig.publicCssPath %>/app.css': '<%= globalConfig.scssPath %>/app.scss'
        }
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

  grunt.registerTask('build', ['sass', 'uglify']);
  grunt.registerTask('default', ['build','watch']);
};
