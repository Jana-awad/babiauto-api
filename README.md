# babiauto-api

# Babiauto API

## Overview

The **Babiauto API** is a backend service designed to support the operations of the Babiauto platform. This API facilitates seamless communication between the frontend and the database, ensuring efficient data handling and processing.

## Features

- **Authentication**: Secure user authentication mechanisms.
- **Data Management**: CRUD operations for managing user data and other resources.
- **Real-time Capabilities**: Integration with real-time services for instant updates.
- **Scalability**: Designed to handle a growing number of users and requests.

## Technologies Used

- **Laravel**: A PHP framework for building robust and scalable applications.
- **Firebase**: Utilized for real-time data synchronization and authentication.
- **Postman**: API testing and documentation.

## Getting Started

### Prerequisites

Before setting up the project, ensure you have the following installed:

- PHP >= 7.4
- Composer
- Node.js and npm
- Firebase Service Account Key (refer to `serviceAccountKey-example.json`)

### Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/Jana-awad/babiauto-api.git
   cd babiauto-api
   ```

2. Install PHP dependencies:

composer install

3. Set up environment variables by copying the example file:

cp .env.example .env

Update the .env file with your database and Firebase credentials.

4. Generate the application key:

php artisan key:generate

5. Run database migrations:

php artisan migrate

6. Install Node.js dependencies (if applicable):

npm install

7. Serve the application:

php artisan serve

The API should now be running on http://localhost:8000.

### API Documentation

For detailed API endpoints and usage, refer to the included Postman collection:

Babiauto API.postman_collection.json

### Contributing

Contributions are welcome! Please fork the repository, create a new branch, and submit a pull request with your proposed changes.
