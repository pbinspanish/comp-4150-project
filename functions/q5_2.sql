-- code for "Manage Projects" UI.
-- loops through projects for a specific department.

SET SERVEROUTPUT ON;

DECLARE

    CURSOR project_cursor IS
        SELECT project_name FROM projects WHERE department_id = 2;

    v_project projects.project_name%TYPE;  -- declaring variable with anchored type
BEGIN
    
    FOR proj IN project_cursor LOOP
        DBMS_OUTPUT.PUT_LINE('Project: ' || proj.project_name);
    END LOOP;

    -- check if no projects were found
    IF project_cursor%NOTFOUND THEN
        DBMS_OUTPUT.PUT_LINE('No projects found for Department ID 2.');
    END IF;
END;
/
