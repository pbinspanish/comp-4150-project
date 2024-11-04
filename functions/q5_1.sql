-- calculates total department salary using a cursor

SET SERVEROUTPUT ON;

DECLARE
    v_dept_id departments.department_id%TYPE;
    v_start_date DATE;
    v_end_date DATE;
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
            e.department_id = v_dept_id
            AND s.start_date <= v_end_date
            AND (
                s.end_date IS NULL
                OR s.end_date >= v_start_date
            );
        
    v_months NUMBER;
BEGIN
    v_dept_id := 1;
    v_start_date := TO_DATE('2024-01-01', 'YYYY-MM-DD');
    v_end_date := TO_DATE('2024-12-31', 'YYYY-MM-DD');

    -- Calculate total cost for each employee
    FOR emp_rec IN c_dept_employees LOOP
        v_months := MONTHS_BETWEEN(v_end_date, v_start_date);
        v_total_cost := v_total_cost + (emp_rec.SALARY * v_months / 12);
    END LOOP;

    -- display results
    DBMS_OUTPUT.PUT_LINE('Department Cost Analysis:');
    DBMS_OUTPUT.PUT_LINE('Period: ' || TO_CHAR(v_start_date, 'DD-MON-YYYY') || 
        ' to ' || TO_CHAR(v_end_date, 'DD-MON-YYYY'));
    DBMS_OUTPUT.PUT_LINE('Total Cost: $' || TO_CHAR(v_total_cost, '999,999,999.99'));
END;
/