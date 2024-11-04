-- relates to the "Assign Job Title" UI screen.
-- This script declares variables for employee job details and prints them.


SET SERVEROUTPUT ON;

DECLARE
    v_employee_name VARCHAR2(50) := 'Alice Johnson';
    v_job_title CHAR(15) := 'Manager';
    v_salary NUMBER(10,2) := 75000.00;
    v_join_date DATE := TO_DATE('2021-03-15', 'YYYY-MM-DD');
    v_is_active BOOLEAN := TRUE;
BEGIN
    -- Output employee job details
    DBMS_OUTPUT.PUT_LINE('--- Employee Job Details ---');
    DBMS_OUTPUT.PUT_LINE('Employee Name: ' || v_employee_name);
    DBMS_OUTPUT.PUT_LINE('Job Title: ' || v_job_title);
    DBMS_OUTPUT.PUT_LINE('Salary: $' || TO_CHAR(v_salary, '999,999.99'));
    DBMS_OUTPUT.PUT_LINE('Join Date: ' || TO_CHAR(v_join_date, 'DD-MON-YYYY'));
    DBMS_OUTPUT.PUT_LINE('Is Active: ' || CASE WHEN v_is_active THEN 'Yes' ELSE 'No' END);
END;
/
