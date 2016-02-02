module.exports = function(grunt) {
    grunt.registerTask(
        'copy:shariff:min-css',
        'Copies already minified (existing fontawesome) shariff css into the application resource root.',
        function() {
            grunt.config.requires('config.publicCssPath');

            grunt.file.copy(
                'node_modules/shariff/build/shariff.min.css',
                grunt.config('config.publicCssPath') + '/shariff/shariff.min.css'
            );
        }
    );

    grunt.registerTask(
        'copy:shariff:complete-css',
        'Copies the complete (including fontawesome) shariff css into the application resource root.',
        function() {
            grunt.config.requires('config.publicCssPath');

            grunt.file.copy(
                'node_modules/shariff/build/shariff.complete.css',
                grunt.config('config.publicCssPath') + '/shariff/shariff.min.css'
            );
        }
    );
};
