--create index script

-- Indexes for employees table
CREATE INDEX IX_employees_person_id ON employees (person_id);
CREATE INDEX IX_employees_title_id ON employees (title_id);
CREATE INDEX IX_employees_department_id ON employees (department_id);
CREATE INDEX IX_employees_supervisor_employee_id ON employees (supervisor_employee_id);

-- Indexes for phone_numbers table
CREATE INDEX IX_phone_numbers_person_id ON phone_numbers (person_id);

-- Indexes for dependents table
CREATE INDEX IX_dependents_employee_id ON dependents (employee_id);
CREATE INDEX IX_dependents_person_id ON dependents (person_id);

-- Indexes for salaries table
CREATE INDEX IX_salaries_employee_id ON salaries (employee_id);
CREATE INDEX IX_salaries_end_date ON salaries (end_date);
CREATE INDEX IX_salaries_salary ON salaries (salary);  

-- Indexes for projects table
CREATE INDEX IX_projects_department_id ON projects (department_id);
CREATE INDEX IX_projects_location_id ON projects (location_id);

-- Indexes for department_locations table
CREATE INDEX IX_department_locations_location_id ON department_locations (location_id);

-- Indexes for works_on table
CREATE INDEX IX_works_on_employee_id ON works_on (employee_id);
CREATE INDEX IX_works_on_project_id ON works_on (project_id);
