-- code for "Manage Projects" UI
-- uses nested conditions to determine project status and print project details.

SET SERVEROUTPUT ON;

DECLARE
    v_project_id projects.project_id%TYPE := &Enter_Project_ID;
    v_project_name projects.project_name%TYPE;
    v_location_id projects.location_id%TYPE;
    v_department_id projects.department_id%TYPE;
    v_status VARCHAR2(50);
BEGIN
    -- retrieve project data
    SELECT project_name, location_id, department_id
    INTO v_project_name, v_location_id, v_department_id
    FROM projects
    WHERE project_id = v_project_id;

    -- nested conditional statement
    IF v_department_id = 1 THEN
        IF v_location_id = 1 THEN
            v_status := 'High Priority in HR Department';
        ELSE
            v_status := 'Standard Priority for HR Department';
        END IF;
    ELSIF v_department_id = 4 THEN
        IF v_location_id = 3 THEN
            v_status := 'Urgent Network Upgrade';
        ELSE
            v_status := 'General IT Project';
        END IF;
    ELSE
        IF v_location_id = 2 THEN
            v_status := 'Active Project in Marketing';
        ELSE
            v_status := 'General Project';
        END IF;
    END IF;

    -- display project details
    DBMS_OUTPUT.PUT_LINE('Project Information:');
    DBMS_OUTPUT.PUT_LINE('----------------------');
    DBMS_OUTPUT.PUT_LINE('Project Name: ' || v_project_name);
    DBMS_OUTPUT.PUT_LINE('Location ID: ' || v_location_id);
    DBMS_OUTPUT.PUT_LINE('Department ID: ' || v_department_id);
    DBMS_OUTPUT.PUT_LINE('Status: ' || v_status);
END;
/
