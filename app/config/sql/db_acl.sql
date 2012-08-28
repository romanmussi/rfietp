# $Id: db_acl.sql 7945 2008-12-19 02:16:01Z gwoo $
#
# Copyright 2005-2008,	Cake Software Foundation, Inc.
#
# Licensed under The MIT License
# Redistributions of files must retain the above copyright notice.
# http://www.opensource.org/licenses/mit-license.php The MIT License

/* postgres */
CREATE TABLE aros
(
  id serial NOT NULL,
  parent_id integer,
  model character varying(255) DEFAULT ''::character varying,
  foreign_key integer,
  alias character varying(255) DEFAULT ''::character varying,
  lft integer,
  rght integer,
  CONSTRAINT aros_pkey PRIMARY KEY (id)
);

CREATE TABLE acos
(
  id serial NOT NULL,
  parent_id integer,
  model character varying(255) DEFAULT ''::character varying,
  foreign_key integer,
  alias character varying(255) DEFAULT ''::character varying,
  lft integer,
  rght integer,
  CONSTRAINT acos_pkey PRIMARY KEY (id)
);

CREATE TABLE aros_acos
(
  id serial NOT NULL,
  aro_id integer NOT NULL,
  aco_id integer NOT NULL,
  _create character(2) NOT NULL DEFAULT 0,
  _read character(2) NOT NULL DEFAULT 0,
  _update character(2) NOT NULL DEFAULT 0,
  _delete character(2) NOT NULL DEFAULT 0,
  CONSTRAINT aros_acos_pkey PRIMARY KEY (id)
);

/* mysql */

CREATE TABLE acos (
  id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  parent_id INTEGER(10) DEFAULT NULL,
  model VARCHAR(255) DEFAULT '',
  foreign_key INTEGER(10) UNSIGNED DEFAULT NULL,
  alias VARCHAR(255) DEFAULT '',
  lft INTEGER(10) DEFAULT NULL,
  rght INTEGER(10) DEFAULT NULL,
  PRIMARY KEY  (id)
);

CREATE TABLE aros_acos (
  id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  aro_id INTEGER(10) UNSIGNED NOT NULL,
  aco_id INTEGER(10) UNSIGNED NOT NULL,
  _create CHAR(2) NOT NULL DEFAULT 0,
  _read CHAR(2) NOT NULL DEFAULT 0,
  _update CHAR(2) NOT NULL DEFAULT 0,
  _delete CHAR(2) NOT NULL DEFAULT 0,
  PRIMARY KEY(id)
);

CREATE TABLE aros (
  id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  parent_id INTEGER(10) DEFAULT NULL,
  model VARCHAR(255) DEFAULT '',
  foreign_key INTEGER(10) UNSIGNED DEFAULT NULL,
  alias VARCHAR(255) DEFAULT '',
  lft INTEGER(10) DEFAULT NULL,
  rght INTEGER(10) DEFAULT NULL,
  PRIMARY KEY  (id)
);
