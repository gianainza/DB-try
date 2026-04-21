
# Event Management & Ticketing System

A full-stack database-driven web application for managing university events, attendee registration, and digital ticket validation.

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql)
![Python](https://img.shields.io/badge/Python-3.12-3776AB?logo=python)
![XAMPP](https://img.shields.io/badge/XAMPP-8.x-FB7A24?logo=xampp)
![License](https://img.shields.io/badge/License-Academic-blue)
----------

## Table of Contents

-   Project Overview
-   Features
-   Tech Stack
-   Python Integration
-   QR Code Camera Scanner
-   Database Design
-   Folder Structure
-   Installation and Setup Guide
-   Running the System
-   Usage Guide
-   System Architecture
-   Important Notes and Constraints
-   Troubleshooting
-   License
-   Acknowledgments

----------

## Project Overview

The Event Management and Ticketing System is a university-focused web application that enables accredited student organizations, alumni groups, university offices, and external organizers to create and manage school events. Attendees including students, employees, alumni, or guests can register and receive unique digital ticket codes tied to their identity. The system enforces per-event audience rules and provides ticket validation at event entrances.

### Real-World Use Case

This system solves the common problem of managing ticketed and free-entry events in a university setting:

-   Student organizations can create events with audience-specific ticket tiers    
-   Attendees register once and can attend multiple events
-   Unique UUID-based tickets prevent duplication and fraud  
-   QR code validation enables fast, secure check-in at event venues    
-   Camera-based scanning provides instant ticket verification at entry points    

----------

## Features

### Core CRUD Operations

| Module | Create | Read | Update | Delete | 
|-----|-----|-----|-----|-----|
| Venues | Add new university facilities| List with filtering | Edit details| Delete with FK protection |
| Organizations|Register organizers|List with filtering|Edit details|Delete with FK protection|
| Events |Create events|List with search and filter|Edit all fields | Delete with FK protection |
| Ticket Categories | Add audience tiers | List by event | Edit slots and pricing | Delete with FK protection |
| Attendees | Register with type-specific fields | List with search and filter | Edit details | Delete with FK protection |
| Tickets | Generate UUID tickets | List with QR codes | View details | Delete and restore slot |

### Advanced Features

-   **Python-Powered UUID Generation**: Ticket codes generated via Python's uuid module for cryptographic uniqueness
    
-   **Python Ticket Validation**: All validation logic handled by Python script with database transaction support
    
-   **Python Automated Reporting**: Dashboard statistics and reports generated through Python
    
-   **QR Code Display**: Tickets include scannable QR codes for validation
    
-   **Camera-Based QR Scanner**: Real-time browser camera scanning for fast ticket validation
    
-   **Eligibility Enforcement**: Attendee types matched against ticket category rules
    
-   **Atomic Transactions**: Ticket operations use database transactions with rollback safety
    
-   **Dashboard Metrics**: Real-time statistics on events, attendees, tickets, and revenue
    
-   **Foreign Key Protection**: Prevents deletion of records with existing dependencies
    
-   **Slot Management**: Automatic slot tracking and restoration on ticket deletion
    

### Business Rules Enforced

-   Events always held at university venues
    
-   Ticket categories are audience-based (Student, Employee, Alumni, Guest)
    
-   Each attendee can only hold one ticket per event category
    
-   Free-entry events can bypass ticket requirements
    
-   Validation timestamps record exact check-in time
    

----------

## Tech Stack

|Technology | Version | Purpose
|-----|-----|-----|
|PHP | 8.x | Backend server logic, CRUD operations, form handling|
|Python|3.12|UUID generation, ticket validation, automated reporting
|MySQL|8.0|Relational database with full constraint support
|XAMPP|8.x|Local development environment (Apache and MySQL)
|HTML5|-|Semantic page structure|
|CSS3|-|Custom styling with CSS variables and responsive design|
|JavaScript|Vanilla|Client-side validation, dynamic forms, camera scanner|
|html5-qrcode|2.3.8 |Browser-based QR code scanning library|
|QRCode.js|1.0.0|QR code rendering for ticket display|
|mysql-connector-python|Latest|Python-MySQL database connectivity|

### Why This Stack

-   **PHP and MySQL**: Industry-standard LAMP stack components for academic CRUD projects
    
-   **Python Integration**: Demonstrates multi-language system architecture with specialized responsibilities
    
-   **Procedural PHP**: Simpler learning curve appropriate for project scope
    
-   **No Framework**: Demonstrates fundamental understanding of PHP-MySQL integration
    
-   **XAMPP**: Portable cross-platform local server ideal for development and grading
    

----------

## Python Integration

The system uses Python for three critical backend functions as required by project specifications.

### Python Requirements

-   **Python Version**: 3.12 or higher
    
-   **Command**: Use `py` command (not `python`) for all script execution
    
-   **Package**: mysql-connector-python
    

### Python Scripts


| Script | Purpose | Called From |
|--------|---------|-------------|
| `python/generate_uuid.py` | Generates UUID v4 ticket codes | `modules/tickets/generate.php` |
| `python/validate_ticket.py` | Validates ticket codes against database | `modules/tickets/validate.php`, `api/ticket_validate.php` |
| `python/generate_reports.py` | Generates dashboard and statistical reports | `includes/functions.php` via `getPythonReport()` |

### Python-MySQL Integration

All Python scripts connect to the MySQL database using mysql-connector-python with the same credentials as the PHP application. Scripts return clean JSON output for PHP to parse and display.

### PHP to Python Communication

PHP calls Python scripts using:

```text
shell_exec("py path/to/script.py arguments 2>&1")
```

Python scripts return:

-   `generate_uuid.py`: Clean UUID string only
    
-   `validate_ticket.py`: JSON object with validation result
    
-   `generate_reports.py`: JSON object with report data
    

----------

## QR Code Camera Scanner

The Ticket Validation page includes a browser-based QR code scanner for fast, real-world ticket validation at event entrances.

### Feature Overview

-   Camera icon button located in the page header
    
-   Opens in-page modal with live camera feed
    
-   Automatically scans and decodes QR codes
    
-   Submits extracted ticket code to validation system
    
-   Displays result immediately (Valid, Invalid, or Already Used)
    

### Technical Implementation

-   **Library**: html5-qrcode (lightweight, no dependencies)
    
-   **Camera Access**: Browser getUserMedia API
    
-   **Scanning**: Real-time QR detection at 10 fps
    
-   **Result Handling**: Auto-submits to existing PHP validation endpoint
    

### Usage Instructions

1.  Navigate to Ticket Validation page
    
2.  Click the camera icon button labeled "Scan QR"
    
3.  Allow browser camera permission when prompted
    
4.  Point camera at ticket QR code
    
5.  System automatically detects and validates the ticket
    
6.  Result displays with attendee and event details
    

### Browser Compatibility

| Browser | Status | Notes
|-----|-----|-----|
| Microsoft Edge | Full support | Works without additional configuration |
| Google Chrome | Full support | Works without additional configuration |
| Mozilla Firefox | Full support | Works without additional configuration |
| Brave | Requires configuration | Must disable Shields Up for localhost |

### Validation Results

The scanner integrates with the existing Python validation system:

-   **Valid Ticket**: Green success message with attendee name, event, and validation timestamp
    
-   **Already Used**: Amber warning showing previous validation time
    
-   **Invalid Ticket**: Red error message indicating ticket not found
    

----------

## Database Design

The database is normalized to Third Normal Form (3NF) with proper primary and foreign key relationships.

### Table Relationships

-   Venue (1) to Many Event: One venue can host many events
    
-   Organization (1) to Many Event: One organization can organize many events
    
-   Event (1) to Many Ticket_Category: One event can have multiple ticket categories
    
-   Ticket_Category (1) to Many Ticket: One ticket category contains many individual tickets
    
-   Attendee (1) to Many Ticket: One attendee can hold tickets for multiple events
    
-   Ticket resolves the many-to-many relationship between Attendee and Event via Ticket_Category
    

### Key Tables

| Table | Purpose | Key Relationships | 
|-----|-----|------|
| Venue | University facilities | One to Many Events |
| Organization | Event organizers | One to Many Events |
| Event | School events | Belongs to Venue and Organization; One to Many Ticket_Categories |
|Ticket_Category| Audience-based ticket tiers|Belongs to Event; One to Many Tickets |
|Attendee|Registered attendees|Subtype fields for Student, Employee, Alumni, Guest; One to Many Tickets|
|Ticket|Individual tickets|Belongs to Ticket_Category and Attendee; Unique UUID |

### Normalization (3NF)

-   **1NF**: All attributes are atomic with no repeating groups
    
-   **2NF**: No partial dependencies; all non-key attributes depend on full primary key
    
-   **3NF**: No transitive dependencies; non-key attributes depend only on primary key
    

### Views

| View | Purpose | 
|-----|-----|
| vw_event_summary | Dashboard aggregation of event and ticket statistics |
| vw_ticket_details | Complete ticket information across all related tables

### Stored Procedure

|Procedure | Purpose|
|-----|-----|
|sp_purchase_ticket|Atomic ticket purchase with eligibility check and transaction rollback|

----------

## Folder Structure

```text
event_ticketing/
│
├── index.php                           # Dashboard with metrics and recent records
│
├── config/
│   └── database.php                    # MySQL connection configuration
│
├── includes/
│   ├── header.php                      # Common header, navigation, authentication
│   ├── footer.php                      # Common footer, script includes
│   └── functions.php                   # Helper functions and Python report integration
│
├── python/
│   ├── generate_uuid.py                # Python UUID v4 generator
│   ├── validate_ticket.py              # Python ticket validation with database
│   └── generate_reports.py             # Python automated reporting
│
├── modules/
│   ├── venues/
│   │   ├── index.php                   # List all venues
│   │   ├── create.php                  # Add new venue form
│   │   ├── edit.php                    # Edit venue form
│   │   └── delete.php                  # Delete venue handler
│   │
│   ├── organizations/
│   │   ├── index.php                   # List all organizations
│   │   ├── create.php                  # Add organization form
│   │   ├── edit.php                    # Edit organization form
│   │   └── delete.php                  # Delete organization handler
│   │
│   ├── events/
│   │   ├── index.php                   # List events with search and filter
│   │   ├── create.php                  # Create new event form
│   │   ├── edit.php                    # Edit event form
│   │   └── delete.php                  # Delete event handler
│   │
│   ├── categories/
│   │   ├── index.php                   # List ticket categories by event
│   │   ├── create.php                  # Add ticket category form
│   │   ├── edit.php                    # Edit category form
│   │   └── delete.php                  # Delete category handler
│   │
│   ├── attendees/
│   │   ├── index.php                   # List attendees with search and filter
│   │   ├── create.php                  # Register attendee with dynamic subtype fields
│   │   ├── edit.php                    # Edit attendee form
│   │   └── delete.php                  # Delete attendee handler
│   │
│   └── tickets/
│       ├── index.php                   # List all tickets
│       ├── generate.php                # Generate UUID ticket with Python
│       ├── view.php                    # View ticket with QR code
│       ├── validate.php                # Ticket validation with camera scanner
│       └── delete.php                  # Delete ticket and restore slot
│
├── api/
│   └── ticket_validate.php             # AJAX endpoint calling Python validation
│
└── assets/
 ├── css/
 │   └── style.css                   # Complete application styling
 └── js/
 └── script.js                   # Client-side validation and interactions
```
----------

## Installation and Setup Guide

### Prerequisites

<<<<<<< HEAD
### Step 1: Install XAMPP
1. Download XAMPP from [apachefriends.org](https://www.apachefriends.org/)
2. Run the installer and follow default settings
3. Launch **XAMPP Control Panel**
4. Start **Apache** and **MySQL** services

### Step 2: Place Project in htdocs

```bash
# Navigate to XAMPP htdocs directory
cd C:/xampp/htdocs/

# Create project folder
mkdir event_ticketing

# Copy all project files into event_ticketing/
# Or clone from repository:
git clone <repository-url> event_ticketing
```
**Final path should be:**  `C:/xampp/htdocs/event_ticketing/`

### Step 3: Import Database

1.  Open **phpMyAdmin**: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2.  Click **New** in the left sidebar
3.  Database name: `event_ticketing_db`
4.  Character set: `utf8mb4_unicode_ci`
5.  Click **Create**
6.  Select the new database
7.  Click **Import** tab
8.  Choose the SQL file: `SURNAME - Event Management & Ticketing System.sql`
9.  Click **Go** to execute
=======
-   XAMPP (Apache, MySQL, PHP)
    
-   Python 3.12 or higher
    
-   Web browser with camera support
    
-   Git (optional)
>>>>>>> 1205e08e0f912413fe2e637ce6a65daf417920ab
    

### Step 1: Install XAMPP

1.  Download XAMPP from [apachefriends.org](https://apachefriends.org/)
    
2.  Run the installer and follow default settings
    
3.  Launch XAMPP Control Panel
    
4.  Start Apache and MySQL services
    

### Step 2: Verify Python Installation

Open Command Prompt and verify Python:

```text
py --version
```

Expected output: `Python 3.12.x`

### Step 3: Install Python Dependencies

Install the MySQL connector for Python:

```text
py -m pip install mysql-connector-python
```
Verify installation:

```text
py -c "import mysql.connector; print('MySQL connector installed')"
```
### Step 4: Place Project in htdocs

Navigate to XAMPP htdocs directory:

```text
cd C:/xampp/htdocs/
```
Create project folder and copy all files:

```text
mkdir event_ticketing
```
Copy all project files into `C:/xampp/htdocs/event_ticketing/`

### Step 5: Import Database

1.  Open phpMyAdmin: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
    
2.  Click New in the left sidebar
    
3.  Database name: `event_ticketing_db`
    
4.  Character set: `utf8mb4_unicode_ci`
    
5.  Click Create
    
6.  Select the new database
    
7.  Click Import tab
    
8.  Choose the SQL file: `Event-Management-Ticketing-System.sql`
    
9.  Click Go to execute
    

### Step 6: Configure Database Connection

Edit `config/database.php` if your MySQL credentials differ:

```php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'event_ticketing_db');
```
----------

## Running the System

### Access the Application

Open your browser and navigate to:

```text
http://localhost/event_ticketing/
```

### Default Login Credentials

|Field |Value|
|-----|-----|
|Username|admin|
| Password | admin123|


### Camera Permission

When using the QR scanner on the Ticket Validation page:

-   Allow camera access when prompted by the browser
    
-   The scanner requires camera permission to function
    
-   Permission is requested only when the Scan QR button is clicked
    

### Python Verification

To verify Python integration is working:

1.  Generate a new ticket and confirm UUID is created
    
2.  Validate a ticket using the validation page
    
3.  Check that Python scripts execute without errors
    

----------

## Usage Guide

### Authentication

1.  Navigate to [http://localhost/event_ticketing/](http://localhost/event_ticketing/)
    
2.  Enter credentials: admin / admin123
    
3.  Click Sign In
    

### Dashboard

The dashboard displays:

-   Total events, upcoming events, attendees, tickets issued
    
-   Validated tickets count and total revenue
    
-   Recent events with ticket sales progress
    
-   Recent tickets with validation status
    

### Managing Venues

1.  Click Venues in sidebar
    
2.  Click Add Venue
    
3.  Fill in name, type, capacity, building, floor, AV system
    
4.  Click Save Venue
    
5.  Use Edit to modify, Del to remove (only if no associated events)
    

### Managing Organizations

1.  Click Organizations in sidebar
    
2.  Click Add Organization
    
3.  Fill in name, type, contact email, adviser details, accreditation status
    
4.  Click Save Organization
    

### Creating Events

1.  Click Manage Events then New Event
    
2.  Select venue and organization from dropdowns
    
3.  Set event date, start and end times, audience type
    
4.  Choose whether event requires tickets
    
5.  Click Save Event
    

### Adding Ticket Categories

1.  Click Ticket Categories then Add Category
    
2.  Select the event
    
3.  Set category name
    
4.  Choose eligible attendee type
    
5.  Set price and total slots
    
6.  Click Save Category
    

### Registering Attendees

1.  Click Attendees then Register Attendee
    
2.  Fill in personal details
    
3.  Select attendee type (Student, Employee, Alumni, Guest)
    
4.  Fill in type-specific fields
    
5.  Click Register Attendee
    

### Generating Tickets

1.  Click Ticket Generation then Generate Ticket
    
2.  Select an event with available categories
    
3.  Choose a ticket category
    
4.  Select an attendee
    
5.  System checks eligibility automatically
    
6.  Click Generate and Issue Ticket
    
7.  View ticket with QR code
    

### Validating Tickets

**Method 1: Manual Entry**

1.  Click Ticket Validation in sidebar
    
2.  Enter ticket code manually
    
3.  Click Validate
    
4.  View result
    

**Method 2: QR Scanner**

1.  Click Ticket Validation in sidebar
    
2.  Click Scan QR button
    
3.  Allow camera access
    
4.  Point camera at ticket QR code
    
5.  System auto-validates on detection
    

**Method 3: Quick Test**

1.  Scroll to Recent Tickets section
    
2.  Click Test next to any pending ticket
    

### Deleting Records

-   All delete actions show confirmation dialog
    
-   Records with dependencies cannot be deleted (FK protection)
    
-   Deleting a ticket restores the slot to its category
    

----------

## System Architecture

### Request Flow

```text
       Browser (Client)
              |
              v
       Apache Web Server
              |
              v
       PHP Backend Scripts
              | 
      +------------------+
      |                  |
      v                  v
MySQL Database    Python Scripts
      |                  |
      v                  v
PHP Processes      JSON Response
      |
      v
HTML and CSS Response
      |
      v
Browser Renders Page
```

### Flow Explanation

| Step | Description |
|-----|-----|
| 1 | User interacts with browser (clicks, forms, camera) |
| 2 | Apache receives HTTP request and routes to PHP |
| 3 | PHP executes business logic and validates input |
| 4 | PHP calls Python scripts via shell_exec for specialized tasks |
| 5 | Python processes and returns JSON or plain text| 
| 6 | PHP queries MySQL database as needed| 
| 7 | PHP formats data into HTML response |
| 8 | Browser renders page with CSS and JavaScript|

### Module Separation


| Layer | Components | Responsibility |
|-------|------------|----------------|
| Presentation | `index.php`, module `index.php` files | Display data in HTML tables and forms |
| Business Logic | `create.php`, `edit.php`, `delete.php` | Process form submissions, validate data |
| Python Integration | `generate_uuid.py`, `validate_ticket.py`, `generate_reports.py` | UUID generation, validation, reporting |
| Data Access | `config/database.php`, SQL queries | Connect to MySQL, execute CRUD operations |
| Shared | `includes/header.php`, `footer.php`, `functions.php` | Reusable UI components and helper functions |

----------

## Important Notes and Constraints

### Environment Requirements

-   Local Development Only: Designed for XAMPP and localhost
    
-   No External Hosting Required: Runs entirely on local machine
    
-   PHP Version: 7.4 or higher recommended
    
-   Python Version: 3.12 or higher required
    
-   Browser: Modern browser with camera support for QR scanning
    

### Project Limitations (Academic Scope)


| Feature | Status |
|--------|--------|
| Online payment gateway | Out of scope |
| SMS and Email notifications | Out of scope |
| Mobile application | Out of scope |
| Multi-campus support | Out of scope |
| User role management | Single admin user only |
| Password hashing | Plain text for demo purposes |

### Security Notes

-   Authentication is simplified for academic demonstration
    
-   In production, implement password hashing with password_hash()
    
-   Use prepared statements for all SQL queries
    
-   Add CSRF protection on forms
    
-   Implement session timeout management
    

----------

## Troubleshooting


| Issue | Solution |
|------|----------|
| Cannot connect to database | Verify MySQL is running in XAMPP Control Panel |
| Table not found | Ensure database was imported correctly |
| CSS not loading | Hard refresh with Ctrl + Shift + R |
| Python script not executing | Verify Python 3.12 is installed and in PATH |
| MySQL connector not found | Run: `py -m pip install mysql-connector-python` |
| Camera not working in Brave | Disable Shields Up for localhost in address bar |
| Camera access denied | Allow camera permission in browser settings |
| UUID generation fails | Check Python script path and permissions |
| Validation returns error | Verify Python script can connect to database |

----------

## License

This project is created for academic purposes as part of the Database Systems 1 curriculum. All rights reserved.

----------

## Acknowledgments

-   XAMPP - Local development environment
    
-   Python Software Foundation - Python programming language
    
-   html5-qrcode - Browser-based QR scanning library
    
-   QRCode.js - QR code generation library
    
-   MySQL Workbench - Database design and forward engineering
    

----------

_Last Updated: April 2026_