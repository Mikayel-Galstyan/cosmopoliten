ALTER TABLE objects ADD active int(1) default 1;
ALTER TABLE objectsGroup ADD active int(1) default 1;
ALTER TABLE colors ADD active int(1) default 2;
ALTER TABLE shoplist ADD active int(1) default 1;
ALTER TABLE material ADD active int(1) default 2;
ALTER TABLE objecttype ADD active int(1) default 2;
ALTER TABLE shopgroup ADD active int(1) default 1;