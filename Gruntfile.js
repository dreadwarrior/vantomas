var
    SyntaxHighlighter = require('./.grunt/modules/syntaxhighlighter.js');

module.exports = function(grunt) {
  var config = grunt.file.readJSON('Gruntconfig.json');

  var shTemplateProcessor = new SyntaxHighlighter(config, grunt);
  config = shTemplateProcessor.processTemplates();

  grunt.config('env', grunt.option('env') || process.env.GRUNT_ENV || 'development');

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    config: config,
    env: grunt.config('env')
  });

  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.loadTasks('.grunt/sass');
  grunt.loadTasks('.grunt/concat');
  grunt.loadTasks('.grunt/uglify');
  grunt.loadTasks('.grunt/watch');
  grunt.loadTasks('.grunt/copy');

  grunt.registerTask('build', [
    'sass',
    'concat',
    'uglify',
    'copy:shariff:min-css',
    'copy:fontawesome:fonts'
  ]);

  grunt.registerTask('default', [
    'build',
    'watch'
  ]);
};
