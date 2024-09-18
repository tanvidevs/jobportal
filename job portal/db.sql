-- Create database
CREATE DATABASE job_portal;

-- Use the created database
USE job_portal;

-- Create table for storing users (Admin, HR, Candidates)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'hr', 'candidate') NOT NULL,
    status TINYINT(1) DEFAULT 1 -- 1 for active, 0 for inactive
);

-- Create table for storing job postings
CREATE TABLE jobs (
    job_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    requirements TEXT,
    salary DECIMAL(10, 2),
    posted_by_hr INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (posted_by_hr) REFERENCES users(id)
);

-- Create table for storing candidate applications
CREATE TABLE applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    candidate_id INT,
    job_id INT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (candidate_id) REFERENCES users(id),
    FOREIGN KEY (job_id) REFERENCES jobs(job_id)
);

-- Create table for storing candidate details
CREATE TABLE candidates (
    candidate_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    resume VARCHAR(255),
    skills TEXT,
    experience TEXT,
    applied_jobs TEXT, -- Store job IDs as comma-separated values
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Sample data for users
INSERT INTO users (name, email, password, role, status) VALUES
('Admin User', 'admin@example.com', 'admin_password_hash', 'admin', 1),
('HR User', 'hr@example.com', 'hr_password_hash', 'hr', 1),
('Candidate User', 'candidate@example.com', 'candidate_password_hash', 'candidate', 1);

-- Sample data for jobs
INSERT INTO jobs (title, description, requirements, salary, posted_by_hr) VALUES
('Software Engineer', 'Develop and maintain web applications.', '3+ years experience in JavaScript, PHP', 60000, 2),
('Frontend Developer', 'Create user-friendly web interfaces.', 'Proficiency in HTML, CSS, JavaScript', 50000, 2);

-- Sample data for applications
INSERT INTO applications (candidate_id, job_id, status) VALUES
(3, 1, 'pending'),
(3, 2, 'approved');

-- Sample data for candidates
INSERT INTO candidates (user_id, resume, skills, experience, applied_jobs) VALUES
(3, 'resume.pdf', 'JavaScript, PHP, HTML, CSS', '2 years in frontend development', '1,2');
