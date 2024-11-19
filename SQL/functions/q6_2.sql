-- relates to the "Manage Salaries" UI.
-- procedure to update an employee's salary based on employee ID.

SET SERVEROUTPUT ON;
CREATE OR REPLACE PROCEDURE update_salary (
    p_employee_id IN employees.employee_id%TYPE,
    p_new_salary IN salaries.salary%TYPE,
    p_success OUT BOOLEAN,
    p_message OUT VARCHAR2(200)
) IS
BEGIN
    UPDATE salaries
    SET salary = p_new_salary
    WHERE employee_id = p_employee_id AND end_date IS NULL;

    -- check if the update was successful
    IF SQL%ROWCOUNT > 0 THEN
        p_success := TRUE;
        p_message := 'Salary updated successfully.';
    ELSE
        p_success := FALSE;
        p_message := 'No employee found with the provided ID or salary update failed.';
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        p_success := FALSE;
        p_message := 'Error: ' || SQLERRM;
END;
/

-- anonymous block to call the procedure
DECLARE
    v_success BOOLEAN;
    v_message VARCHAR2(200);
BEGIN
    update_salary(1, 80000, v_success, v_message);

    IF v_success THEN
        DBMS_OUTPUT.PUT_LINE(v_message);
    ELSE
        DBMS_OUTPUT.PUT_LINE('Update failed: ' || v_message);
    END IF;
END;
/
