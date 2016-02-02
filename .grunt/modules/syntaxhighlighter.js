function SyntaxHighlighter(config, grunt) {
    this.config = config;
    this.grunt = grunt;

    this.templateVariables = {
        data: {}
    };

    this.setTemplateVariables = function() {
        this.templateVariables.data.version = this.grunt.file.readJSON(
            this.config.syntaxHighlighter.modulePath + '/package.json'
        ).version;

        this.templateVariables.data.date = new Date().toUTCString();
    };

    this.processBanner = function() {
        return this.grunt.template.process(
            this.grunt.file.read(
                this.config.syntaxHighlighter.includesPath + '/header.txt'
            ),
            this.templateVariables
        );
    };

    this.processAboutDialog = function() {
        return this.grunt.template.process(
            this.grunt.file.read(
                this.config.syntaxHighlighter.includesPath + '/about.html'
            ).replace(
                /\r|\n|\t/g, ""
            ).replace(
                /"/g, "\\\""
            ),
            this.templateVariables
        );
    }
}

SyntaxHighlighter.prototype.processTemplates = function processTemplates() {
    this.setTemplateVariables();

    this.config.syntaxHighlighter.banner = this.processBanner();
    this.config.syntaxHighlighter.aboutDialog = this.processAboutDialog();

    return this.config;
};

module.exports = SyntaxHighlighter;
