--
-- Used to create the tables for the Company schema
--

CREATE TABLE people (
    person_id                   INT PRIMARY KEY NOT NULL,
    first_name                  VARCHAR(2000) NOT NULL,
    middle_name                 VARCHAR(2000),
    last_name                   VARCHAR(2000) NOT NULL,
    birthday                    DATE,
    sex                         CHAR(1),
    ssn                         CHAR(9) NOT NULL,
    address                     VARCHAR(2000)
);


CREATE TABLE phone_numbers (
    person_id                   INT NOT NULL REFERENCES people(person_id),
    phone_number                CHAR(10) NOT NULL,
    phone_number_description    VARCHAR(2000) NOT NULL,
    CONSTRAINT phone_numbers_pk PRIMARY KEY (person_id, phone_number)
);


CREATE TABLE job_titles (
    title_id                    INT PRIMARY KEY NOT NULL,
    title_name                  VARCHAR(2000)
);


CREATE TABLE departments (
    department_id               INT PRIMARY KEY NOT NULL,
    department_name             VARCHAR(2000) NOT NULL UNIQUE,
    manager_start_date          DATE
);


CREATE TABLE employees (
    employee_id                 INT PRIMARY KEY NOT NULL,
    person_id                   INT REFERENCES people(person_id),
    title_id                    INT REFERENCES job_titles(title_id),
    supervisor_employee_id      INT REFERENCES employees(employee_id),
    department_id               INT NOT NULL REFERENCES departments(department_id)
);


CREATE TABLE dependents (
    employee_id                 INT NOT NULL REFERENCES employees(employee_id),
    person_id                   INT NOT NULL REFERENCES people(person_id),
    relationship                VARCHAR(2000),
    CONSTRAINT dependents_pk PRIMARY KEY (employee_id, person_id)
);


CREATE TABLE salaries (
    employee_id                 INT NOT NULL REFERENCES employees(employee_id),
    start_date                  DATE NOT NULL,
    end_date                    DATE,
    salary                      DECIMAL(10,2),
    CONSTRAINT salaries_pk PRIMARY KEY (employee_id, start_date)
);


CREATE TABLE locations (
    location_id                 INT PRIMARY KEY NOT NULL,
    location_name               VARCHAR(2000)
);


CREATE TABLE department_locations (
    department_id               INT PRIMARY KEY NOT NULL REFERENCES departments(department_id),
    location_id                 INT REFERENCES locations(location_id)
);


CREATE TABLE projects (
    project_id                  INT PRIMARY KEY NOT NULL,
    project_name                VARCHAR(2000) NOT NULL,
    location_id                 INT REFERENCES locations(location_id),
    department_id               INT NOT NULL REFERENCES departments(department_id)
);


CREATE TABLE works_on (
    employee_id                 INT NOT NULL,
    project_id                  INT REFERENCES projects(project_id),
    hours                       DECIMAL(3,1) NOT NULL,
    CONSTRAINT works_on_pk PRIMARY KEY (employee_id, project_id)
);