-- ================================================
-- UPDATE / DELETE SAMPLE QUERIES
-- Use these for editing or removing questions/options during testing
-- Run these against the `career_guide_db` database (phpMyAdmin or mysql CLI)
-- ================================================

-- 0) Useful selects to inspect current data
-- List questions with options and careers
SELECT q.question_id, q.question_text, o.option_id, o.option_text, o.score, c.career_id, c.career_name
FROM questions q
LEFT JOIN options o ON q.question_id = o.question_id
LEFT JOIN careers c ON o.career_id = c.career_id
ORDER BY q.question_id, o.option_id;

-- Show a single question and its options
-- Replace ? with the question id, e.g. 5
SELECT q.question_id, q.question_text, o.option_id, o.option_text, o.score, c.career_name
FROM questions q
LEFT JOIN options o ON q.question_id = o.question_id
LEFT JOIN careers c ON o.career_id = c.career_id
WHERE q.question_id = 1
ORDER BY o.option_id;

-- ================================================
-- 1) Update a question text
-- Change the text for question_id = 3
UPDATE questions
SET question_text = 'New improved question text here'
WHERE question_id = 3;

-- 2) Update an option's text
-- Change option_id = 7
UPDATE options
SET option_text = 'Updated option text'
WHERE option_id = 7;

-- 3) Change which career an option maps to
-- Move option 7 to career_id = 2 (Nurse)
UPDATE options
SET career_id = 2
WHERE option_id = 7;

-- 4) Change an option's score
UPDATE options
SET score = 3
WHERE option_id = 7;

-- 5) Move multiple options to a different question
-- Move option ids 8 and 9 to question_id = 4
UPDATE options
SET question_id = 4
WHERE option_id IN (8,9);

-- 6) Delete a single option (non-recoverable unless you have a backup)
DELETE FROM options WHERE option_id = 10;

-- 7) Delete a question and its options (schema uses ON DELETE CASCADE)
-- WARNING: this will remove the question and ALL related options
DELETE FROM questions WHERE question_id = 6;

-- 8) Example transaction: update question and replace its options atomically
-- Replace options for question_id = 2 with three new options
START TRANSACTION;
    UPDATE questions SET question_text = 'Refreshed question text for Q2' WHERE question_id = 2;
    DELETE FROM options WHERE question_id = 2;
    INSERT INTO options (question_id, option_text, career_id, score) VALUES
        (2, 'New option A', 1, 2),
        (2, 'New option B', 3, 2),
        (2, 'New option C', 2, 2);
COMMIT;

-- 9) Restore safety tip: show last few actions if you need to audit (if binary log enabled)
-- For manual backups, export the affected rows before deleting:
-- SELECT * FROM questions WHERE question_id = 6;
-- SELECT * FROM options WHERE question_id = 6;

-- End of update/delete examples
