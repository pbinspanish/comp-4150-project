-- calculates total department salary using a cursor (but called with a function)

SET SERVEROUTPUT ON;

-- Create the function
CREATE OR REPLACE FUNCTION calculate_employee_cost(
    p_department_id IN departments.department_id%TYPE,
    p_start_date IN DATE,
    p_end_date IN DATE
) RETURN NUMBER IS
    v_total_cost NUMBER := 0;
    
    -- Cursor to get all employees in department
    CURSOR c_dept_employees IS
        SELECT
            e.employee_id,
            s.salary
        FROM
            employees e
        JOIN
            salaries s
            ON e.employee_id = s.employee_id
        WHERE
            e.department_id = p_department_id
            AND s.start_date <= p_end_date
            AND (
                s.end_date IS NULL
                OR s.end_date >= p_start_date
            );
        
    v_months NUMBER;
BEGIN
    -- Calculate total cost for each employee
    FOR emp_rec IN c_dept_employees LOOP
        v_months := MONTHS_BETWEEN(p_end_date, p_start_date);
        v_total_cost := v_total_cost + (emp_rec.salary * v_months/12);
    END LOOP;
    
    RETURN v_total_cost;
    
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
        RETURN NULL;
END calculate_employee_cost;
/

-- call the function
DECLARE
    v_dept_id departments.department_id%TYPE := 1;
    v_start_date DATE := TO_DATE('2024-01-01', 'YYYY-MM-DD');
    v_end_date DATE := TO_DATE('2024-12-31', 'YYYY-MM-DD');
    v_total_cost NUMBER;
BEGIN
    v_total_cost := calculate_employee_cost(v_dept_id, v_start_date, v_end_date);
    
    DBMS_OUTPUT.PUT_LINE('Department Cost Analysis:');
    DBMS_OUTPUT.PUT_LINE('Period: ' || TO_CHAR(v_start_date, 'DD-MON-YYYY') || 
        ' to ' || TO_CHAR(v_end_date, 'DD-MON-YYYY'));
    DBMS_OUTPUT.PUT_LINE('Total Cost: $' || TO_CHAR(v_total_cost, '999,999,999.99'));
END;
/