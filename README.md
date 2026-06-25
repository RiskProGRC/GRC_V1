# RiskPRO GRC System

RiskPRO GRC is a comprehensive Governance, Risk, and Compliance management system designed to help organizations streamline their risk assessment, audit processes, and compliance monitoring activities.

## Features

- **Enterprise Risk Management (ERM)**: Track, assess, and manage organizational risks
- **Business Overview Configuration**: Configure company structure, departments, and organizational hierarchy
- **Internal Audit**: Plan, execute, and report on audit activities
- **Clean URL Structure**: Modern URL format without file extensions
- **Secure Authentication**: Support for both traditional login and OAuth 2.0 with Google
- **Domain Restriction**: Control access based on email domains for enhanced security

## Technology Stack

- PHP 8.0+
- MySQL Database
- Bootstrap 5 UI Framework
- Google OAuth 2.0 API

## Installation Instructions

### Prerequisites

- PHP 8.0 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Composer (for dependency management)

### Setup Steps

1. Clone the repository:
   ```
   git clone https://github.com//RiskProGRC/GRC.git
   cd GRC
   ```

2. Create the database:
   ```sql
   CREATE DATABASE risk_pro_grc;
   ```

3. Import the database schema:
   ```
   mysql -u username -p risk_pro_grc < db/schema.sql
   ```

4. Configure database connection:
   - Open `Project/connection/connectionClass.php` 
   - Update database credentials to match your environment

5. Configure Google OAuth (optional):
   - Create a project in [Google Cloud Console](https://console.cloud.google.com/)
   - Enable the Google OAuth API
   - Create OAuth Client ID credentials for a Web Application
   - Add your authorized redirect URI: `https://your-domain.com/registeraction.php`
   - Update the credentials in `config.php`

6. Set up your web server:
   - For Apache, ensure mod_rewrite is enabled
   - For Nginx, configure URL rewriting to use the router.php file

7. Start the development server:
   ```
   php -S localhost:8000 router.php
   ```

## Development Setup

For local development, you can use PHP's built-in server with the router:

```
php -S 127.0.0.1:8000 router.php
```

## Directory Structure

```
/
├── assets/          # CSS, JS, and image files
│   ├── css/
│   ├── js/
│   ├── images/
│   └── vendors/     # Third-party libraries
├── db/              # Database files
├── Project/         # Core application files
│   ├── audit/       # Audit module
│   ├── connection/  # Database connection
│   ├── dashboard/   # Dashboard views
│   ├── department/  # Department management
│   ├── login/       # Authentication
│   ├── settings/    # Application settings
│   └── users/       # User management
├── router.php       # URL router for clean URLs
├── index.php        # Application entry point
├── login.php        # Login page
├── registeraction.php # Google OAuth callback handler
└── systemover.php   # System overview dashboard
```

## Authentication

The system supports two authentication methods:

1. **Traditional Login**: Email and password authentication
2. **Google OAuth**: Single sign-on with Google accounts

Google OAuth can be restricted to specific domains (e.g., company email domains) or specific Gmail addresses for enhanced security.

## URL Routing

The application uses a custom router to provide clean URLs without the .php extension. This is implemented in `router.php`.

## Security Features

- Password hashing with bcrypt
- Domain restriction for Google logins
- Session management
- CSRF protection
- Input sanitization

## License

[License information]

## Support

For support or inquiries, please contact:
- Email: support@riskprogrc.com
- Website: https://riskprogrc.com

## Contributors

- [kirimimartin4409@gmail.com](mailto:kirimimartin4409@gmail.com)
- [timothykimemia01@gmail.com](mailto:timothykimemia01@gmail.com)
