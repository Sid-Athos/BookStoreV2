<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200702140844 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD31684827B9B2');
        $this->addSql('DROP INDEX IDX_BFDD31684827B9B2 ON articles');
        $this->addSql('ALTER TABLE articles CHANGE marque_id marques_id INT NOT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168C256483C FOREIGN KEY (marques_id) REFERENCES marques (id)');
        $this->addSql('CREATE INDEX IDX_BFDD3168C256483C ON articles (marques_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168C256483C');
        $this->addSql('DROP INDEX IDX_BFDD3168C256483C ON articles');
        $this->addSql('ALTER TABLE articles CHANGE marques_id marque_id INT NOT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD31684827B9B2 FOREIGN KEY (marque_id) REFERENCES marques (id)');
        $this->addSql('CREATE INDEX IDX_BFDD31684827B9B2 ON articles (marque_id)');
    }
}
