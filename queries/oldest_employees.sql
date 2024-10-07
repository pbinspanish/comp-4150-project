SELECT
    d.department_name,
    p.first_name,
    p.last_name,
    p.birthday
FROM
    departments d
JOIN
    employees e
    ON d.department_id = e.department_id
JOIN
    people p
    ON e.person_id = p.person_id
WHERE (d.department_id, p.birthday) IN (
    SELECT
        e2.department_id,
        MIN(p2.birthday)
    FROM
        employees e2
    JOIN
        people p2
        ON e2.person_id = p2.person_id
    GROUP BY
        e2.department_id
);