# IS 6465 Homework 3
## AirAsia Rewards Gift Card Management System

### Project Overview

This project is a web-based gift card management application developed for IS 6465 - Web Based Applications at the University of Utah.

Homework 3 builds upon the static HTML and CSS prototype created in Homework 2 by implementing a functional PHP application connected to a SQLite database using PDO.

The application supports Create, Read, Update, and Delete (CRUD) operations for gift cards.

### Technologies Used

- PHP - Server-side application logic
- SQLite - Relational database
- PDO - Database connectivity and prepared SQL statements
- HTML5 - Web page structure and forms
- CSS3 - Application styling
- GitHub Codespaces - Development and testing environment
- Git and GitHub - Version control

### Application Features

**Gift Card List (`card-list.php`)**

Displays available gift cards, including their names, images, and points required. Users can select a card to view its details.

**Gift Card Details (`card-details.php`)**

Displays the selected gift card's ID, name, type, value, and points required. Provides links to update or delete the gift card.

**Add Gift Card (`card-add.php`)**

Allows users to create new gift cards. Submitted information is validated on the server before being inserted into SQLite using a PDO prepared statement.

**Update Gift Card (`card-update.php`)**

Loads an existing gift card into a prefilled form. Users can modify its information, and valid changes are saved using a PDO prepared UPDATE statement.

**Delete Gift Card (`card-delete.php`)**

Displays the selected gift card and requests confirmation before deletion. Records are deleted only after a POST request, using a PDO prepared DELETE statement.

### Project Structure

```text
IS-6465-AirAsia-Rewards/
|
|-- card-list.php
|-- card-details.php
|-- card-add.php
|-- card-update.php
|-- card-delete.php
|-- login.php
|
|-- includes/
|   |-- header.php
|   |-- nav.php
|   |-- footer.php
|   |-- db.php
|   |-- validation.php
|
|-- database/
|   |-- schema.sql
|   |-- seed.sql
|   |-- rewards.db
|
|-- css/
|   |-- styles.css
|
|-- images/
|   |-- gift-card.svg
|
|-- tests/
|   |-- validation-tests.php
|
|-- README.md
|-- test-report.md
|-- ai-use.txt
```

The login page is retained from Homework 2 as a prototype. Authentication and redemption functionality are outside the scope of Homework 3.

### Database Design

The application uses a SQLite database named `rewards.db` with two tables.

**ACCOUNT**

| Column | Data Type | Description |
|---|---|---|
| accountId | INTEGER | Primary key, automatically generated |
| userId | INTEGER | User identifier |
| accountType | VARCHAR(100) | Account type |
| points | INTEGER | Account points balance |

**GIFTCARD**

| Column | Data Type | Description |
|---|---|---|
| cardId | INTEGER | Primary key, automatically generated |
| cardName | VARCHAR(100) | Gift card name |
| cardType | VARCHAR(100) | Digital or Physical |
| cardValue | REAL | Gift card monetary value |
| points | INTEGER | Points required for redemption |

The initial database contains five ACCOUNT records and 20 GIFTCARD records.

### Installation and Setup

1. Clone the GitHub repository:

   ```bash
   git clone https://github.com/Tsny92/IS-6465-AirAsia-Rewards.git
   ```

2. Navigate into the repository:

   ```bash
   cd IS-6465-AirAsia-Rewards
   ```

3. Ensure PHP with PDO SQLite support and the SQLite command-line utility are installed.

4. Initialize the database if it does not already exist:

   ```bash
   sqlite3 database/rewards.db < database/schema.sql
   sqlite3 database/rewards.db < database/seed.sql
   ```

   **Warning:** The seed script resets the sample records. Do not rerun it if you want to preserve changes made through the application.

5. Start the PHP development server from the repository root:

   ```bash
   php -S 0.0.0.0:8000
   ```

6. Open the application in a browser:

   ```text
   http://localhost:8000/card-list.php
   ```

   In GitHub Codespaces, use the forwarded port 8000 URL.

### Use Case Traceability

The following table maps the five required gift card management use cases to their implementation and verification.

| Use Case | Description | PHP Page | Database Operation | Verification |
|---|---|---|---|---|
| UC01 | View Gift Card List | card-list.php | SELECT | T01 |
| UC02 | View Gift Card Details | card-details.php | SELECT by cardId | T02, T03 |
| UC03 | Add Gift Card | card-add.php | INSERT | T04, T05 |
| UC04 | Update Gift Card | card-update.php | UPDATE | T06 |
| UC05 | Delete Gift Card | card-delete.php | DELETE | T07, T08 |

### Input Validation

The application uses shared server-side validation through `includes/validation.php`.

Validation rules include:

- Card name is required and limited to 100 characters.
- Card type must be Digital or Physical.
- Card value must be a positive number.
- Points must be a positive integer.
- Gift card IDs must be positive integers.
- Invalid form submissions display errors.
- Submitted form values are preserved when validation fails.
- User-controlled output is escaped using `htmlspecialchars()`.

Database operations use PDO prepared statements.

### Testing

Testing includes browser-based CRUD verification, SQLite queries, PHP syntax checks, and automated validation tests.

Run the automated validation tests with:

```bash
php tests/validation-tests.php
```

Results:

```text
Validation Test Summary
Passed: 6
Failed: 0
```

The tests verify valid gift card data, blank names, invalid card types, zero and negative card values, and invalid points.

The automated tests do not modify the database.

Detailed functional test cases T01-T08, database verification, and testing results are documented in `test-report.md`.

### AI Usage

AI assistance was used during development for code guidance, debugging, validation design, and testing support.

See `ai-use.txt` for additional documentation of AI-assisted development and verification.

### Assignment Scope

Homework 3 focuses on gift card CRUD operations using PHP, PDO, and SQLite.

Login authentication, customer management, and gift card redemption are not implemented as part of this assignment.
