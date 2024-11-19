SELECT
	d.department_name,
	COUNT(e.employee_id) AS employee_count
FROM
	departments d
LEFT JOIN
	employees e
	ON d.department_id = e.department_id
GROUP BY
	d.department_name;