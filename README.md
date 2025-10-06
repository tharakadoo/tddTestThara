# OneSyntax TDD Test - Tharaka Kasun

A simple subscription platform (RESTful APIs with MySQL, Vue.js UI) in which users can subscribe to
one or more websites

This app has:

- Endpoint to create a "post" for a "particular website".
- UI and Endpoint to allow user to subscribe to a "particular website" with validations.
- Use queues to schedule sending in the background.
- Follow TDD when implementing all the features.
- Migrations for the required tables.
- No duplicate posts should get sent to subscribers by email.

- Seeded data of the websites. (UsersSeeder, WebsiteSeeder).
- Postman collection demonstrating available APIs & their usage (TDD Test Thara.postman_collection.json).
- Use of the latest Laravel version (12).
- Use of contracts & services (EmailServiceContract, EmailService).
- Use of caching wherever applicable (Caching Users in Test Cases).
- Use of events/listeners (PostPublished, SendPostPublishedEmail).


---

## Installation

```bash
# Clone the repo
git clone https://github.com/tharakadoo/tddTestThara
cd tddTestThara

# Install dependencies
composer install

# Set up environment
cp .env.example .env
php artisan key:generate

# Install API routes
php artisan install:api

# Run migrations
php artisan migrate

#Run Seeders
php artisan db:seed

# Start server
php artisan serve

#Start Dev Server
npm run dev

#Run Tests
php artisan test

#Browse Vue js subscribe page
http://127.0.0.1:8000

#How to run postman collection
Details are available in collection index page

```

## Time Spent on this
12 Hours
