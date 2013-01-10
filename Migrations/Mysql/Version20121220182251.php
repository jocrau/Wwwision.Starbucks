<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Initial migration, creates tables for drink, addition & payment domain models
 */
class Version20121220182251 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("CREATE TABLE wwwision_starbucks_domain_model_addition (name VARCHAR(255) NOT NULL, cost DOUBLE PRECISION NOT NULL, PRIMARY KEY(name)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
		$this->addSql("CREATE TABLE wwwision_starbucks_domain_model_drink (name VARCHAR(255) NOT NULL, cost DOUBLE PRECISION NOT NULL, PRIMARY KEY(name)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
		$this->addSql("CREATE TABLE wwwision_starbucks_domain_model_drink_availableadditions_join (starbucks_drink VARCHAR(255) NOT NULL, starbucks_addition VARCHAR(255) NOT NULL, INDEX IDX_F79C0B6A3356342D (starbucks_drink), INDEX IDX_F79C0B6AB3B5EFAB (starbucks_addition), PRIMARY KEY(starbucks_drink, starbucks_addition)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
		$this->addSql("CREATE TABLE wwwision_starbucks_domain_model_order (persistence_object_identifier VARCHAR(40) NOT NULL, drink VARCHAR(255) DEFAULT NULL, INDEX IDX_97CF5E13DBE40D1 (drink), PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
		$this->addSql("CREATE TABLE wwwision_starbucks_domain_model_order_additions_join (starbucks_order VARCHAR(40) NOT NULL, starbucks_addition VARCHAR(255) NOT NULL, INDEX IDX_AA38D328CBC1E764 (starbucks_order), INDEX IDX_AA38D328B3B5EFAB (starbucks_addition), PRIMARY KEY(starbucks_order, starbucks_addition)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
		$this->addSql("CREATE TABLE wwwision_starbucks_domain_model_payment (persistence_object_identifier VARCHAR(40) NOT NULL, relatedorder VARCHAR(40) DEFAULT NULL, cardno VARCHAR(255) NOT NULL, expires VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_508A1966431E4786 (relatedorder), PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
		$this->addSql("ALTER TABLE wwwision_starbucks_domain_model_drink_availableadditions_join ADD CONSTRAINT FK_F79C0B6A3356342D FOREIGN KEY (starbucks_drink) REFERENCES wwwision_starbucks_domain_model_drink (name)");
		$this->addSql("ALTER TABLE wwwision_starbucks_domain_model_drink_availableadditions_join ADD CONSTRAINT FK_F79C0B6AB3B5EFAB FOREIGN KEY (starbucks_addition) REFERENCES wwwision_starbucks_domain_model_addition (name)");
		$this->addSql("ALTER TABLE wwwision_starbucks_domain_model_order ADD CONSTRAINT FK_97CF5E13DBE40D1 FOREIGN KEY (drink) REFERENCES wwwision_starbucks_domain_model_drink (name)");
		$this->addSql("ALTER TABLE wwwision_starbucks_domain_model_order_additions_join ADD CONSTRAINT FK_AA38D328CBC1E764 FOREIGN KEY (starbucks_order) REFERENCES wwwision_starbucks_domain_model_order (persistence_object_identifier)");
		$this->addSql("ALTER TABLE wwwision_starbucks_domain_model_order_additions_join ADD CONSTRAINT FK_AA38D328B3B5EFAB FOREIGN KEY (starbucks_addition) REFERENCES wwwision_starbucks_domain_model_addition (name)");
		$this->addSql("ALTER TABLE wwwision_starbucks_domain_model_payment ADD CONSTRAINT FK_508A1966431E4786 FOREIGN KEY (relatedorder) REFERENCES wwwision_starbucks_domain_model_order (persistence_object_identifier)");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("ALTER TABLE wwwision_starbucks_domain_model_drink_availableadditions_join DROP FOREIGN KEY FK_F79C0B6AB3B5EFAB");
		$this->addSql("ALTER TABLE wwwision_starbucks_domain_model_order_additions_join DROP FOREIGN KEY FK_AA38D328B3B5EFAB");
		$this->addSql("ALTER TABLE wwwision_starbucks_domain_model_drink_availableadditions_join DROP FOREIGN KEY FK_F79C0B6A3356342D");
		$this->addSql("ALTER TABLE wwwision_starbucks_domain_model_order DROP FOREIGN KEY FK_97CF5E13DBE40D1");
		$this->addSql("ALTER TABLE wwwision_starbucks_domain_model_order_additions_join DROP FOREIGN KEY FK_AA38D328CBC1E764");
		$this->addSql("ALTER TABLE wwwision_starbucks_domain_model_payment DROP FOREIGN KEY FK_508A1966431E4786");
		$this->addSql("DROP TABLE wwwision_starbucks_domain_model_addition");
		$this->addSql("DROP TABLE wwwision_starbucks_domain_model_drink");
		$this->addSql("DROP TABLE wwwision_starbucks_domain_model_drink_availableadditions_join");
		$this->addSql("DROP TABLE wwwision_starbucks_domain_model_order");
		$this->addSql("DROP TABLE wwwision_starbucks_domain_model_order_additions_join");
		$this->addSql("DROP TABLE wwwision_starbucks_domain_model_payment");
	}
}

?>