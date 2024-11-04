-- Prints out employee First Name, Last Name, and current Salary for the given employee ID
-- Uses anchored types instead of explicitly declaring types

SET SERVEROUTPUT ON;

DECLARE
    v_first_name people.first_name%TYPE;
    v_last_name people.last_name%TYPE;
    v_salary salaries.salary%TYPE;
    v_person_id people.person_id%TYPE;
BEGIN
    -- Prompt for input
    v_person_id := &Enter_Person_ID;
    
    -- Fetch data from database
    SELECT
    p.first_name,
    p.last_name,
    s.salary
    INTO
    v_first_name,
    v_last_name,
    v_salary
    FROM
    people p
    JOIN
    employees e
    ON p.person_id = e.person_id
    JOIN
    salaries s
    ON e.employee_id = s.employee_id
    WHERE
    p.person_id = v_person_id
      AND s.end_date IS NULL;
    
    -- Display results
    DBMS_OUTPUT.PUT_LINE('Employee Information:');
    DBMS_OUTPUT.PUT_LINE('-----------------------');
    DBMS_OUTPUT.PUT_LINE('First Name: ' || v_first_name);
    DBMS_OUTPUT.PUT_LINE('Last Name: ' || v_last_name);
    DBMS_OUTPUT.PUT_LINE('Current Salary: $' || TO_CHAR(v_salary, '999,999.99'));
END;
/