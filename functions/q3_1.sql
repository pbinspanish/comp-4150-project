-- calculates a potential bonus for an employee (presently set to 1) based on their years at the company

SET SERVEROUTPUT ON;

DECLARE
    v_employee_id employees.employee_id%TYPE;
    v_salary salaries.salary%TYPE;
    v_department_name departments.department_name%TYPE;
    v_years_of_service NUMBER;
    v_bonus_percentage NUMBER;
    v_start_date DATE;
BEGIN
    -- Get employee details with earliest start date from salary records
    SELECT
    e.employee_id, 
        s.salary, 
        d.department_name,
        TRUNC(MONTHS_BETWEEN(SYSDATE, MIN(s_hist.start_date)) / 12)
    INTO
    v_employee_id,
    v_salary,
    v_department_name,
    v_years_of_service
    FROM
    employees e
    JOIN
    salaries s
    ON e.employee_id = s.employee_id
    JOIN
    departments d
    ON e.department_id = d.department_id
    JOIN
    salaries s_hist
    ON e.employee_id = s_hist.employee_id
    WHERE
    e.employee_id = 1
      AND s.end_date IS NULL  -- Current salary
    GROUP BY
    e.employee_id, s.salary, d.department_name;
    
    -- Store start date
    SELECT
    MIN(start_date)
    INTO
    v_start_date
    FROM
    salaries
    WHERE
    employee_id = v_employee_id;
    
    -- Nested conditional logic for bonus calculation
    IF v_years_of_service >= 5 THEN
        IF v_department_name = 'IT' THEN
            v_bonus_percentage := 15;
        ELSIF v_department_name = 'Sales' THEN
            IF v_salary > 100000 THEN
                v_bonus_percentage := 12;
            ELSE
                v_bonus_percentage := 10;
            END IF;
        ELSE
            v_bonus_percentage := 8;
        END IF;
    ELSE
        IF v_department_name = 'Sales' THEN
            v_bonus_percentage := 7;
        ELSE
            v_bonus_percentage := 5;
        END IF;
    END IF;
    
    -- Display results
    DBMS_OUTPUT.PUT_LINE('Employee Bonus Analysis:');
    DBMS_OUTPUT.PUT_LINE('----------------------');
    DBMS_OUTPUT.PUT_LINE('Department: ' || v_department_name);
    DBMS_OUTPUT.PUT_LINE('Start Date: ' || TO_CHAR(v_start_date, 'DD-MON-YYYY'));
    DBMS_OUTPUT.PUT_LINE('Years of Service: ' || v_years_of_service || 
        ' (since ' || TO_CHAR(v_start_date, 'DD-MON-YYYY') || ')');
    DBMS_OUTPUT.PUT_LINE('Current Salary: $' || TO_CHAR(v_salary, '999,999.99'));
    DBMS_OUTPUT.PUT_LINE('Bonus Percentage: ' || v_bonus_percentage || '%');
    DBMS_OUTPUT.PUT_LINE('Bonus Amount: $' || 
        TO_CHAR((v_salary * v_bonus_percentage/100), '999,999.99'));
END;
/