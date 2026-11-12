<?php
// Shared SQLite database connection for AirAsia Rewards.

function getDBConnection(): PDO
{
    $databasePath = __DIR__ . '/../database/rewards.db';

    $pdo = new PDO('sqlite:' . $databasePath);

    // Display database errors as exceptions.
    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    // Return database records as associative arrays.
    $pdo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );

    return $pdo;
}
