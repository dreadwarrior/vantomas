module.exports = function(grunt) {
    var path = require('path');

    grunt.registerTask(
        'copy:fontawesome:fonts',
        'Copies the fontawesome fonts into the application resource root.',
        function() {
            grunt.config.requires('config.publicFontsPath');

            var fonts = grunt.file.expand('node_modules/font-awesome/fonts/*.*');
            fonts.forEach(function(file) {
                grunt.file.copy(
                    file,
                    grunt.config('config.publicFontsPath') + '/Fontawesome/' + path.basename(file)
                );
            });
        }
    );
};
