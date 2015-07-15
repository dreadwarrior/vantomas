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
            'bower_components/jquery/dist/jquery.min.js'
          ]
        }
      },
      fastclick: {
        files: {
          'web/typo3conf/ext/vantomas/Resources/Public/Javascript/vendor/fastclick.min.js': [
            'bower_components/fastclick/lib/fastclick.js'
          ]
        }
      },
      foundation: {
        files: {
          'web/typo3conf/ext/vantomas/Resources/Public/Javascript/vendor/foundation.min.js': [
            'bower_components/foundation/js/foundation.js',
            'bower_components/foundation/foundation/foundation.orbit.js',
            'bower_components/foundation/foundation/foundation.tab.js'
          ]
        }
      },
      layzr: {
        files: {
          'web/typo3conf/ext/vantomas/Resources/Public/Javascript/vendor/layzr.min.js': [
            'bower_components/layzr.js/dist/layzr.min.js'
          ]
        }
      },
      loadcss: {
        files: {
          'web/typo3conf/ext/vantomas/Resources/Public/Javascript/vendor/loadcss.min.js': [
            'bower_components/loadcss/loadCSS.js'
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
        files: 'web/typo3conf/ext/vantomas/Resources/Private/Sass/**/*.scss',
        tasks: ['sass']
      }
    },

    critical: {
      small: {
        options: {
          base: './',
          css: [
            'web/typo3conf/ext/vantomas/Resources/Public/Css/app.css'
          ],
          width: 640,
          height: 480,
          minify: true
        },
        src: '/tmp/index.html',
        dest: 'web/typo3conf/ext/vantomas/Resources/Public/CriticalCss/small.css'
      },
      medium: {
        options: {
          base: './',
          css: [
            'web/typo3conf/ext/vantomas/Resources/Public/Css/app.css'
          ],
          width: 1024,
          height: 768,
          minify: true
        },
        src: '/tmp/index.html',
        dest: 'web/typo3conf/ext/vantomas/Resources/Public/CriticalCss/medium.css'
      },
      large: {
        options: {
          base: './',
          css: [
            'web/typo3conf/ext/vantomas/Resources/Public/Css/app.css'
          ],
          width: 1440,
          height: 1080,
          minify: true
        },
        src: '/tmp/index.html',
        dest: 'web/typo3conf/ext/vantomas/Resources/Public/CriticalCss/large.css'
      },
      xlarge: {
        options: {
          base: './',
          css: [
            'web/typo3conf/ext/vantomas/Resources/Public/Css/app.css'
          ],
          width: 1920,
          height: 1200,
          minify: true
        },
        src: '/tmp/index.html',
        dest: 'web/typo3conf/ext/vantomas/Resources/Public/CriticalCss/xlarge.css'
      },
      xxlarge: {
        options: {
          base: './',
          css: [
            'web/typo3conf/ext/vantomas/Resources/Public/Css/app.css'
          ],
          width: 4096,
          height: 3072,
          minify: true
        },
        src: '/tmp/index.html',
        dest: 'web/typo3conf/ext/vantomas/Resources/Public/CriticalCss/xxlarge.css'
      }
    }
  });

  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-critical');

  grunt.registerTask('wget_homepage', function() {
    var done = this.async();

    grunt.util.spawn({
      cmd: ['wget'],
      args: ['http://localhost', '-O /tmp/index.html'],
      opts: {
        stdio: 'inherit'
      }
    }, function doneFunction(err, result, code) {
      //if (err) throw err;
      grunt.log.ok('Successfully scraped homepage to /tmp/index.html');

      done();
    });
  });

  grunt.registerTask('build', ['sass', 'uglify']);
  grunt.registerTask('ccss', ['wget_homepage', 'critical']);
  grunt.registerTask('default', ['build','watch']);
};
