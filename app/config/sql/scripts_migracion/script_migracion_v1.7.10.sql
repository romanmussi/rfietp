UPDATE claseinstits SET name='Superior Técnico' WHERE id=4;
UPDATE claseinstits SET name='Secundario Técnico' WHERE id=3;
INSERT INTO claseinstits (name) VALUES ('Secundario No Técnico');
INSERT INTO claseinstits (name) VALUES ('Superior No Técnico');

/* las instituciones que son con programa ETP y Secundario Tec pasan a ser No Tec, idem con Superior */
UPDATE instits SET claseinstit_id=5 WHERE etp_estado_id=1 AND claseinstit_id=3;
UPDATE instits SET claseinstit_id=6 WHERE etp_estado_id=1 AND claseinstit_id=4;