/** DROP TRIGGER's **/
DROP TRIGGER IF EXISTS manifest_header_insert;
DROP TRIGGER IF EXISTS manifest_header_update;
DROP TRIGGER IF EXISTS manifest_header_delete;
DROP TRIGGER IF EXISTS branch_manifest_header_insert;
DROP TRIGGER IF EXISTS branch_manifest_header_update;
DROP TRIGGER IF EXISTS pickinglist_header_insert;
DROP TRIGGER IF EXISTS pickinglist_header_update;
DROP TRIGGER IF EXISTS pickinglist_header_delete;

/** log_manifest_header **/
ALTER Table log_manifest_header RENAME TO ar_manifest_header;
CREATE TABLE `log_manifest_header` (
	`driver_register_id` varchar(50) NOT NULL,
	`do_manifest_no` varchar(50) NOT NULL PRIMARY KEY,
	`expedition_code` varchar(3) DEFAULT NULL,
	`expedition_name` varchar(100) DEFAULT NULL,
	`driver_id` varchar(10) DEFAULT NULL,
	`driver_name` varchar(100) DEFAULT NULL,
	`vehicle_number` varchar(11) DEFAULT NULL,
	`vehicle_code_type` varchar(6) DEFAULT NULL,
	`vehicle_description` varchar(150) DEFAULT NULL,
	`do_manifest_date` date DEFAULT NULL,
	`do_manifest_time` datetime NOT NULL,
	`destination_number_driver` varchar(6) DEFAULT NULL,
	`destination_name_driver` varchar(100) DEFAULT NULL,
	`city_code` varchar(10) DEFAULT NULL,
	`city_name` varchar(100) DEFAULT NULL,
	`container_no` varchar(20) DEFAULT NULL,
	`seal_no` varchar(20) DEFAULT NULL,
	`checker` varchar(50) DEFAULT NULL,
	`pdo_no` varchar(50) DEFAULT NULL,
	`area` varchar(20) DEFAULT NULL,
	`status_complete` tinyint(4) NOT NULL,
	`urut_manifest` int(11) NOT NULL,
	`tcs` tinyint(4) NOT NULL,
	`ambil_sendiri` tinyint(4) NOT NULL,
	`id_freight_cost` int(11) DEFAULT NULL,
	`ritase` decimal(18,3) NOT NULL,
	`cbm` decimal(18,3) NOT NULL,
	`manifest_return` tinyint(4) NOT NULL,
	`manifest_type` varchar(20) NOT NULL,
	`status_inv_recieve` tinyint(4) NOT NULL,
	`have_lcl` tinyint(4) NOT NULL,
	`lcl_from_driver_register_id` varchar(50) DEFAULT NULL,
	`lcl_from_manifest_no` varchar(50) DEFAULT NULL,
	`lcl_created_date` datetime DEFAULT NULL,
	`lcl_created_by` varchar(50) DEFAULT NULL,
	`have_resend` tinyint(4) NOT NULL,
	`manifest_resend` tinyint(4) NOT NULL,
	`r_from_manifest` varchar(50) DEFAULT NULL,
	`r_driver_register_id` varchar(50) DEFAULT NULL,
	`r_create_date` datetime DEFAULT NULL,
	`r_create_by` varchar(50) DEFAULT NULL,
	`created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
	`created_by` int(11) DEFAULT NULL,
	`updated_by` int(11) DEFAULT NULL
);
INSERT INTO log_manifest_header
SELECT * FROM ar_manifest_header WHERE status_complete <> 1 OR created_at >= (NOW() - INTERVAL 3 MONTH);
DELETE FROM ar_manifest_header WHERE status_complete <> 1 OR created_at >= (NOW() - INTERVAL 3 MONTH);

/** log_manifest_detail **/
ALTER Table log_manifest_detail RENAME TO ar_manifest_detail;
CREATE TABLE `log_manifest_detail` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`do_manifest_no` varchar(50) NOT NULL,
	`tr_concept_id` varchar(60) DEFAULT NULL,
	`no_urut` int(11) DEFAULT NULL,
	`delivery_no` varchar(50) DEFAULT NULL,
	`delivery_items` int(11) DEFAULT NULL,
	`invoice_no` varchar(50) DEFAULT NULL,
	`line_no` int(11) DEFAULT NULL,
	`ambil_sendiri` tinyint(4) DEFAULT NULL,
	`model` varchar(50) DEFAULT NULL,
	`expedition_code` varchar(50) DEFAULT NULL,
	`expedition_name` varchar(50) DEFAULT NULL,
	`sold_to` varchar(50) DEFAULT NULL,
	`sold_to_code` varchar(50) DEFAULT NULL,
	`sold_to_street` varchar(50) DEFAULT NULL,
	`ship_to` varchar(50) DEFAULT NULL,
	`ship_to_code` varchar(50) DEFAULT NULL,
	`city_code` varchar(50) DEFAULT NULL,
	`city_name` varchar(50) DEFAULT NULL,
	`do_date` varchar(50) DEFAULT NULL,
	`quantity` int(11) DEFAULT NULL,
	`cbm` decimal(18,3) DEFAULT NULL,
	`area` varchar(50) DEFAULT NULL,
	`do_internal` varchar(50) DEFAULT NULL,
	`reservasi_no` varchar(50) DEFAULT NULL,
	`nilai_ritase` decimal(18,3) NOT NULL,
	`nilai_ritase2` decimal(18,3) NOT NULL,
	`nilai_cbm` decimal(18,3) NOT NULL,
	`code_sales` varchar(50) DEFAULT NULL,
	`tcs` tinyint(4) DEFAULT NULL,
	`multidro` decimal(18,3) DEFAULT NULL,
	`unloading` decimal(18,3) DEFAULT NULL,
	`overstay` decimal(18,3) DEFAULT NULL,
	`do_return` tinyint(4) NOT NULL,
	`status_confirm` tinyint(4) NOT NULL,
	`confirm_date` datetime DEFAULT NULL,
	`confirm_by` varchar(50) DEFAULT NULL,
	`lead_time` int(11) NOT NULL,
	`base_price` decimal(18,3) DEFAULT NULL,
	`kode_cabang` varchar(50) DEFAULT NULL,
	`region` varchar(50) DEFAULT NULL,
	`remarks` varchar(50) DEFAULT NULL,
	`actual_time_arrival` datetime DEFAULT NULL,
	`actual_loading_date` datetime DEFAULT NULL,
	`doc_do_return_date` datetime DEFAULT NULL,
	`status_ds_done` tinyint(4) NOT NULL,
	`do_reject` tinyint(4) NOT NULL,
	`created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
	`created_by` int(11) DEFAULT NULL,
	`updated_by` int(11) DEFAULT NULL
);
INSERT INTO log_manifest_detail
SELECT ar_manifest_detail.* 
FROM ar_manifest_detail 
JOIN log_manifest_header on log_manifest_header.do_manifest_no = ar_manifest_detail.do_manifest_no;
DELETE ar FROM ar_manifest_detail ar
LEFT JOIN log_manifest_detail log on log.id = ar.id
WHERE log.id IS NOT NULL;


/** wms_branch_manifest_header **/
ALTER TABLE `wms_branch_manifest_header` RENAME TO ar_branch_manifest_header;
CREATE TABLE `wms_branch_manifest_header` (
	`driver_register_id` varchar(50) NOT NULL,
	`do_manifest_no` varchar(50) NOT NULL PRIMARY KEY,
	`expedition_code` varchar(3) DEFAULT NULL,
	`expedition_name` varchar(100) DEFAULT NULL,
	`driver_id` varchar(10) DEFAULT NULL,
	`driver_name` varchar(100) DEFAULT NULL,
	`vehicle_number` varchar(11) DEFAULT NULL,
	`vehicle_code_type` varchar(6) DEFAULT NULL,
	`vehicle_description` varchar(150) DEFAULT NULL,
	`do_manifest_date` date DEFAULT NULL,
	`do_manifest_time` datetime DEFAULT NULL,
	`destination_number_driver` varchar(6) DEFAULT NULL,
	`destination_name_driver` varchar(100) DEFAULT NULL,
	`city_code` varchar(10) DEFAULT NULL,
	`city_name` varchar(100) DEFAULT NULL,
	`container_no` varchar(20) DEFAULT NULL,
	`seal_no` varchar(20) DEFAULT NULL,
	`checker` varchar(50) DEFAULT NULL,
	`pdo_no` varchar(50) DEFAULT NULL,
	`created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
	`created_by` int(11) DEFAULT NULL,
	`updated_by` int(11) DEFAULT NULL,
	`kode_cabang` varchar(20) DEFAULT NULL,
	`status_complete` tinyint(4) NOT NULL,
	`urut_manifest` int(11) NOT NULL,
	`tcs` tinyint(4) NOT NULL,
	`ambil_sendiri` tinyint(4) NOT NULL,
	`id_freight_cost` int(11) DEFAULT NULL,
	`ritase` decimal(18,3) NOT NULL,
	`cbm` decimal(18,3) NOT NULL,
	`manifest_return` tinyint(4) NOT NULL,
	`manifest_type` varchar(20) NOT NULL,
	`status_inv_recieve` tinyint(4) NOT NULL,
	`have_lcl` tinyint(4) NOT NULL,
	`lcl_from_driver_register_id` varchar(50) DEFAULT NULL,
	`lcl_from_manifest_no` varchar(50) DEFAULT NULL,
	`lcl_created_date` datetime DEFAULT NULL,
	`lcl_created_by` varchar(50) DEFAULT NULL,
	`have_resend` tinyint(4) NOT NULL,
	`manifest_resend` tinyint(4) NOT NULL,
	`r_from_manifest` varchar(50) DEFAULT NULL,
	`r_driver_register_id` varchar(50) DEFAULT NULL,
	`r_created_date` datetime DEFAULT NULL,
	`r_created_by` varchar(50) DEFAULT NULL
);
INSERT INTO wms_branch_manifest_header
SELECT * FROM ar_branch_manifest_header WHERE status_complete <> 1 OR created_at >= (NOW() - INTERVAL 3 MONTH);
DELETE FROM ar_branch_manifest_header WHERE status_complete <> 1 OR created_at >= (NOW() - INTERVAL 3 MONTH);

/** wms_branch_manifest_detail **/
ALTER TABLE wms_branch_manifest_detail RENAME TO ar_branch_manifest_detail;
CREATE TABLE `wms_branch_manifest_detail` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`do_manifest_no` varchar(50) NOT NULL,
	`no_urut` int(11) DEFAULT NULL,
	`delivery_no` varchar(20) DEFAULT NULL,
	`invoice_no` varchar(10) DEFAULT NULL,
	`ambil_sendiri` tinyint(4) DEFAULT NULL,
	`model` varchar(50) DEFAULT NULL,
	`expedition_code` varchar(3) DEFAULT NULL,
	`expedition_name` varchar(100) DEFAULT NULL,
	`sold_to` varchar(100) DEFAULT NULL,
	`sold_to_code` varchar(10) DEFAULT NULL,
	`sold_to_street` varchar(200) DEFAULT NULL,
	`ship_to` varchar(100) DEFAULT NULL,
	`ship_to_code` varchar(10) DEFAULT NULL,
	`city_code` varchar(10) DEFAULT NULL,
	`city_name` varchar(100) DEFAULT NULL,
	`do_date` varchar(12) DEFAULT NULL,
	`quantity` int(11) DEFAULT NULL,
	`cbm` decimal(18,3) DEFAULT NULL,
	`created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
	`created_by` int(11) DEFAULT NULL,
	`updated_by` int(11) DEFAULT NULL,
	`branch_id` varchar(20) DEFAULT NULL,
	`do_internal` varchar(50) DEFAULT NULL,
	`reservasi_no` varchar(50) DEFAULT NULL,
	`nilai_ritase` decimal(18,3) NOT NULL,
	`nilai_ritase2` decimal(18,3) NOT NULL,
	`nilai_cbm` decimal(18,3) NOT NULL,
	`code_sales` varchar(2) DEFAULT NULL,
	`tcs` tinyint(4) NOT NULL,
	`do_return` tinyint(4) NOT NULL,
	`status_confirm` tinyint(4) NOT NULL,
	`confirm_date` datetime DEFAULT NULL,
	`confirm_by` varchar(50) DEFAULT NULL,
	`lead_time` int(11) NOT NULL,
	`kode_cabang` varchar(2) DEFAULT NULL,
	`region` varchar(100) DEFAULT NULL,
	`actual_time_arrival` datetime DEFAULT NULL,
	`actual_unloading_date` datetime DEFAULT NULL,
	`doc_do_return_date` datetime DEFAULT NULL,
	`delivery_items` int(11) DEFAULT NULL,
	`do_reject` tinyint(4) NOT NULL
);
INSERT INTO wms_branch_manifest_detail
SELECT ar.*
FROM ar_branch_manifest_detail ar
JOIN wms_branch_manifest_header h on h.do_manifest_no = ar.do_manifest_no;
DELETE ar FROM ar_branch_manifest_detail ar
INNER JOIN wms_branch_manifest_detail log ON log.id = ar.id;


/** wms_lmb_header **/
ALTER Table wms_lmb_header RENAME TO ar_lmb_header;
CREATE TABLE `wms_lmb_header` (
	`driver_register_id` varchar(50) NOT NULL PRIMARY KEY,
	`lmb_date` date NOT NULL,
	`do_reservation_no` varchar(20) NOT NULL,
	`pdo` varchar(50) DEFAULT NULL,
	`expedition_code` varchar(3) DEFAULT NULL,
	`expedition_name` varchar(100) DEFAULT NULL,
	`driver_id` varchar(10) DEFAULT NULL,
	`driver_name` varchar(100) DEFAULT NULL,
	`vehicle_number` varchar(11) DEFAULT NULL,
	`destination_number` varchar(6) DEFAULT NULL,
	`destination_name` varchar(100) DEFAULT NULL,
	`kode_cabang` varchar(2) DEFAULT NULL,
	`short_description_cabang` varchar(3) DEFAULT NULL,
	`seal_no` varchar(20) DEFAULT NULL,
	`container_no` varchar(20) DEFAULT NULL,
	`send_manifest` tinyint(4) NOT NULL,
	`manifest_complete` tinyint(3) unsigned DEFAULT NULL,
	`start_date` datetime DEFAULT NULL,
	`finish_date` datetime DEFAULT NULL,
	`finish_by` varchar(50) DEFAULT NULL,
	`created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
	`created_by` int(11) DEFAULT NULL,
	`updated_by` int(11) DEFAULT NULL
);
INSERT INTO wms_lmb_header
SELECT lmb.*
FROM ar_lmb_header lmb
LEFT JOIN ar_manifest_header mn ON mn.driver_register_id = lmb.driver_register_id
LEFT JOIN ar_branch_manifest_header br_mn ON br_mn.driver_register_id = lmb.driver_register_id
WHERE ((mn.do_manifest_no IS NULL) AND (br_mn.do_manifest_no IS NULL));
DELETE ar FROM ar_lmb_header ar
INNER JOIN wms_lmb_header wms ON wms.driver_register_id = ar.driver_register_id;

/** wms_lmb_detail **/
ALTER TABLE wms_lmb_detail RENAME TO ar_lmb_detail;
CREATE TABLE `wms_lmb_detail` (
	`serial_number` varchar(50) NOT NULL,
	`delivery_no` varchar(20) NOT NULL,
	`model` varchar(50) NOT NULL,
	`delivery_items` int(11) NOT NULL,
	`invoice_no` varchar(10) DEFAULT NULL,
	`ean_code` varchar(50) DEFAULT NULL,
	`cbm_unit` decimal(18,3) DEFAULT NULL,
	`driver_register_id` varchar(50) DEFAULT NULL,
	`picking_id` varchar(20) DEFAULT NULL,
	`picking_detail_id` varchar(20) DEFAULT NULL,
	`city_code` varchar(10) DEFAULT NULL,
	`city_name` varchar(100) DEFAULT NULL,
	`kode_customer` varchar(8) DEFAULT NULL,
	`code_sales` varchar(2) DEFAULT NULL,
	`no_manifest` tinyint(1) DEFAULT NULL,
	`created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
	`created_by` int(11) DEFAULT NULL,
	`updated_by` int(11) DEFAULT NULL,
	PRIMARY KEY (`serial_number`,`delivery_no`,`model`,`delivery_items`)
);
INSERT INTO wms_lmb_detail
SELECT dt.* FROM ar_lmb_detail dt
LEFT JOIN ar_lmb_header hd ON hd.driver_register_id = dt.driver_register_id
WHERE hd.driver_register_id IS NULL;
DELETE ar FROM ar_lmb_detail ar
INNER JOIN wms_lmb_detail wms ON wms.serial_number = ar.serial_number AND wms.delivery_no = ar.delivery_no AND wms.model = ar.model AND wms.delivery_items = ar.delivery_items;

/** wms_pickinglist_header **/
ALTER TABLE wms_pickinglist_header RENAME TO ar_pickinglist_header;
CREATE TABLE `wms_pickinglist_header` (
	`id` varchar(20) NOT NULL PRIMARY KEY,
	`picking_date` date DEFAULT NULL,
	`picking_no` varchar(50) DEFAULT NULL,
	`driver_register_id` varchar(50) DEFAULT NULL,
	`driver_id` varchar(10) DEFAULT NULL,
	`driver_name` varchar(100) DEFAULT NULL,
	`vehicle_number` varchar(11) DEFAULT NULL,
	`expedition_code` varchar(3) DEFAULT NULL,
	`expedition_name` varchar(100) DEFAULT NULL,
	`area` varchar(20) DEFAULT NULL,
	`gate_number` int(11) DEFAULT NULL,
	`pdo` varchar(50) DEFAULT NULL,
	`destination_number` varchar(6) DEFAULT NULL,
	`destination_name` varchar(100) DEFAULT NULL,
	`picking_urut_no` int(11) DEFAULT NULL,
	`HQ` tinyint(4) NOT NULL,
	`kode_cabang` varchar(8) DEFAULT NULL,
	`vehicle_code_type` varchar(6) DEFAULT NULL,
	`city_code` varchar(10) DEFAULT NULL,
	`city_name` varchar(100) DEFAULT NULL,
	`storage_id` int(11) DEFAULT NULL,
	`storage_type` varchar(100) DEFAULT NULL,
	`start_date` datetime DEFAULT NULL,
	`start_by` varchar(50) DEFAULT NULL,
	`finish_date` datetime DEFAULT NULL,
	`finish_by` varchar(50) DEFAULT NULL,
	`assign_driver_date` datetime DEFAULT NULL,
	`assign_driver_by` varchar(50) DEFAULT NULL,
	`start_picking_date` datetime DEFAULT NULL,
	`detail_count` int(11) DEFAULT NULL,
	`lmb_detail_count` int(11) DEFAULT NULL,
	`created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
	`created_by` int(11) DEFAULT NULL,
	`updated_by` int(11) DEFAULT NULL,
	`deleted_at` datetime DEFAULT NULL,
	`deleted_by` int(11) DEFAULT NULL
);
INSERT INTO wms_pickinglist_header
SELECT p.* FROM ar_pickinglist_header p
LEFT JOIN ar_lmb_header l ON l.driver_register_id = p.driver_register_id
WHERE l.driver_register_id IS NULL;
DELETE ar FROM ar_pickinglist_header ar
INNER JOIN wms_pickinglist_header wms on wms.driver_register_id = ar.driver_register_id;

/** wms_pickinglist_detail **/
ALTER TABLE wms_pickinglist_detail RENAME TO ar_pickinglist_detail;
CREATE TABLE `wms_pickinglist_detail` (
	`id` varchar(20) NOT NULL PRIMARY KEY,
	`header_id` varchar(20) DEFAULT NULL,
	`tr_concept_id` varchar(60) DEFAULT NULL,
	`invoice_no` varchar(20) DEFAULT NULL,
	`line_no` int(11) DEFAULT NULL,
	`delivery_no` varchar(20) DEFAULT NULL,
	`delivery_items` int(11) DEFAULT NULL,
	`model` varchar(50) DEFAULT NULL,
	`quantity` int(11) DEFAULT NULL,
	`cbm` decimal(18,3) DEFAULT NULL,
	`ean_code` varchar(50) DEFAULT NULL,
	`code_sales` varchar(2) DEFAULT NULL,
	`remarks` varchar(200) DEFAULT NULL,
	`kode_customer` varchar(8) DEFAULT NULL,
	`created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
	`created_by` int(11) DEFAULT NULL,
	`updated_by` int(11) DEFAULT NULL
);
INSERT INTO wms_pickinglist_detail
SELECT dt.* FROM ar_pickinglist_detail dt
LEFT JOIN ar_pickinglist_header h ON h.id = dt.header_id
WHERE h.id IS NULL;
DELETE ar FROM ar_pickinglist_detail ar
INNER JOIN wms_pickinglist_detail p ON p.id = ar.id;

/** tr_concept **/
ALTER TABLE tr_concept RENAME TO ar_concept;
CREATE TABLE `tr_concept` (
	`id` varchar(60) NOT NULL PRIMARY KEY,
	`invoice_no` varchar(10) NOT NULL,
	`line_no` int(11) NOT NULL,
	`output_date` varchar(8) DEFAULT NULL,
	`output_time` varchar(6) DEFAULT NULL,
	`destination_number` varchar(6) DEFAULT NULL,
	`vehicle_code_type` varchar(6) DEFAULT NULL,
	`car_no` varchar(50) DEFAULT NULL,
	`cont_no` varchar(50) DEFAULT NULL,
	`checkin_date` varchar(8) DEFAULT NULL,
	`checkin_time` varchar(6) DEFAULT NULL,
	`expedition_id` int(11) DEFAULT NULL,
	`delivery_no` varchar(20) NOT NULL,
	`delivery_items` int(11) NOT NULL,
	`model` varchar(50) NOT NULL,
	`quantity` int(11) NOT NULL,
	`cbm` decimal(18,3) NOT NULL,
	`ship_to` varchar(100) DEFAULT NULL,
	`sold_to` varchar(100) DEFAULT NULL,
	`ship_to_city` varchar(100) DEFAULT NULL,
	`ship_to_district` varchar(100) DEFAULT NULL,
	`ship_to_street` varchar(200) DEFAULT NULL,
	`sold_to_city` varchar(100) DEFAULT NULL,
	`sold_to_district` varchar(100) DEFAULT NULL,
	`sold_to_street` varchar(200) DEFAULT NULL,
	`remarks` varchar(200) DEFAULT NULL,
	`split_date` datetime DEFAULT NULL,
	`split_by` varchar(50) DEFAULT NULL,
	`area` varchar(20) DEFAULT NULL,
	`concept_type` varchar(50) DEFAULT NULL,
	`expedition_name` varchar(100) DEFAULT NULL,
	`sold_to_code` varchar(10) DEFAULT NULL,
	`ship_to_code` varchar(10) DEFAULT NULL,
	`expedition_code` varchar(6) DEFAULT NULL,
	`code_sales` varchar(2) DEFAULT NULL,
	`created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
	`created_by` int(11) DEFAULT NULL,
	`updated_by` int(11) DEFAULT NULL
);
INSERT INTO tr_concept
SELECT c.* FROM ar_concept c
LEFT JOIN ar_pickinglist_detail pd ON pd.tr_concept_id = c.id
WHERE pd.id IS NULL;
DELETE ar FROM ar_concept ar
INNER JOIN tr_concept c ON c.id = ar.id;

/** wms_manual_concept **/
ALTER TABLE wms_manual_concept RENAME TO ar_manual_concept;
CREATE TABLE `wms_manual_concept` (
	`invoice_no` varchar(10) NOT NULL,
	`delivery_no` varchar(20) NOT NULL,
	`delivery_items` int(11) NOT NULL,
	`do_date` varchar(12) DEFAULT NULL,
	`kode_customer` varchar(8) DEFAULT NULL,
	`long_description_customer` varchar(100) DEFAULT NULL,
	`model` varchar(50) NOT NULL,
	`ean_code` varchar(50) DEFAULT NULL,
	`quantity` int(11) NOT NULL,
	`cbm` decimal(18,3) NOT NULL,
	`code_sales` varchar(2) DEFAULT NULL,
	`area` varchar(20) DEFAULT NULL,
	`kode_cabang` varchar(2) DEFAULT NULL,
	`split_date` datetime(2) DEFAULT NULL,
	`split_by` int(11) DEFAULT NULL,
	`remarks` varchar(200) NOT NULL,
	`created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
	`created_by` int(11) DEFAULT NULL,
	`updated_by` int(11) DEFAULT NULL,
	PRIMARY KEY (`invoice_no`,`delivery_no`,`delivery_items`)
)
INSERT INTO wms_manual_concept
SELECT c.* FROM ar_manual_concept
LEFT JOIN ar_pickinglist_detail pd ON pd.invoice_no = c.invoice_no AND pd.delivery_no = c.delivery_no AND pd.delivery_items = c.delivery_items
WHERE pd.id IS NULL;
DELETE ar FROM ar_manual_concept
INNER JOIN wms_manual_concept c ON c.invoice_no = ar.invoice_no AND c.delivery_no = ar.delivery_no AND c.delivery_items = ar.delivery_items;




/** Update manifest_header After Insert Trigger **/
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

/** Update manifest_header AFTER DELETE TRIGGER **/
DELIMITER $$
CREATE TRIGGER manifest_header_delete
AFTER DELETE ON log_manifest_header FOR EACH ROW
BEGIN
	IF OLD.r_driver_register_id IS NOT NULL THEN
		IF (SELECT COUNT(h.do_manifest_no)
		FROM log_manifest_header h
		WHERE h.r_driver_register_id = OLD.r_driver_register_id) < 1 THEN
			UPDATE tr_driver_registered
			SET has_manifest = NULL,
				has_manifest_complete = NULL
			WHERE tr_driver_registered.id = OLD.r_driver_register_id;
		END IF;
	END IF;
END$$
DELIMITER ;

/** Update branch_manifest_header After Insert Trigger **/
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

/** Update pickinglist_header after insert trigger **/
DELIMITER $$
CREATE TRIGGER pickinglist_header_insert
AFTER INSERT ON wms_pickinglist_header FOR EACH ROW
BEGIN
	IF NEW.driver_register_id IS NOT NULL THEN
		UPDATE tr_driver_registered
		SET has_pickinglist = true
		WHERE tr_driver_registered.id = NEW.driver_register_id;
	END IF;
END$$
DELIMITER ;

/** Update pickinglist_header after update trigger **/
DELIMITER $$
CREATE TRIGGER pickinglist_header_update
AFTER UPDATE ON wms_pickinglist_header FOR EACH ROW
BEGIN
	IF OLD.driver_register_id IS NOT NULL 
	AND NEW.driver_register_id <> OLD.driver_register_id THEN
		IF (SELECT COUNT(h.id) 
		FROM wms_pickinglist_header h 
		WHERE h.driver_register_id = OLD.driver_register_id) < 1 THEN
			UPDATE tr_driver_registered
			SET has_pickinglist = NULL
			WHERE tr_driver_registered.id = OLD.driver_register_id;
		END IF;
	END IF;
	IF NEW.driver_register_id IS NOT NULL THEN
		UPDATE tr_driver_registered
		SET has_pickinglist = true
		WHERE tr_driver_registered.id = NEW.driver_register_id;
	END IF;
END$$
DELIMITER ;

/** Update pickinglist_header after delete trigger **/
DELIMITER $$
CREATE TRIGGER pickinglist_header_delete
AFTER DELETE ON wms_pickinglist_header FOR EACH ROW
BEGIN
	IF OLD.driver_register_id IS NOT NULL THEN
		IF (SELECT COUNT(h.id)
		FROM wms_pickinglist_header h
		WHERE h.driver_register_id = OLD.driver_register_id) < 1 THEN
			UPDATE tr_driver_registered
			SET has_pickinglist = NULL
			WHERE tr_driver_registered.id = OLD.driver_register_id;
		END IF;
	END IF;
END$$
DELIMITER ;