--
-- Used to drop the tables for the Company schema
--


DROP TABLE IF EXISTS people CASCADE CONSTRAINTS;
DROP TABLE IF EXISTS phone_numbers CASCADE CONSTRAINTS;
DROP TABLE IF EXISTS employees CASCADE CONSTRAINTS;
DROP TABLE IF EXISTS dependents CASCADE CONSTRAINTS;
DROP TABLE IF EXISTS salaries CASCADE CONSTRAINTS;
DROP TABLE IF EXISTS job_titles CASCADE CONSTRAINTS;
DROP TABLE IF EXISTS departments CASCADE CONSTRAINTS;
DROP TABLE IF EXISTS locations CASCADE CONSTRAINTS;
DROP TABLE IF EXISTS department_locations CASCADE CONSTRAINTS;
DROP TABLE IF EXISTS projects CASCADE CONSTRAINTS;
DROP TABLE IF EXISTS works_on CASCADE CONSTRAINTS;