ALTER Table wms_lmb_header 
ADD Column manifest_complete TINYINT UNSIGNED after send_manifest;

UPDATE wms_lmb_header, log_manifest_header 
SET manifest_complete = log_manifest_header.status_complete 
WHERE wms_lmb_header.driver_register_id = log_manifest_header.driver_register_id;

UPDATE wms_lmb_header, wms_branch_manifest_header
SET manifest_complete = wms_branch_manifest_header.status_complete
WHERE wms_lmb_header.driver_register_id = wms_branch_manifest_header.driver_register_id;

/** Update manifest_header After Insert Trigger **/
DROP TRIGGER IF EXISTS manifest_header_insert;
DELIMITER $$
CREATE TRIGGER manifest_header_insert
AFTER INSERT ON log_manifest_header FOR EACH ROW
BEGIN
	IF NEW.r_driver_register_id IS NOT NULL THEN
		UPDATE tr_driver_registered
		SET has_manifest = true
		WHERE tr_driver_registered.id = NEW.r_driver_register_id;
	END IF;
	IF NEW.status_complete = 1 THEN
		UPDATE wms_lmb_header
		SET manifest_complete = NEW.status_complete
		WHERE wms_lmb_header.driver_register_id = NEW.driver_register_id;
	END IF;
END$$
DELIMITER ;

/** Update manifest_header After Update Trigger */
DROP TRIGGER IF EXISTS manifest_header_update;
DELIMITER $$
CREATE TRIGGER manifest_header_update
AFTER UPDATE ON log_manifest_header FOR EACH ROW
BEGIN
	IF OLD.r_driver_register_id IS NOT NULL
	AND NEW.r_driver_register_id <> OLD.r_driver_register_id THEN
		IF (SELECT COUNT(h.do_manifest_no)
		FROM log_manifest_header h
		WHERE h.r_driver_register_id = OLD.r_driver_register_id) < 1 THEN
			UPDATE tr_driver_registered
			SET has_manifest = NULL
			WHERE tr_driver_registered.id = OLD.r_driver_register_id;
		END IF;
	END IF;
	IF NEW.r_driver_register_id IS NOT NULL THEN
		UPDATE tr_driver_registered
		SET has_manifest = true
		WHERE tr_driver_registered.id = NEW.r_driver_register_id;
	END IF;
	IF NEW.status_complete = 1 THEN
		UPDATE wms_lmb_header
		SET manifest_complete = NEW.status_complete
		WHERE wms_lmb_header.driver_register_id = NEW.driver_register_id;
	END IF;
END$$
DELIMITER ;

/** Update branch_manifest_header After Insert Trigger **/
DROP TRIGGER IF EXISTS branch_manifest_header_insert;
DELIMITER $$
CREATE TRIGGER branch_manifest_header_insert
AFTER INSERT ON wms_branch_manifest_header FOR EACH ROW
BEGIN
	IF NEW.r_driver_register_id IS NOT NULL THEN
		UPDATE tr_driver_registered
		SET has_manifest = true
		WHERE tr_driver_registered.id = NEW.r_driver_register_id;
	END IF;
	IF NEW.status_complete = 1 THEN
		UPDATE wms_lmb_header
		SET manifest_complete = NEW.status_complete
		WHERE wms_lmb_header.driver_register_id = NEW.driver_register_id;
	END IF;
END$$
DELIMITER ;

/** Update branch_manifest_header After Update Trigger **/
DROP TRIGGER IF EXISTS branch_manifest_header_update;
DELIMITER $$
CREATE TRIGGER branch_manifest_header_update
AFTER UPDATE ON wms_branch_manifest_header FOR EACH ROW
BEGIN
	IF OLD.r_driver_register_id IS NOT NULL
	AND NEW.r_driver_register_id <> OLD.r_driver_register_id THEN
		IF (SELECT COUNT(h.do_manifest_no)
		FROM log_manifest_header h
		WHERE h.r_driver_register_id = OLD.r_driver_register_id) < 1 THEN
			UPDATE tr_driver_registered
			SET has_manifest = NULL
			WHERE tr_driver_registered.id = OLD.r_driver_register_id;
		END IF;
	END IF;
	IF NEW.r_driver_register_id IS NOT NULL THEN
		UPDATE tr_driver_registered
		SET has_manifest = true
		WHERE tr_driver_registered.id = NEW.r_driver_register_id;
	END IF;
	IF NEW.status_complete = 1 THEN
		UPDATE wms_lmb_header
		SET manifest_complete = NEW.status_complete
		WHERE wms_lmb_header.driver_register_id = NEW.driver_register_id;
	END IF;
END$$
DELIMITER ;