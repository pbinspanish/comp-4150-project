-- code for "Manage Projects" UI
-- handles exception if project data is missing.
SET SERVEROUTPUT ON;


DECLARE
    v_project_id projects.project_id%TYPE := &Enter_Project_ID;
    v_project_name VARCHAR2(50);

BEGIN
    SELECT project_name INTO v_project_name FROM projects WHERE project_id = v_project_id;
    DBMS_OUTPUT.PUT_LINE('Project Name: ' || v_project_name);

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('Error: Project with ID ' || v_project_id || ' not found.');
END;
/

