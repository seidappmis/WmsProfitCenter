ALTER table wms_manual_concept
add column id VARCHAR(60) first;

UPDATE wms_manual_concept
SET id = CONCAT(invoice_no, '--', delivery_no, '-', delivery_items);

ALTER table tr_concept
drop primary key,
add primary key(id);