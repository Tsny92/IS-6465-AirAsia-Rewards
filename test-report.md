
# Homework 3 - Test Report
## AirAsia Rewards Gift Card Management System

**Course:** IS 6465 - Web Based Applications  
**Assignment:** Homework 3  
**Testing Environment:** GitHub Codespaces, PHP, PDO, SQLite  
**Database:** database/rewards.db

---

## 1. Testing Overview

The purpose of testing was to verify that the AirAsia Rewards Gift Card Management System correctly implements Create, Read, Update, and Delete (CRUD) operations using PHP, PDO, and SQLite.

Testing included:
- Browser-based functional testing
- Server-side input validation
- SQL database verification
- PHP syntax checks
- Automated validation tests

The application uses prepared SQL statements for database operations and validates user input before processing requests.

---

## 2. Functional Test Cases

| Test ID | Test Description | Expected Result | Status |
|---|---|---|---|
| T01 | Open the Gift Card List page | All gift cards display with names, images, and points | PASS |
| T02 | View an existing gift card | Correct gift card details display | PASS |
| T03 | Open a gift card with an invalid ID | Application rejects the invalid ID | PASS |
| T04 | Submit invalid gift card information | Validation errors display and data is not saved | PASS |
| T05 | Add a valid gift card | New record is inserted into SQLite and appears in the list | PASS |
| T06 | Update an existing gift card | Updated information is saved and displayed | PASS |
| T07 | Open the Delete Gift Card confirmation page | Selected card details display without deleting the record | PASS |
| T08 | Confirm gift card deletion | Record is deleted and the application returns to the list | PASS |

### Functional Testing Notes

**T01 - Gift Card List:**  
Verified that the list page retrieved and displayed 20 seeded gift cards using PDO.

**T02 - Gift Card Details:**  
Verified that the details page retrieved the selected gift card using a prepared SELECT statement.

**T03 - Invalid Gift Card ID:**  
Verified that invalid IDs are rejected and nonexistent records are handled.

**T04 - Invalid Form Submission:**  
Submitted a gift card with a negative card value. Server-side validation rejected the submission, displayed an error, and preserved the entered form values.

**T05 - Add Gift Card:**  
Created a test record with the following information:

- Card Name: Test Visa $30 Gift Card
- Card Type: Digital
- Card Value: $30.00
- Points Required: 3000

SQLite verification confirmed the new record was inserted with cardId 21.

**T06 - Update Gift Card:**  
Updated cardId 1 from Amazon $10 Gift Card to Amazon $15 Gift Card.

SQLite verification confirmed the updated card name, $15.00 value, and 1500 points.

**T07 - Delete Confirmation:**  
Verified that the Delete Gift Card page identifies the selected record and displays a confirmation form before deletion.

**T08 - Delete Gift Card:**  
Deleted the test record with cardId 21 using the confirmation form.

SQLite verification returned no record for cardId 21. The total gift card count returned to 20.

---

## 3. Automated Validation Tests

**Test File:** tests/validation-tests.php

**Execution Command:**

```bash
php tests/validation-tests.php
```

| Test | Expected Behavior | Result |
|---|---|---|
| Valid gift card | Accept valid input | PASS |
| Blank card name | Reject missing name | PASS |
| Invalid card type | Reject unsupported type | PASS |
| Zero card value | Reject zero value | PASS |
| Negative card value | Reject negative value | PASS |
| Invalid points | Reject noninteger points | PASS |

**Automated Test Results:**

```text
PASS: Valid gift card
PASS: Blank card name
PASS: Invalid card type
PASS: Zero card value
PASS: Negative card value
PASS: Invalid points

Validation Test Summary
Passed: 6
Failed: 0
```

All six automated validation tests passed.

These tests call the shared validation function directly and do not modify the database.

---

## 4. Database Verification

### Initial Database Setup

The SQLite database was initialized with:

| Table | Seeded Records |
|---|---:|
| ACCOUNT | 5 |
| GIFTCARD | 20 |

### Create Operation

A new gift card was inserted successfully:

```text
cardId: 21
cardName: Test Visa $30 Gift Card
cardType: Digital
cardValue: 30.0
points: 3000
```

### Update Operation

The following record was updated successfully:

```text
cardId: 1
cardName: Amazon $15 Gift Card
cardType: Digital
cardValue: 15.0
points: 1500
```

### Delete Operation

After deleting cardId 21, the following query returned no matching records:

```sql
SELECT cardId, cardName
FROM GIFTCARD
WHERE cardId = 21;
```

The final gift card count was verified using:

```sql
SELECT COUNT(*) FROM GIFTCARD;
```

Result:

```text
20
```

This confirms that the test record was removed successfully.

---

## 5. Security and Validation

The application implements the following safeguards:

- PDO prepared statements for database queries
- Positive integer validation for gift card IDs
- Required gift card name with a 100-character limit
- Restricted card types (Digital and Physical)
- Positive numeric gift card values
- Positive integer points requirements
- HTML output escaping using htmlspecialchars()
- POST requests for database-changing form operations
- A confirmation screen before deleting gift cards

Authentication, authorization, and CSRF protection are not implemented in this homework version.

---

## 6. PHP Syntax Verification

PHP syntax checks were performed during development using:

```bash
php -l filename.php
```

Syntax checks passed for the pages and components tested during implementation.

---

## 7. Testing Conclusion

The AirAsia Rewards Gift Card Management System successfully implements the required CRUD functionality using PHP, PDO, and SQLite.

Browser testing and SQL verification confirmed that gift cards can be created, retrieved, updated, and deleted.

All six automated validation tests passed with zero failures.

The application is ready for final documentation review and submission checks.
