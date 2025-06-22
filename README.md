# Conference Management System

**Conference Management System** is designed to streamline the management of conferences by handling various tasks such as participant registration, session scheduling, and more.

## Table of Contents

1. [Introduction](#introduction)
2. [Features](#features)
3. [Installation](#installation)
4. [Usage](#usage)
5. [Technologies Used](#technologies-used)
6. [Contributing](#contributing)
7. [Contact](#contact)

## Introduction

The **Conference Management System** is a comprehensive solution developed to automate and simplify the process of managing conferences, workshops, and similar events. It provides a user-friendly interface for organizers, speakers, and participants, ensuring a seamless experience from start to finish. Whether you are hosting a small workshop or a large international conference, this system caters to all your needs.

## Features

- **User Management**: 
  - Register, update, and delete users.
  - Role-based access control for administrators, organizers, speakers, and participants.

- **Conference Scheduling**:
  - Create and manage conference events.
  - Schedule sessions, keynotes, and workshops.
  - Automatic conflict detection for overlapping sessions.

- **Participant Registration**:
  - Online registration for attendees.
  - Payment integration for conference fees.
  - Generate badges and tickets.

- **Abstract and Paper Submission**:
  - Submission portal for authors.
  - Blind peer review process.
  - Manage submission status and notifications.

- **Notifications and Announcements**:
  - Automated email notifications.
  - Push notifications for important updates.
  - Announcements board for organizers.

- **Reporting and Analytics**:
  - Attendance tracking and reporting.
  - Export data in various formats.
  - Dashboard for real-time analytics.

- **Feedback and Surveys**:
  - Post-conference surveys for attendees.
  - Analyze feedback for future improvements.

### Prerequisites

- Python 3.8 or higher
- Django 3.2 or higher
- PostgreSQL 12 or higher
- Node.js 14 or higher (for frontend dependencies)

### Installation Steps

1. **Clone the repository**:

   ```bash
   git clone https://github.com/yourusername/conference-management-system.git
   cd conference-management-system
   ```

2. **Set up a virtual environment**:

   ```bash
   python -m venv venv
   source venv/bin/activate  # On Windows use `venv\Scripts\activate`
   ```

3. **Install backend dependencies**:

   ```bash
   pip install -r requirements.txt
   ```

4. **Configure the database**:

   Edit the `settings.py` file in the `conference_management` directory to update the database configuration with your PostgreSQL settings.

   ```python
   DATABASES = {
       'default': {
           'ENGINE': 'django.db.backends.postgresql',
           'NAME': 'conference_db',
           'USER': 'yourusername',
           'PASSWORD': 'yourpassword',
           'HOST': 'localhost',
           'PORT': '5432',
       }
   }
   ```

5. **Run database migrations**:

   ```bash
   python manage.py migrate
   ```

6. **Install frontend dependencies**:

   ```bash
   npm install
   npm run build
   ```

7. **Start the development server**:

   ```bash
   python manage.py runserver
   ```

8. **Access the application**:

   Open your web browser and go to `http://127.0.0.1:8000` to access the Conference Management System.

## Usage

The Conference Management System is designed for ease of use and accessibility. Here is a quick guide on how to navigate through the system:

### Administrator

- **Dashboard**: View overall statistics and system status.
- **Manage Users**: Add, edit, and remove users. Assign roles and permissions.
- **Setup Conference**: Create new conferences and manage existing ones.
- **Reports**: Generate reports for attendee statistics, session popularity, and financial summaries.

### Organizer

- **Conference Overview**: Manage conference details, including sessions and speakers.
- **Session Scheduling**: Add and arrange sessions. Ensure there are no conflicts.
- **Participant Registration**: Monitor registrations and handle inquiries.

### Speaker

- **Profile Management**: Update personal information and speaker bio.
- **Submit Abstracts**: Upload abstracts and papers for review.
- **Session Schedule**: View assigned sessions and times.

### Participant

- **Registration**: Sign up for the conference and receive a confirmation email.
- **My Schedule**: View personal schedule and registered sessions.
- **Feedback**: Provide feedback on sessions attended.

## System Architecture

The Conference Management System is built with a modern web application architecture, consisting of the following components:

1. **Frontend**: Developed using React.js for a responsive and dynamic user interface.
2. **Backend**: Powered by Django, providing a robust framework for handling business logic and data processing.
3. **Database**: PostgreSQL is used for data storage, ensuring reliability and performance.
4. **API**: RESTful API endpoints are created using Django REST Framework for seamless communication between the frontend and backend.

## Technologies Used

- **Frontend**: HTML , CSS , JS
- **Backend**: PHP
- **Database**: MSSQL

## Contributing

Contributions to the Conference Management System are welcome and appreciated. To contribute, please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bugfix.
3. Make your changes and commit them with clear and descriptive messages.
4. Push your changes to your fork.
5. Submit a pull request with a detailed description of your changes.

Please ensure that your code follows the project's coding standards and includes appropriate tests.

## Contact

For any questions or inquiries, please contact the project maintainers:

- **Project Lead**: Görkem Turkut (gorkemturkut@hotmail.com)
- [My GitHub Profile](https://github.com/gorkemturkut57)
