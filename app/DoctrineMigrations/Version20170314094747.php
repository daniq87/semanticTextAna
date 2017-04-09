<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170314094747 extends AbstractMigration {

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) {
        // this up() migration is auto-generated, please modify it to your needs
        // room
        $this->addSql("INSERT INTO topics (name) VALUES('room')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(1,'room')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(1,'apartment')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(1,'chamber')");
        // hotel
        $this->addSql("INSERT INTO topics (name) VALUES('hotel')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(2,'hotel')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(2,'property')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(2,'lodge')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(2,'resort')");
        // STAFF
        $this->addSql("INSERT INTO topics (name) VALUES('staff')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(3,'staff')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(3,'service')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(3,'personnel')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(3,'crew')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(3,'he')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(3,'she')");
        // location
        $this->addSql("INSERT INTO topics (name) VALUES('location')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(4,'location')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(4,'spot')");
        // breakfast
        $this->addSql("INSERT INTO topics (name) VALUES('breakfast')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(5,'breakfast')");
        // bed
        $this->addSql("INSERT INTO topics (name) VALUES('bed')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(6,'bed')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(6,'sleep quality')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(6,'mattresses')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(6,'linens')");
        // food
        $this->addSql("INSERT INTO topics (name) VALUES('food')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(7,'food')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(7,'dinner')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(7,'lunch')");
        // bathroom
        $this->addSql("INSERT INTO topics (name) VALUES('bathroom')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(8,'bathroom')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(8,'lavatory')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(8,'shower')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(8,'toilet')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(8,'bath')");
        // restaurant
        $this->addSql("INSERT INTO topics (name) VALUES('restaurant')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(9,'restaurant')");
        // pool
        $this->addSql("INSERT INTO topics (name) VALUES('pool')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(10,'pool')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(10,'spa')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(10,'wellness')");
        // bar
        $this->addSql("INSERT INTO topics (name) VALUES('bar')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(11,'bar')");
        // cost
        $this->addSql("INSERT INTO topics (name) VALUES('cost')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(12,'price')");
        $this->addSql("INSERT INTO criterias (topic_id,name) VALUES(12,'bill')");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) {
        // this down() migration is auto-generated, please modify it to your needs
    }

}
