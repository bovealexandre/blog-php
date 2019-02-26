
-- Adminer 4.7.1 PostgreSQL dump

DROP TABLE IF EXISTS "articles";
CREATE TABLE "public"."articles" (
    "ID" integer NOT NULL,
    "writer" integer NOT NULL,
    "text" text NOT NULL,
    "publishdate" timestamp NOT NULL,
    "category" integer NOT NULL,
    "image" character varying NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "categories";
DROP SEQUENCE IF EXISTS "categories_ID_seq";
CREATE SEQUENCE "categories_ID_seq" INCREMENT  MINVALUE  MAXVALUE  START 1 CACHE ;

CREATE TABLE "public"."categories" (
    "ID" integer DEFAULT nextval('"categories_ID_seq"') NOT NULL,
    "name" character varying NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "commentaries";
DROP SEQUENCE IF EXISTS "Commentaries_ID_seq";
CREATE SEQUENCE "Commentaries_ID_seq" INCREMENT  MINVALUE  MAXVALUE  START 1 CACHE ;

CREATE TABLE "public"."commentaries" (
    "ID" integer DEFAULT nextval('"Commentaries_ID_seq"') NOT NULL,
    "writer" character varying(255) NOT NULL,
    "comment" text NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "users";
DROP SEQUENCE IF EXISTS "users_ID_seq";
CREATE SEQUENCE "users_ID_seq" INCREMENT  MINVALUE  MAXVALUE  START 1 CACHE ;

CREATE TABLE "public"."users" (
    "ID" integer DEFAULT nextval('"users_ID_seq"') NOT NULL,
    "pseudo" character varying(255) NOT NULL,
    "password" character varying(255) NOT NULL,
    "autorisation" integer NOT NULL
) WITH (oids = false);


-- 2019-02-26 08:13:51.212099+00