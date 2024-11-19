-- updates an employees (currently set to 1) salary while limiting the maximum increase at a time

SET SERVEROUTPUT ON;

DECLARE
    -- Custom exception declaration
    e_invalid_salary EXCEPTION;
    
    -- Variables
    v_employee_id employees.employee_id%TYPE;
    v_new_salary salaries.salary%TYPE;
    v_old_salary salaries.salary%TYPE;
    v_max_increase CONSTANT NUMBER := 50; -- Maximum allowed percentage increase
    
BEGIN
    -- Get current salary for employee_id = 1
    SELECT
    salary
    INTO
    v_old_salary
    FROM
    salaries
    WHERE
    employee_id = 1
      AND end_date IS NULL;
    
    -- Attempt to update salary
    v_new_salary := &Enter_New_Salary;
    
    -- Check if salary increase is within allowed percentage
    IF (v_new_salary - v_old_salary) / v_old_salary * 100 > v_max_increase THEN
        RAISE e_invalid_salary;
    END IF;
    
    -- Update salary if validation passes
    UPDATE
    salaries
    SET
    end_date = SYSDATE
    WHERE
    employee_id = 1
    AND
    end_date IS NULL;
    
    INSERT INTO salaries (employee_id, start_date, salary)
    VALUES (1, SYSDATE, v_new_salary);
    
    COMMIT;
    DBMS_OUTPUT.PUT_LINE('Salary updated successfully');
    
EXCEPTION
    WHEN e_invalid_salary THEN
        DBMS_OUTPUT.PUT_LINE('Error: Salary increase cannot exceed ' || 
            v_max_increase || '%');
        ROLLBACK;
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('Error: Employee not found');
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
        ROLLBACK;
END;
/