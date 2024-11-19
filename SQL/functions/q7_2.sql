-- function to retrieve the total number of employees in a department


SET SERVEROUTPUT ON;


CREATE OR REPLACE FUNCTION get_department_employee_count (
    p_department_id IN departments.department_id%TYPE
) RETURN NUMBER IS
    v_count NUMBER := 0; 
BEGIN
    SELECT COUNT(*)
    INTO v_count
    FROM employees
    WHERE department_id = p_department_id;

    RETURN v_count;

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        RETURN 0; -- return 0 if no employees are found
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
        RETURN NULL; -- return NULL on error
END;
/

-- anonymous block to call the function
DECLARE
    v_employee_count NUMBER;
BEGIN
    v_employee_count := get_department_employee_count(1); 
    DBMS_OUTPUT.PUT_LINE('Total employees: ' || v_employee_count);
END;
/
