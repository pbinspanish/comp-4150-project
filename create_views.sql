--view employees and departments
CREATE VIEW vw_employees_departments AS
SELECT 
    employees.employee_id,
    people.first_name,
    people.last_name,
    job_titles.title_name AS job_title,
    departments.department_name
FROM 
    employees
JOIN 
    people ON employees.person_id = people.person_id
JOIN 
    job_titles ON employees.title_id = job_titles.title_id
JOIN 
    departments ON employees.department_id = departments.department_id;

--view employees salaries
CREATE VIEW vw_employee_salaries AS
SELECT 
    employees.employee_id,
    people.first_name,
    people.last_name,
    salaries.salary,
    salaries.start_date,
    salaries.end_date
FROM 
    employees
JOIN 
    people ON employees.person_id = people.person_id
JOIN 
    salaries ON employees.employee_id = salaries.employee_id;

--view employees working on projects
CREATE VIEW vw_employees_projects AS
SELECT 
    employees.employee_id,
    people.first_name,
    people.last_name,
    projects.project_name,
    works_on.hours
FROM 
    employees
JOIN 
    people ON employees.person_id = people.person_id
JOIN 
    works_on ON employees.employee_id = works_on.employee_id
JOIN 
    projects ON works_on.project_id = projects.project_id;

--view employees and dependents
CREATE VIEW vw_employees_dependents AS
SELECT 
    employees.employee_id,
    people.first_name AS employee_first_name,
    people.last_name AS employee_last_name,
    dependents.person_id AS dependent_id,
    dependents.relationship,
    (SELECT first_name FROM people WHERE people.person_id = dependents.person_id) AS dependent_first_name,
    (SELECT last_name FROM people WHERE people.person_id = dependents.person_id) AS dependent_last_name
FROM 
    employees
JOIN 
    people ON employees.person_id = people.person_id
JOIN 
    dependents ON employees.employee_id = dependents.employee_id;

--view projects and locations
CREATE VIEW vw_projects_locations AS
SELECT 
    projects.project_id,
    projects.project_name,
    locations.location_name,
    departments.department_name
FROM 
    projects
JOIN 
    locations ON projects.location_id = locations.location_id
JOIN 
    departments ON projects.department_id = departments.department_id;

--view department locations
CREATE VIEW vw_department_locations AS
SELECT 
    departments.department_id,
    departments.department_name,
    locations.location_id,
    locations.location_name
FROM 
    departments
JOIN 
    department_locations ON departments.department_id = department_locations.department_id
JOIN 
    locations ON department_locations.location_id = locations.location_id;

