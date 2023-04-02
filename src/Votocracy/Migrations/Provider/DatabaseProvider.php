<?php

declare(strict_types=1);

namespace Votocracy\Migrations\Provider;

use Votocracy\Entity\Enum\ElectionModel;
use Votocracy\Entity\Enum\ElectionStatus;
use Votocracy\Entity\Enum\ElectionVisible;
use Votocracy\Entity\Enum\UserRole;
use Votocracy\Entity\Enum\UserStatus;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\Provider\SchemaProvider;

class DatabaseProvider implements SchemaProvider
{
    /**
     * @throws SchemaException
     */
    public function createSchema(): Schema
    {
        $schema = new Schema();

        $service = $schema->createTable('service');
        $service->addColumn('id', Types::INTEGER, ['autoincrement' => true, 'unsigned' => true]);
        $service->addColumn('title', Types::STRING, ['length' => 45]);
        $service->addColumn('alias', Types::STRING, ['length' => 3]);
        $service->addColumn('created_at', Types::DATETIME_IMMUTABLE, ['notnull' => false, 'default' => 'CURRENT_TIMESTAMP']);
        $service->setPrimaryKey(['id']);
        $service->addUniqueIndex(['alias']);

        $user = $schema->createTable('user');
        $user->addColumn('id', Types::INTEGER, ['autoincrement' => true, 'unsigned' => true]);
        $user->addColumn('email', Types::STRING, ['length' => 255]);
        $user->addColumn('status', Types::STRING, ['length' => 10, 'default' => UserStatus::UNCONFIRMED->value]);
        $user->addColumn('points', Types::INTEGER, ['unsigned' => true, 'default' => 0]);
        $user->addColumn('role', Types::STRING, ['length' => 10, 'default' => UserRole::USER->value]);
        $user->addColumn('created_at', Types::DATETIME_IMMUTABLE, ['notnull' => false, 'default' => 'CURRENT_TIMESTAMP']);
        $user->setPrimaryKey(['id']);
        $user->addIndex(['email']);
        $user->addIndex(['status']);

        $election = $schema->createTable('election');
        $election->addColumn('id', Types::INTEGER, ['autoincrement' => true, 'unsigned' => true]);
        $election->addColumn('description', Types::STRING, ['length' => 255]);
        $election->addColumn('status', Types::STRING, ['length' => 20, 'default' => ElectionStatus::PREPARING->value]);
        $election->addColumn('visible', Types::STRING, ['length' => 10, 'default' => ElectionVisible::SHOW->value]);
        $election->addColumn('model', Types::STRING, ['length' => 25, 'default' => ElectionModel::AUTO_ONE->value]);
        $election->addColumn('created_at', Types::DATETIME_IMMUTABLE, ['notnull' => false, 'default' => 'CURRENT_TIMESTAMP']);
        $election->addColumn('updated_at', Types::DATETIME_IMMUTABLE, ['notnull' => false]);
        $election->addColumn('date_start', Types::DATETIME_IMMUTABLE);
        $election->addColumn('date_end', Types::DATETIME_IMMUTABLE);
        $election->addColumn('service_id', Types::INTEGER, ['unsigned' => true]);
        $election->addColumn('owner_user_id', Types::INTEGER, ['unsigned' => true, 'notnull' => false]);
        $election->addColumn('voter_min_rating', Types::INTEGER, ['unsigned' => true, 'default' => 0]);
        $election->setPrimaryKey(['id']);
        $election->addIndex(['status']);
        $election->addIndex(['date_start']);
        $election->addIndex(['visible']);
        $election->addForeignKeyConstraint($service, ['service_id'], ['id']);
        $election->addForeignKeyConstraint($user, ['owner_user_id'], ['id'], ['onUpdate' => 'CASCADE']);

        $electionFilter = $schema->createTable('election_filter');
        $electionFilter->addColumn('id', Types::INTEGER, ['autoincrement' => true, 'unsigned' => true]);
        $electionFilter->addColumn('election_id', Types::INTEGER, ['unsigned' => true]);
        $electionFilter->addColumn('filter_name', Types::STRING, ['length' => 20]);
        $electionFilter->addColumn('filter_value', Types::STRING, ['length' => 10]);
        $electionFilter->addColumn('service_id', Types::INTEGER, ['unsigned' => true]);
        $electionFilter->setPrimaryKey(['id']);
        $electionFilter->addIndex(['filter_name', 'filter_value']);
        $electionFilter->addUniqueIndex(['service_id', 'filter_name']);
        $electionFilter->addForeignKeyConstraint($election, ['election_id'], ['id'], ['onUpdate' => 'CASCADE']);
        $electionFilter->addForeignKeyConstraint($service, ['service_id'], ['id']);

        $candidate = $schema->createTable('candidate');
        $candidate->addColumn('id', Types::INTEGER, ['autoincrement' => true, 'unsigned' => true]);
        $candidate->addColumn('description', Types::STRING, ['length' => 255]);
        $candidate->addColumn('election_id', Types::INTEGER, ['unsigned' => true]);
        $candidate->addColumn('owner_user_id', Types::INTEGER, ['unsigned' => true, 'notnull' => false]);
        $candidate->addColumn('created_at', Types::DATETIME_IMMUTABLE, ['notnull' => false, 'default' => 'CURRENT_TIMESTAMP']);
        $candidate->setPrimaryKey(['id']);
        $candidate->addForeignKeyConstraint($election, ['election_id'], ['id'], ['onUpdate' => 'CASCADE']);
        $candidate->addForeignKeyConstraint($user, ['owner_user_id'], ['id'], ['onUpdate' => 'CASCADE']);

        $vote = $schema->createTable('vote');
        $vote->addColumn('id', Types::INTEGER, ['autoincrement' => true, 'unsigned' => true]);
        $vote->addColumn('candidate_id', Types::INTEGER, ['unsigned' => true]);
        $vote->addColumn('user_id', Types::INTEGER, ['unsigned' => true]);
        $vote->addColumn('created_at', Types::DATETIME_IMMUTABLE, ['notnull' => false, 'default' => 'CURRENT_TIMESTAMP']);
        $vote->setPrimaryKey(['id']);
        $vote->addForeignKeyConstraint($candidate, ['candidate_id'], ['id'], ['onUpdate' => 'CASCADE']);
        $vote->addForeignKeyConstraint($user, ['_user_id'], ['id'], ['onUpdate' => 'CASCADE']);

        return $schema;
    }
}
