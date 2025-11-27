-- ================================================
-- CAREER GUIDE / PSYCHOMETRIC SYSTEM DATABASE
-- ================================================

CREATE DATABASE IF NOT EXISTS career_guide_db;
USE career_guide_db;

-- ================================================
-- TABLE: students
-- ================================================
DROP TABLE IF EXISTS students;
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    gender ENUM('Male','Female') NOT NULL,
    interest_area VARCHAR(150),
    password_hash VARCHAR(255) NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ================================================
-- TABLE: admins
-- ================================================
DROP TABLE IF EXISTS admins;
CREATE TABLE admins (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default admin (username: admin, password: admin123)
INSERT INTO admins (username, password_hash)
VALUES ('admin', '$2y$10$uUTCgOVaR8P0oolAiJvS7uZzUwMXc/8zaxj6NBo5jK6rYR8jlbE4i');
-- password = admin123

-- ================================================
-- TABLE: careers
-- ================================================
DROP TABLE IF EXISTS careers;
CREATE TABLE careers (
    career_id INT AUTO_INCREMENT PRIMARY KEY,
    career_name VARCHAR(120) NOT NULL UNIQUE,
    description TEXT
);

-- Sample careers
INSERT INTO careers (career_name, description) VALUES
('Software Developer', 'Builds software applications and systems.'),
('Nurse', 'Provides healthcare and patient support.'),
('Accountant', 'Manages financial records and transactions.'),
('Lawyer', 'Represents clients in legal matters.');

-- ================================================
-- TABLE: questions
-- ================================================
DROP TABLE IF EXISTS questions;
CREATE TABLE questions (
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    question_text TEXT NOT NULL
);

-- ================================================
-- TABLE: options (each option maps to a career)
-- ================================================
DROP TABLE IF EXISTS options;
CREATE TABLE options (
    option_id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT NOT NULL,
    option_text TEXT NOT NULL,
    career_id INT NOT NULL,
    score INT NOT NULL DEFAULT 1,
    FOREIGN KEY (question_id) REFERENCES questions(question_id) ON DELETE CASCADE,
    FOREIGN KEY (career_id) REFERENCES careers(career_id) ON DELETE CASCADE
);

-- ================================================
-- TABLE: student_scores
-- ================================================
DROP TABLE IF EXISTS student_scores;
CREATE TABLE student_scores (
    score_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    career_id INT NOT NULL,
    score INT NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (career_id) REFERENCES careers(career_id) ON DELETE CASCADE
);


-- ================================================
-- SAMPLE DATA: 20 QUESTIONS + OPTIONS
-- Run these inserts after creating the schema in `career_guide_db.sql`.
-- Each question has 4 options mapping to the 4 sample careers
-- (Software Developer=1, Nurse=2, Accountant=3, Lawyer=4)
-- ================================================

-- Question 1
INSERT INTO questions (question_text) VALUES ('I enjoy solving logical puzzles and writing code.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'I love programming and creating software solutions.', 1, 2),
(@qid, 'I prefer hands-on patient care and empathy-driven work.', 2, 1),
(@qid, 'Working with numbers and ledgers appeals to me.', 3, 1),
(@qid, 'I enjoy arguing a case and researching law.', 4, 1);

-- Question 2
INSERT INTO questions (question_text) VALUES ('I prefer tasks that require attention to detail and accuracy.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Debugging code and testing thoroughly.', 1, 2),
(@qid, 'Administering medications and following protocols.', 2, 2),
(@qid, 'Preparing accurate financial statements.', 3, 2),
(@qid, 'Drafting precise legal documents.', 4, 2);

-- Question 3
INSERT INTO questions (question_text) VALUES ('I enjoy helping others directly and being part of their recovery.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'I would like to care for patients and support their health.', 2, 2),
(@qid, 'I like building tools that help people digitally.', 1, 1),
(@qid, 'I prefer managing budgets to support services.', 3, 1),
(@qid, 'I would advocate for people''s rights and needs.', 4, 1);

-- Question 4
INSERT INTO questions (question_text) VALUES ('I enjoy analyzing data and spotting trends.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Using analytics to improve software systems.', 1, 2),
(@qid, 'Monitoring patient metrics and outcomes.', 2, 1),
(@qid, 'Analyzing financial data for decisions.', 3, 2),
(@qid, 'Researching case law statistics.', 4, 1);

-- Question 5
INSERT INTO questions (question_text) VALUES ('I like clear rules and working within established regulations.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Following coding standards and best practices.', 1, 1),
(@qid, 'Adhering to clinical protocols and safety rules.', 2, 2),
(@qid, 'Applying tax and accounting regulations.', 3, 2),
(@qid, 'Interpreting and applying laws.', 4, 2);

-- Question 6
INSERT INTO questions (question_text) VALUES ('I enjoy collaborating in teams to deliver projects.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Working on a software development team.', 1, 2),
(@qid, 'Coordinating with nurses and healthcare staff.', 2, 2),
(@qid, 'Collaborating with finance teams.', 3, 1),
(@qid, 'Working with colleagues on legal cases.', 4, 1);

-- Question 7
INSERT INTO questions (question_text) VALUES ('I enjoy research and long-form reading.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Researching algorithms and technical papers.', 1, 2),
(@qid, 'Reading clinical studies and care guidelines.', 2, 2),
(@qid, 'Studying financial regulations and reports.', 3, 1),
(@qid, 'Reading case law and legal precedents.', 4, 2);

-- Question 8
INSERT INTO questions (question_text) VALUES ('I prefer work that is fast-paced and can be unpredictable.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Responding to urgent bugs and incidents.', 1, 1),
(@qid, 'Handling emergencies and critical patient needs.', 2, 2),
(@qid, 'Fast-paced audit seasons appeal to me.', 3, 1),
(@qid, 'Courtroom schedules and hearings excite me.', 4, 1);

-- Question 9
INSERT INTO questions (question_text) VALUES ('I enjoy creative problem solving and designing new things.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Designing user interfaces and features.', 1, 2),
(@qid, 'Designing patient care plans creatively.', 2, 1),
(@qid, 'Creating novel accounting solutions.', 3, 1),
(@qid, 'Formulating novel legal strategies.', 4, 2);

-- Question 10
INSERT INTO questions (question_text) VALUES ('I prefer using tools and technology to improve processes.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Automating tasks with software.', 1, 2),
(@qid, 'Using medical equipment and digital records.', 2, 2),
(@qid, 'Implementing accounting software and controls.', 3, 2),
(@qid, 'Using legal research databases.', 4, 1);

-- Question 11
INSERT INTO questions (question_text) VALUES ('I enjoy teaching, mentoring, or explaining complex ideas.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Mentoring junior developers and explaining code.', 1, 2),
(@qid, 'Educating patients about their care.', 2, 2),
(@qid, 'Training staff on accounting practices.', 3, 1),
(@qid, 'Explaining legal rights and procedures.', 4, 1);

-- Question 12
INSERT INTO questions (question_text) VALUES ('I am comfortable with numbers and quantitative reasoning.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Writing algorithms that rely on numerical methods.', 1, 1),
(@qid, 'Interpreting clinical statistics.', 2, 1),
(@qid, 'Preparing and analyzing financial statements.', 3, 2),
(@qid, 'Quantitative legal analysis and damages calculation.', 4, 1);

-- Question 13
INSERT INTO questions (question_text) VALUES ('I enjoy talking to people and understanding their stories.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Interviewing users to shape software features.', 1, 1),
(@qid, 'Listening and supporting patients in care.', 2, 2),
(@qid, 'Advising clients on financial planning.', 3, 1),
(@qid, 'Interviewing clients and witnesses for cases.', 4, 2);

-- Question 14
INSERT INTO questions (question_text) VALUES ('I like structured tasks with clear outcomes.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Following software development sprints.', 1, 2),
(@qid, 'Following treatment plans step by step.', 2, 2),
(@qid, 'Closing monthly financial cycles.', 3, 2),
(@qid, 'Following case procedures towards resolution.', 4, 1);

-- Question 15
INSERT INTO questions (question_text) VALUES ('I prefer autonomy and being able to set my own methods.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Building side projects and independent coding.', 1, 2),
(@qid, 'Working independently during shifts.', 2, 1),
(@qid, 'Running your own accounting practice.', 3, 2),
(@qid, 'Operating as an independent legal counsel.', 4, 2);

-- Question 16
INSERT INTO questions (question_text) VALUES ('I enjoy learning new technologies and keeping skills current.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Learning new programming languages and frameworks.', 1, 2),
(@qid, 'Learning new medical procedures and treatments.', 2, 2),
(@qid, 'Keeping up with tax laws and accounting standards.', 3, 2),
(@qid, 'Keeping up with changes in law and precedent.', 4, 1);

-- Question 17
INSERT INTO questions (question_text) VALUES ('I remain calm under pressure and handle stressful situations well.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Handling production incidents calmly.', 1, 1),
(@qid, 'Working through medical emergencies.', 2, 2),
(@qid, 'Managing tight fiscal deadlines.', 3, 1),
(@qid, 'Handling courtroom pressure during trials.', 4, 2);

-- Question 18
INSERT INTO questions (question_text) VALUES ('I enjoy negotiating and persuading others.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Negotiating project scope with stakeholders.', 1, 1),
(@qid, 'Persuading patients to follow care plans.', 2, 1),
(@qid, 'Negotiating contracts and financial terms.', 3, 1),
(@qid, 'Arguing cases and persuading judges or juries.', 4, 2);

-- Question 19
INSERT INTO questions (question_text) VALUES ('I enjoy hands-on practical tasks more than desk work.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Prototyping hardware-software integrations.', 1, 1),
(@qid, 'Hands-on patient care and practical procedures.', 2, 2),
(@qid, 'Reviewing physical receipts and ledgers.', 3, 1),
(@qid, 'Inspecting evidence and preparing exhibits.', 4, 1);

-- Question 20
INSERT INTO questions (question_text) VALUES ('I like jobs that allow clear professional progression and certification.');
SET @qid = LAST_INSERT_ID();
INSERT INTO options (question_id, option_text, career_id, score) VALUES
(@qid, 'Pursuing senior developer and certification paths.', 1, 2),
(@qid, 'Gaining nursing certifications and specializations.', 2, 2),
(@qid, 'Becoming a certified accountant or CPA.', 3, 2),
(@qid, 'Becoming a senior advocate or obtaining bar credentials.', 4, 2);

-- End of sample questions