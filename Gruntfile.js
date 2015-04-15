module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    sass: {
      options: {
        includePaths: ['bower_components/foundation/scss']
      },
      dist: {
        options: {
          outputStyle: 'compressed',
          sourceComments: true,
          sourceMap: true,
          imagePath: 'web/typo3conf/ext/vantomas/Resources/Public/Images'
        },
        files: {
          'web/typo3conf/ext/vantomas/Resources/Public/Css/app.css': 'web/typo3conf/ext/vantomas/Resources/Private/Sass/app.scss'
        }
      }
    },

    uglify: {
      modernizr: {
        files: {
          'web/typo3conf/ext/vantomas/Resources/Public/Javascript/vendor/modernizr.min.js': [
            'bower_components/modernizr/modernizr.js'
          ]
        }
      },
      jquery: {
        options: {
          mangle: false,
          compress: false,
        },
        files: {
          'web/typo3conf/ext/vantomas/Resources/Public/Javascript/vendor/jquery.min.js': [
            'bower_components/jquery/dist/jquery.min.js',
          ]
        }
      },
      fastclick: {
        files: {
          'web/typo3conf/ext/vantomas/Resources/Public/Javascript/vendor/fastclick.min.js': [
            'bower_components/fastclick/lib/fastclick.js',
          ]
        }
      },
      foundation: {
        files: {
          'web/typo3conf/ext/vantomas/Resources/Public/Javascript/vendor/foundation.min.js': [
            'bower_components/foundation/js/foundation.js',
            'bower_components/foundation/foundation/foundation.orbit.js',
            'bower_components/foundation/foundation/foundation.tab.js',
          ]
        }
      }
    },

    watch: {
      grunt: {
          options: {
              reload: true,
          },
          files: ['Gruntfile.js']
      },

      sass: {
        files: 'web/typo3conf/ext/vantomas/Resources/Private/Sass/**/*.scss',
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