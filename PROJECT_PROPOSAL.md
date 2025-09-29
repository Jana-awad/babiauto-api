# Project Proposal

**Project Title:** BabiAuto – Car Rental Management System (API)

## Introduction

BabiAuto is a mobile-first car rental platform designed to simplify the process of booking, managing, and paying for rental vehicles. The project provides a **backend REST API** built with Laravel and SQL Server. It enables mobile and web clients to interact with the system for core rental functionalities such as user authentication, vehicle browsing, booking management, and payment processing.

## Objectives

- To develop a secure and scalable backend API for car rental management.
- To streamline the vehicle booking process for customers.
- To enable administrators to manage vehicles, features, insurances, and payments efficiently.
- To ensure data integrity and security through authentication, authorization, and validation.

## Scope of Work

The project scope covers the following:

1. **User Management**

   - Registration, login, logout, profile management.
   - JWT-based authentication.

2. **Vehicle Management**

   - Add, update, delete, and view vehicles.
   - Assign features to vehicles via pivot tables (e.g., GPS, child seat, air conditioning).

3. **Booking Management**

   - Customers can create, view, update, and cancel bookings.
   - Booking tied to vehicles, users, insurances, and payment records.

4. **Insurance & Payment Management**

   - CRUD APIs for insurance packages.
   - Payment tracking and booking confirmation.

5. **Feature Management**

   - CRUD APIs for features.
   - Many-to-many relationship between vehicles and features.

6. **API Security**

   - CSRF protection, secure headers, validation, prepared statements.
   - Role-based access (Admin vs Customer).

## Deliverables

- A complete Laravel-based REST API.
- Database schema and migrations.
- Eloquent models with relationships.
- Controllers and routes for all modules.
- Postman collection for API testing.
- Project documentation (README.md).

## Target Platform

- **Backend:** Laravel 11, PHP 8, SQL Server.
- **Frontend/Mobile:** To be developed in a later phase (Flutter/React Native).

## Expected Outcomes

- A fully functional backend API that supports user authentication, booking flows, and payment tracking.
- A clean, modular codebase that follows best practices.
- Documentation that enables team members or future developers to extend the project.

---

**Prepared by:** Jana Awad
**Project Type:** Internship (Backend Development)
**Date:** September 2025
