SELECT
	p.project_name
FROM
	projects p
LEFT JOIN
	works_on w
	ON p.project_id = w.project_id
WHERE
	w.employee_id IS NULL;