SELECT
    p.first_name,
    p.last_name,
    s.salary
FROM
    employees e
JOIN
    people p
    ON e.person_id = p.person_id
JOIN (
    SELECT
        employee_id,
        salary
    FROM
        salaries s1
    WHERE
        end_date IS NULL
    ) s
    ON e.employee_id = s.employee_id
WHERE
    s.salary > (
        SELECT
            AVG(salary)
        FROM
            salaries
        WHERE
            end_date IS NULL
    );