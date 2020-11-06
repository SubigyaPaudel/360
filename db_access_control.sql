CREATE USER "select_only" IDENTIFIED BY "IWantToSelect";
CREATE USER "DLM_user" IDENTIFIED BY "IWantTOChangeTheDatabase";

GRANT SELECT ON test.* TO "select_only" IDENTIFIED BY "IWantToSelect";
GRANT INSERT, DELETE, UPDATE ON test.* TO "DLM_user" IDENTIFIED BY "IWantTOChangeTheDatabase";