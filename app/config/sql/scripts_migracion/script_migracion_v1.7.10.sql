UPDATE claseinstits SET name='Superior T�cnico' WHERE id=4;
UPDATE claseinstits SET name='Secundario T�cnico' WHERE id=3;
INSERT INTO claseinstits (name) VALUES ('Secundario No T�cnico');
INSERT INTO claseinstits (name) VALUES ('Superior No T�cnico');

/* las instituciones que son con programa ETP y Secundario Tec pasan a ser No Tec, idem con Superior */
UPDATE instits SET claseinstit_id=5 WHERE etp_estado_id=1 AND claseinstit_id=3;
UPDATE instits SET claseinstit_id=6 WHERE etp_estado_id=1 AND claseinstit_id=4;