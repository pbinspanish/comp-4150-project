SELECT
	d.employee_id,
	n.first_name AS employee_first_name,
	n.last_name AS employee_last_name,
	d.relationship,
    p.first_name AS dependent_first_name,
	p.last_name AS dependent_last_name
FROM
	dependents d
JOIN (
		SELECT
			e.employee_id,
			p.first_name,
			p.last_name
		FROM
			employees e
		LEFT JOIN
			people p
			ON p.person_id = e.person_id
	) n
	ON d.employee_id = n.employee_id
LEFT JOIN
	people p
	ON d.person_id = p.person_id;