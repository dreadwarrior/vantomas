<?php

use League\HTMLToMarkdown\HtmlConverter;
use Phinx\Migration\AbstractMigration;

class ConvertPagesAbstractToMarkdown extends AbstractMigration
{
    /**
     * Up
     *
     * @return void
     */
    public function up()
    {
        $articles = $this->query("SELECT uid, abstract FROM pages WHERE doktype = 30 AND deleted = 0");

        foreach ($articles as $article) {
            $converter = new HtmlConverter(['strip_tags' => false]);

            $markdownAbstract = $converter->convert($article['abstract']);

            $data = [
                $markdownAbstract,
            ];

            $stmt = $this->getAdapter()->getConnection()->prepare(
                "UPDATE
                    pages
                SET
                    abstract = ?
                WHERE
                    uid = " . (int) $article['uid']
            );

            $stmt->execute($data);
        }
    }
}
