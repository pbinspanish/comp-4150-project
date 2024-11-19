-- Prints out sample data with the given types
-- does not read from the database

SET SERVEROUTPUT ON;

DECLARE
    -- Variable declarations
    v_emp_name VARCHAR2(100);
    v_emp_ssn CHAR(9);
    v_salary NUMBER(10,2);
    v_hire_date DATE;
    v_is_active BOOLEAN;
BEGIN
    -- Assign values
    v_emp_name := 'John Smith';
    v_emp_ssn := '123456789';
    v_salary := 75000.50;
    v_hire_date := TO_DATE('2024-01-15', 'YYYY-MM-DD');
    v_is_active := TRUE;
    
    -- Display values
    DBMS_OUTPUT.PUT_LINE('Employee Details:');
    DBMS_OUTPUT.PUT_LINE('-----------------');
    DBMS_OUTPUT.PUT_LINE('Name: ' || v_emp_name);
    DBMS_OUTPUT.PUT_LINE('SSN: ' || v_emp_ssn);
    DBMS_OUTPUT.PUT_LINE('Salary: $' || TO_CHAR(v_salary, '999,999.99'));
    DBMS_OUTPUT.PUT_LINE('Hire Date: ' || TO_CHAR(v_hire_date, 'DD-MON-YYYY'));
    
    -- use boolean to print status
    IF v_is_active THEN
        DBMS_OUTPUT.PUT_LINE('Status: Active Employee');
    ELSE
        DBMS_OUTPUT.PUT_LINE('Status: Inactive Employee');
    END IF;
END;
/