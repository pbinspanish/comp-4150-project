-- moves an employee to a new department

SET SERVEROUTPUT ON;

-- create the procedure
CREATE OR REPLACE PROCEDURE update_employee_department (
    p_employee_id IN employees.employee_id%TYPE,
    p_new_dept_name IN departments.department_name%TYPE,
    p_transfer_date IN DATE DEFAULT SYSDATE,
    p_success OUT BOOLEAN,
    p_message OUT VARCHAR2
) IS
    v_new_dept_id departments.department_id%TYPE;
    v_old_dept_id departments.department_id%TYPE;
    v_emp_name VARCHAR2(100);
BEGIN
    -- Get new department ID
    SELECT
    department_id
    INTO
    v_new_dept_id
    FROM
    departments
    WHERE
    department_name = p_new_dept_name;
    
    -- Get current info
    SELECT
    d.department_id,
    p.first_name || ' ' || p.last_name
    INTO
    v_old_dept_id,
    v_emp_name
    FROM
    employees e
    JOIN
    departments d
    ON e.department_id = d.department_id
    JOIN
    people p
    ON e.person_id = p.person_id
    WHERE
    e.employee_id = p_employee_id;
    
    -- Only update if department is actually changing
    IF v_new_dept_id != v_old_dept_id THEN
        UPDATE
      employees
    SET
      department_id = v_new_dept_id
        WHERE
      employee_id = p_employee_id;
        
        p_success := TRUE;
        p_message := 'Employee ' || v_emp_name || ' successfully transferred to ' || p_new_dept_name || ' department on ' || TO_CHAR(p_transfer_date, 'DD-MON-YYYY');
    ELSE
        p_success := FALSE;
        p_message := 'Employee ' || v_emp_name || ' is already in the ' || p_new_dept_name || ' department.';
    END IF;

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_success := FALSE;
        p_message := 'Invalid employee ID or department name provided.';
    WHEN OTHERS THEN
        p_success := FALSE;
        p_message := 'Error: ' || SQLERRM;
END update_employee_department;
/

-- call the procedure
DECLARE
    v_success BOOLEAN;
    v_message VARCHAR2(200);
BEGIN
    update_employee_department(
        p_employee_id => 1,
        p_new_dept_name => 'IT',
        p_transfer_date => SYSDATE,
        p_success => v_success,
        p_message => v_message
    );
    
    IF v_success THEN
        DBMS_OUTPUT.PUT_LINE('Transfer successful: ' || v_message);
    ELSE
        DBMS_OUTPUT.PUT_LINE('Transfer failed: ' || v_message);
    END IF;
END;
/