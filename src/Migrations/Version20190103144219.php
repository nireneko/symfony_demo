<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190103144219 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE movement (id INT AUTO_INCREMENT NOT NULL, movement_type_id INT DEFAULT NULL, author_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, type TINYINT(1) NOT NULL, date DATETIME NOT NULL, concept VARCHAR(255) NOT NULL, INDEX IDX_F4DD95F7EA4ED04A (movement_type_id), INDEX IDX_F4DD95F7F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movement_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE progress (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, date DATE NOT NULL, weight DOUBLE PRECISION NOT NULL, measure SMALLINT DEFAULT NULL, INDEX IDX_2201F246F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, created DATETIME NOT NULL, email VARCHAR(255) NOT NULL, last_login DATETIME NOT NULL, active TINYINT(1) NOT NULL, password_recovery_date DATETIME DEFAULT NULL, password_recovery_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F7EA4ED04A FOREIGN KEY (movement_type_id) REFERENCES movement_type (id)');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F7F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE progress ADD CONSTRAINT FK_2201F246F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F7EA4ED04A');
        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F7F675F31B');
        $this->addSql('ALTER TABLE progress DROP FOREIGN KEY FK_2201F246F675F31B');
        $this->addSql('DROP TABLE movement');
        $this->addSql('DROP TABLE movement_type');
        $this->addSql('DROP TABLE progress');
        $this->addSql('DROP TABLE user');
    }
}
