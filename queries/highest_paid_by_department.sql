SELECT
    d.department_name,
    p.first_name,
    p.last_name,
    s.salary
FROM
    departments d
JOIN
    employees e
    ON d.department_id = e.department_id
JOIN
    people p
    ON e.person_id = p.person_id
JOIN (
    SELECT
        employee_id,
        salary
    FROM
        salaries s
    WHERE
        end_date IS NULL
    ) s
    ON e.employee_id = s.employee_id
WHERE (d.department_id, s.salary) IN (
    SELECT
        department_id,
        MAX(s.salary)
    FROM
        employees
    JOIN (
        SELECT
            employee_id,
            salary
        FROM
            salaries
        WHERE
            end_date IS NULL
        ) s
        ON e.employee_id = s.employee_id
    GROUP BY
        department_id
);