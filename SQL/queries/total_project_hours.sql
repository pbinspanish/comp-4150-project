SELECT
    p.project_name,
    SUM(w.hours) AS total_hours
FROM
    projects p
LEFT JOIN
    works_on w
    ON p.project_id = w.project_id
GROUP BY
    p.project_name
ORDER BY
    total_hours DESC;