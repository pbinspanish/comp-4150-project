SELECT
    d.department_name,
    e.total_salary
FROM
    departments d
JOIN (
    SELECT
        SUM(s.salary) AS total_salary,
        e.department_id
    FROM
        employees e
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
    ) e
    ON e.department_id = d.department_id
ORDER BY
    e.total_salary DESC