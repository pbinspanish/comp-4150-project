-- Q10: Write a PL/SQL code that declares variables of types NVARCHAR2, NCHAR, 
--      NUMBER, DATE, BOOLEAN and uses suitable executable section instructions to 
--      implement some actions and print some output. 

SET SERVEROUTPUT ON;

-- new variable declarations
DECLARE
    v_employee_name NVARCHAR2(50) := 'Alice Johnson';  
    v_job_title NCHAR(15) := 'Manager';                 
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
