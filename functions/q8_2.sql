-- Relates to the "Manage Projects" UI.
-- Package to handle project operations.


SET SERVEROUTPUT ON;
-- package specification
CREATE OR REPLACE PACKAGE project_pkg IS
    PROCEDURE add_project(p_name IN projects.project_name%TYPE, p_location_id IN projects.location_id%TYPE, p_department_id IN projects.department_id%TYPE);
    FUNCTION get_project_location(p_project_id IN projects.project_id%TYPE) RETURN VARCHAR2;
END project_pkg;
/

-- package body
CREATE OR REPLACE PACKAGE BODY project_pkg IS
    PROCEDURE add_project(p_name IN projects.project_name%TYPE, p_location_id IN projects.location_id%TYPE, p_department_id IN projects.department_id%TYPE) IS
    BEGIN
        INSERT INTO projects (project_id, project_name, location_id, department_id)
        VALUES (projects_seq.NEXTVAL, p_name, p_location_id, p_department_id);
        
        DBMS_OUTPUT.PUT_LINE('Project added successfully.');
    END add_project;

    FUNCTION get_project_location(p_project_id IN projects.project_id%TYPE) RETURN VARCHAR2 IS
        v_location_name VARCHAR2(200);
    BEGIN
        SELECT location_name
        INTO v_location_name
        FROM locations
        WHERE location_id = (SELECT location_id FROM projects WHERE project_id = p_project_id);
        
        RETURN v_location_name;
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            RETURN 'Location not found for this project.';
        WHEN OTHERS THEN
            RETURN 'Error: ' || SQLERRM;
    END get_project_location;
END project_pkg;
/

-- anonymous block to call the package functions
DECLARE
    v_project_id NUMBER; -- declare a variable for the new project ID
BEGIN
    project_pkg.add_project('New Project', 1, 2);

    SELECT projects_seq.CURRVAL INTO v_project_id FROM dual;

    DBMS_OUTPUT.PUT_LINE('Project Location: ' || project_pkg.get_project_location(v_project_id));
END;
/
