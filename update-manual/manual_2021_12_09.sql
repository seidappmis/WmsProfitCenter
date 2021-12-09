ALTER table tr_concept
add column id varchar(60) first;

UPDATE tr_concept
SET id = CONCAT(invoice_no, '-', line_no, '-', delivery_no, '-', delivery_items);

ALTER table tr_concept
drop primary key,
add primary key(id);

ALTER table wms_pickinglist_detail
ADD COLUMN tr_concept_id VARCHAR(60) after header_id;

UPDATE wms_pickinglist_detail
SET tr_concept_id = CONCAT(invoice_no, '-', line_no, '-', delivery_no, '-', delivery_items);

ALTER table log_manifest_detail
ADD COLUMN tr_concept_id VARCHAR(60) after do_manifest_no;

UPDATE log_manifest_detail
SET tr_concept_id = CONCAT(invoice_no, '-', line_no, '-', delivery_no, '-', delivery_items);

ALTER table wms_pickinglist_header
ADD COLUMN detail_count INT after start_picking_date,
ADD COLUMN lmb_detail_count INT after detail_count;