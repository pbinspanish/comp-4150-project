SELECT DISTINCT
    p.first_name,
    p.last_name
FROM
    people p
JOIN
    employees e
    ON p.person_id = e.person_id
WHERE
    e.title_id = 1; -- manager job title id