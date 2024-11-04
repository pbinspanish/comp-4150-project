-- creates and tests a package for employee management
-- allows for creation and deletion along with getting employee count

SET SERVEROUTPUT ON;

-- create the package
CREATE OR REPLACE PACKAGE emp_mgmt_pkg IS
    -- Function to get employee count by department
    FUNCTION get_dept_employee_count(
        p_department_id IN departments.department_id%TYPE
    ) RETURN NUMBER;
    
    -- Procedure to add new employee
    PROCEDURE add_employee(
        p_first_name IN people.first_name%TYPE,
        p_last_name IN people.last_name%TYPE,
        p_ssn IN people.ssn%TYPE,
        p_department_id IN departments.department_id%TYPE,
        p_title_id IN job_titles.title_id%TYPE,
        p_salary IN salaries.salary%TYPE,
        p_employee_id OUT employees.employee_id%TYPE,
        p_success OUT BOOLEAN,
        p_message OUT VARCHAR2
    );
    
    -- Procedure to terminate employee
    PROCEDURE terminate_employee(
        p_employee_id IN employees.employee_id%TYPE,
        p_termination_date IN DATE,
        p_success OUT BOOLEAN,
        p_message OUT VARCHAR2
    );
END emp_mgmt_pkg;
/

-- Package Body
CREATE OR REPLACE PACKAGE BODY emp_mgmt_pkg IS
    -- Implementation of get_dept_employee_count
    FUNCTION get_dept_employee_count(
        p_department_id IN departments.department_id%TYPE
    ) RETURN NUMBER IS
        v_count NUMBER;
    BEGIN
        SELECT
            COUNT(*)
        INTO
            v_count
        FROM
            employees
        WHERE
            department_id = p_department_id;
        
        RETURN v_count;
    EXCEPTION
        WHEN OTHERS THEN
            RETURN NULL;
    END get_dept_employee_count;
    
    -- Implementation of add_employee
    PROCEDURE add_employee(
        p_first_name IN people.first_name%TYPE,
        p_last_name IN people.last_name%TYPE,
        p_ssn IN people.ssn%TYPE,
        p_department_id IN departments.department_id%TYPE,
        p_title_id IN job_titles.title_id%TYPE,
        p_salary IN salaries.salary%TYPE,
        p_employee_id OUT employees.employee_id%TYPE,
        p_success OUT BOOLEAN,
        p_message OUT VARCHAR2
    ) IS
        v_person_id people.person_id%TYPE;
    BEGIN
        -- Insert new person
        SELECT
            NVL(MAX(person_id), 0) + 1 
        INTO
            v_person_id 
        FROM
            people;
        
        INSERT INTO people (person_id, first_name, last_name, ssn)
        VALUES (v_person_id, p_first_name, p_last_name, p_ssn);
        
        -- Insert new employee
        SELECT
            NVL(MAX(employee_id), 0) + 1 
        INTO
            p_employee_id 
        FROM
            employees;
        
        INSERT INTO employees (employee_id, person_id, title_id, department_id)
        VALUES (p_employee_id, v_person_id, p_title_id, p_department_id);
        
        -- Insert initial salary
        INSERT INTO salaries (employee_id, start_date, salary)
        VALUES (p_employee_id, SYSDATE, p_salary);
        
        COMMIT;
        p_success := TRUE;
        p_message := 'Employee successfully added with ID: ' || p_employee_id;
        
    EXCEPTION
        WHEN OTHERS THEN
            ROLLBACK;
            p_success := FALSE;
            p_message := 'Error adding employee: ' || SQLERRM;
    END add_employee;
    
    -- Implementation of terminate_employee
    PROCEDURE terminate_employee(
        p_employee_id IN employees.employee_id%TYPE,
        p_termination_date IN DATE,
        p_success OUT BOOLEAN,
        p_message OUT VARCHAR2
    ) IS
    BEGIN
        -- End current salary record
        UPDATE
            salaries
        SET
            end_date = p_termination_date
        WHERE
            employee_id = p_employee_id
            AND end_date IS NULL;
        
        IF SQL%ROWCOUNT = 0 THEN
            RAISE_APPLICATION_ERROR(-20001, 'Employee not found or already terminated');
        END IF;
        
        COMMIT;
        p_success := TRUE;
        p_message := 'Employee ' || p_employee_id || ' terminated as of ' || 
            TO_CHAR(p_termination_date, 'DD-MON-YYYY');
        
    EXCEPTION
        WHEN OTHERS THEN
            ROLLBACK;
            p_success := FALSE;
            p_message := 'Error terminating employee: ' || SQLERRM;
    END terminate_employee;
END emp_mgmt_pkg;
/

-- test the package
DECLARE
    v_employee_id employees.employee_id%TYPE;
    v_success BOOLEAN;
    v_message VARCHAR2(200);
    v_count NUMBER;
BEGIN
    -- Test adding new employee
    emp_mgmt_pkg.add_employee(
        p_first_name => 'Jane',
        p_last_name => 'Doe',
        p_ssn => '123456789',
        p_department_id => 1,
        p_title_id => 1,
        p_salary => 75000,
        p_employee_id => v_employee_id,
        p_success => v_success,
        p_message => v_message
    );
    
    IF v_success THEN
        DBMS_OUTPUT.PUT_LINE('Add employee: ' || v_message);
        
        -- Get department employee count
        v_count := emp_mgmt_pkg.get_dept_employee_count(1);
        DBMS_OUTPUT.PUT_LINE('Department employee count: ' || v_count);
        
        -- Test terminating employee
        emp_mgmt_pkg.terminate_employee(
            p_employee_id => v_employee_id,
            p_termination_date => SYSDATE + 14,
            p_success => v_success,
            p_message => v_message
        );
        
        DBMS_OUTPUT.PUT_LINE('Terminate employee: ' || v_message);
    ELSE
        DBMS_OUTPUT.PUT_LINE('Error: ' || v_message);
    END IF;
END;
/