-- code for the "Manage Projects" UI screen.
-- declares variables with anchored types, prompts for input, fetches, and prints data.

SET SERVEROUTPUT ON;

DECLARE
    v_project_name projects.project_name%TYPE;
    v_department_id projects.department_id%TYPE;
    v_project_id projects.project_id%TYPE;
BEGIN
    -- get input
    v_project_id := &Enter_Project_ID;
    
    -- fetch project details from the database
    SELECT project_name, department_id
    INTO v_project_name, v_department_id
    FROM projects
    WHERE project_id = v_project_id;
    
    -- display results
    DBMS_OUTPUT.PUT_LINE('Project Information:');
    DBMS_OUTPUT.PUT_LINE('-----------------------');
    DBMS_OUTPUT.PUT_LINE('Project Name: ' || v_project_name);
    DBMS_OUTPUT.PUT_LINE('Department ID: ' || v_department_id);
END;
/
