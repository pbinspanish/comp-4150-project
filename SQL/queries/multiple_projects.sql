SELECT
    p.first_name,
    p.last_name,
    COUNT(w.project_id) AS project_count
FROM
    people p
JOIN
    employees e
    ON p.person_id = e.person_id
JOIN
    works_on w
    ON e.employee_id = w.employee_id
GROUP BY
    p.first_name,
    p.last_name
HAVING
    COUNT(w.project_id) > 1;