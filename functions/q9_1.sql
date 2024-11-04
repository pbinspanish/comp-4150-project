-- creates a trigger and table to audit salary changes

SET SERVEROUTPUT ON;

-- Create audit table
CREATE TABLE salary_audit (
    audit_id NUMBER PRIMARY KEY,
    employee_id NUMBER,
    old_salary NUMBER,
    new_salary NUMBER,
    change_date DATE,
    change_user VARCHAR2(30),
    change_type VARCHAR2(20)
);

-- Create sequence for audit_id
CREATE SEQUENCE salary_audit_seq
    START WITH 1
    INCREMENT BY 1
    NOCACHE
    NOCYCLE;

-- Create trigger
CREATE OR REPLACE TRIGGER salary_audit_trg
AFTER INSERT OR UPDATE OR DELETE ON salaries
FOR EACH ROW
DECLARE
    v_change_type VARCHAR2(20);
BEGIN
    -- Determine the type of change
    IF INSERTING THEN
        v_change_type := 'INSERT';
    ELSIF UPDATING THEN
        v_change_type := 'UPDATE';
    ELSE
        v_change_type := 'DELETE';
    END IF;
    
    -- Log the salary change
    INSERT INTO salary_audit (
        audit_id,
        employee_id,
        old_salary,
        new_salary,
        change_date,
        change_user,
        change_type
    ) VALUES (
        salary_audit_seq.NEXTVAL,
        :NEW.employee_id,
        CASE 
            WHEN v_change_type = 'INSERT' THEN NULL
            ELSE :OLD.salary
        END,
        CASE 
            WHEN v_change_type = 'DELETE' THEN NULL
            ELSE :NEW.salary
        END,
        SYSDATE,
        USER,
        v_change_type
    );
END;
/

-- test the trigger
DECLARE
    v_employee_id employees.employee_id%TYPE := 1;
    v_old_salary salaries.salary%TYPE;
    v_new_salary salaries.salary%TYPE;
BEGIN
    -- Get current salary
    SELECT
        salary INTO v_old_salary
    FROM
        salaries
    WHERE
        employee_id = v_employee_id
        AND end_date IS NULL;
    
    -- Calculate new salary (10% increase)
    v_new_salary := v_old_salary * 1.1;
    
    -- Update salary
    UPDATE
        salaries
        SET end_date = SYSDATE
    WHERE
        employee_id = v_employee_id
        AND end_date IS NULL;
    
    -- Insert new salary record
    INSERT INTO salaries (employee_id, start_date, salary)
    VALUES (v_employee_id, SYSDATE, v_new_salary);
    
    -- Display audit records
    DBMS_OUTPUT.PUT_LINE('Salary Audit Records:');
    DBMS_OUTPUT.PUT_LINE('-------------------');
    
    FOR audit_rec IN (
        SELECT
            employee_id,
            old_salary,
            new_salary,
            TO_CHAR(change_date, 'DD-MON-YYYY HH24:MI:SS') as change_date,
            change_type
        FROM
            salary_audit
        WHERE
            employee_id = v_employee_id
        ORDER BY
            change_date DESC
    ) LOOP
        DBMS_OUTPUT.PUT_LINE(
            'Employee ID: ' || audit_rec.employee_id || 
            ' | Old Salary: $' || TO_CHAR(audit_rec.old_salary, '999,999.99') ||
            ' | New Salary: $' || TO_CHAR(audit_rec.new_salary, '999,999.99') ||
            ' | Change Type: ' || audit_rec.change_type ||
            ' | Date: ' || audit_rec.change_date
        );
    END LOOP;
    
    COMMIT;
END;
/