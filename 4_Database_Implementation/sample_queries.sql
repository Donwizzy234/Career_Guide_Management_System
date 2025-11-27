-- ================================================
-- SAMPLE QUERIES FOR REPORTS & TESTING
-- ================================================

-- 1. Show all students
SELECT * FROM students;

-- 2. Show all careers
SELECT * FROM careers;

-- 3. Show all questions with their options
SELECT q.question_text, o.option_text, c.career_name, o.score
FROM options o
JOIN questions q ON o.question_id = q.question_id
JOIN careers c ON o.career_id = c.career_id
ORDER BY q.question_id;

-- 4. Total score of a student for each career
SELECT s.student_id, c.career_name, SUM(s.score) AS total_score
FROM student_scores s
JOIN careers c ON s.career_id = c.career_id
WHERE s.student_id = 1
GROUP BY c.career_id;

-- 5. Recommended career for a student
SELECT c.career_name
FROM student_scores s
JOIN careers c ON s.career_id = c.career_id
WHERE s.student_id = 1
GROUP BY c.career_id
ORDER BY SUM(s.score) DESC
LIMIT 1;

-- 6. Number of students per career (popularity chart)
SELECT c.career_name, COUNT(DISTINCT s.student_id) AS num_students
FROM student_scores s
RIGHT JOIN careers c ON s.career_id = c.career_id
GROUP BY c.career_id;

-- 7. Average score per career
SELECT c.career_name, AVG(s.score) AS avg_score
FROM student_scores s
JOIN careers c ON s.career_id = c.career_id
GROUP BY c.career_id;

-- 8. Delete a student's previous test result
DELETE FROM student_scores WHERE student_id = 1;

-- 9. Search for students by interest area
SELECT * FROM students WHERE interest_area LIKE '%Tech%';

-- 10. Show full psychometric result table
SELECT s.student_id, st.full_name, c.career_name, s.score
FROM student_scores s
JOIN students st ON s.student_id = st.student_id
JOIN careers c ON s.career_id = c.career_id
ORDER BY s.student_id;


