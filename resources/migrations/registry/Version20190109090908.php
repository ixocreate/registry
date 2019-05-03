<?php
declare(strict_types=1);

namespace Ixocreate\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;
use Ixocreate\Type\Entity\DateTimeType;
use Ixocreate\Type\Entity\SchemaType;

final class Version20190109090908 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('registry_registry');

        $table->addColumn('id', Type::STRING);
        $table->addColumn('value', SchemaType::serviceName());
        $table->addColumn('createdAt', DateTimeType::serviceName());
        $table->addColumn('updatedAt', DateTimeType::serviceName());

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('registry_registry');
    }
}