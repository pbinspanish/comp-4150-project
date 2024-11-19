SELECT
    p.sex,
    AVG(s.salary) AS average_salary
FROM
    employees e
JOIN
    people p ON e.person_id = p.person_id
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
GROUP BY
    p.sex;