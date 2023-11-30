<?php
require_once __DIR__ . '/initializer.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__, "/../../.env");
$dotenv->load();

$tables = [
    'users' => [
        'username VARCHAR(255) NOT NULL',
        'email VARCHAR(255) NOT NULL',
        'password VARCHAR(255) NOT NULL',
    ],
    'medicines' => [
        'name VARCHAR(255) NOT NULL',
        'brand VARCHAR(255) NOT NULL',
        'unit VARCHAR(255) NOT NULL',
        'expiration DATE NOT NULL',
        'boxesCount INT NOT NULL',
        'itemsPerBox INT NOT NULL',
        'itemsCount INT NOT NULL',
        'itemsDeducted INT NOT NULL DEFAULT 0',
        'storage VARCHAR(255) NOT NULL',
    ],
    'records' => [
        'schoolYear INT NOT NULL',
        'name VARCHAR(255) NOT NULL',
        'date DATE NOT NULL',
        'type VARCHAR(255) NOT NULL',
        'complaint TEXT NOT NULL',
        'medication VARCHAR(255) NOT NULL',
        'quantity INT NOT NULL',
        'treatment TEXT',
        'laboratory TEXT',
        'bloodPressure VARCHAR(255)',
        'pulse VARCHAR(255)',
        'weight VARCHAR(255)',
        'temperature VARCHAR(255)',
        'respiration VARCHAR(255)',
        'oximetry VARCHAR(255)',
        'userCreated VARCHAR(255) NOT NULL',
    ],
    'attachments' => [
        'recordId INT NOT NULL',
        'name VARCHAR(255) NOT NULL',
        'url VARCHAR(255) NOT NULL',
        'FOREIGN KEY (recordId) REFERENCES records(id) ON DELETE CASCADE'
    ],
    'complaints' => [
        'description TEXT NOT NULL',
    ],
    'laboratories' => [
        'description TEXT NOT NULL',
    ],
    'storages' => [
        'description TEXT NOT NULL',
    ],
    'treatments' => [
        'description TEXT NOT NULL',
    ],
    'logs' => [
        'userId INT NOT NULL',
        'username VARCHAR(255) NOT NULL',
        'action VARCHAR(255) NOT NULL',
        'description VARCHAR(255) NOT NULL',
        'FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE'
    ],
    'profiles' => [
        'userId INT NOT NULL',
        'name VARCHAR(255) NOT NULL',
        'url VARCHAR(255) NOT NULL',
        'FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE'
    ],
    'otps' => [
        'code VARCHAR(255) NOT NULL',
        'email VARCHAR(255) NOT NULL',
        'expiresAt DATETIME NOT NULL'
    ]
];

$shouldInitializeTables = strtolower($_ENV['DB_INITIALIZE'] ?? 'no');

if ($shouldInitializeTables === 'yes') {
    try {
        foreach ($tables as $tableName => $columns) {
            new Initializer($tableName, $columns);
        }
    } catch (Throwable $e) {
        throw new Exception($e->getMessage());
    }
}
