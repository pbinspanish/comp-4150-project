SELECT
    p.first_name,
    p.last_name
FROM
    people p
JOIN
    employees e
    ON p.person_id = e.person_id
WHERE NOT EXISTS (
    SELECT
        project_id
    FROM
        projects
    WHERE
        project_id NOT IN (
            SELECT
                project_id
            FROM
                works_on
            WHERE 
                employee_id = e.employee_id
        )
    );