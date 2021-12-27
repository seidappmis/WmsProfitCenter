ALTER table wms_manual_concept
add column id VARCHAR(60) first;

UPDATE wms_manual_concept
SET id = CONCAT(invoice_no, '-0-', delivery_no, '-', delivery_items);

ALTER table wms_manual_concept
drop primary key,
add primary key(id);