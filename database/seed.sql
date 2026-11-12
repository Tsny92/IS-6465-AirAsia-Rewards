-- HW3: AirAsia Rewards Seed Data
-- 5 ACCOUNT records and 20 GIFTCARD records

-- Clear existing seed data so this script can be rerun.
DELETE FROM GIFTCARD;
DELETE FROM ACCOUNT;

-- Reset auto-generated ID sequences.
DELETE FROM sqlite_sequence
WHERE name IN ('ACCOUNT', 'GIFTCARD');

-- Sample rewards accounts
-- userId values are placeholders for future HW4 functionality.
INSERT INTO ACCOUNT (userId, accountType, points) VALUES
(1, 'Standard', 2500),
(2, 'Silver', 7500),
(3, 'Gold', 15000),
(4, 'Platinum', 30000),
(5, 'Standard', 5000);

-- Sample gift cards
-- Card types: Digital and Physical
INSERT INTO GIFTCARD (cardName, cardType, cardValue, points) VALUES
('Amazon $10 Gift Card', 'Digital', 10.00, 1000),
('Amazon $25 Gift Card', 'Digital', 25.00, 2500),
('Amazon $50 Gift Card', 'Digital', 50.00, 5000),
('Starbucks $10 Gift Card', 'Digital', 10.00, 1000),
('Starbucks $25 Gift Card', 'Digital', 25.00, 2500),
('Target $25 Gift Card', 'Digital', 25.00, 2500),
('Target $50 Gift Card', 'Physical', 50.00, 5000),
('Walmart $25 Gift Card', 'Digital', 25.00, 2500),
('Walmart $50 Gift Card', 'Physical', 50.00, 5000),
('Apple $25 Gift Card', 'Digital', 25.00, 2500),
('Apple $50 Gift Card', 'Digital', 50.00, 5000),
('Google Play $10 Gift Card', 'Digital', 10.00, 1000),
('Google Play $25 Gift Card', 'Digital', 25.00, 2500),
('Netflix $25 Gift Card', 'Digital', 25.00, 2500),
('Disney $25 Gift Card', 'Digital', 25.00, 2500),
('Best Buy $50 Gift Card', 'Physical', 50.00, 5000),
('Home Depot $50 Gift Card', 'Physical', 50.00, 5000),
('Nike $25 Gift Card', 'Digital', 25.00, 2500),
('Sephora $25 Gift Card', 'Digital', 25.00, 2500),
('AirAsia Travel $100 Gift Card', 'Digital', 100.00, 10000);
