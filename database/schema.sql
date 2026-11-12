-- HW3: AirAsia Rewards Database Schema
-- Required tables: ACCOUNT and GIFTCARD

PRAGMA foreign_keys = ON;

-- ACCOUNT table
-- Stores rewards account information for future HW4 functionality.

CREATE TABLE IF NOT EXISTS ACCOUNT (
    accountId INTEGER PRIMARY KEY AUTOINCREMENT,
    userId INTEGER NOT NULL,
    accountType VARCHAR(100) NOT NULL,
    points INTEGER NOT NULL
);

-- GIFTCARD table
-- Stores the gift cards available in the rewards program.

CREATE TABLE IF NOT EXISTS GIFTCARD (
    cardId INTEGER PRIMARY KEY AUTOINCREMENT,
    cardName VARCHAR(100) NOT NULL,
    cardType VARCHAR(100) NOT NULL,
    cardValue REAL NOT NULL,
    points INTEGER NOT NULL
);
