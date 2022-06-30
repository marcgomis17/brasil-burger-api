<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630140359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE taille_boisson_boisson');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE taille_boisson_boisson (taille_boisson_id INT NOT NULL, boisson_id INT NOT NULL, INDEX IDX_26598B59734B8089 (boisson_id), INDEX IDX_26598B598421F13F (taille_boisson_id), PRIMARY KEY(taille_boisson_id, boisson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE taille_boisson_boisson ADD CONSTRAINT FK_26598B59734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille_boisson_boisson ADD CONSTRAINT FK_26598B598421F13F FOREIGN KEY (taille_boisson_id) REFERENCES taille_boisson (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
