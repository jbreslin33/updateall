--
-- PostgreSQL database dump
--

DROP TABLE counting cascade;
DROP TABLE addition cascade;
DROP TABLE subtraction cascade;
DROP TABLE math_games cascade;
DROP TABLE english_games cascade;
DROP TABLE subjects cascade;
DROP TABLE grade_levels cascade;
DROP TABLE home_rooms_users cascade;
DROP TABLE home_rooms cascade;
DROP TABLE users cascade;
DROP TABLE math_levels cascade;
DROP TABLE english_levels cascade;
DROP TABLE roles cascade;
DROP TABLE passwords cascade;

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;


--------------------passwords---------------------------------------
CREATE TABLE passwords (
    password text  
);

--------------------roles---------------------------------------
CREATE TABLE roles (
    role text 
);

--------------------grade_level---------------------------------------
CREATE TABLE grade_levels (
    grade_level text 
);

--------------------math_levels---------------------------------------
CREATE TABLE math_levels (
    level integer NOT NULL,
    next_level integer NOT NULL,
    skill text NOT NULL
);

--------------------english_levels---------------------------------------
CREATE TABLE english_levels (
    level integer NOT NULL,
    next_level integer NOT NULL,
    skill text NOT NULL
);

--------------------subjects---------------------------------------
CREATE TABLE subjects (
    subject text NOT NULL UNIQUE,
    url text NOT NULL UNIQUE
);

--------------------math_games---------------------------------------
CREATE TABLE math_games (
    level integer NOT NULL,
    url text NOT NULL,
    name text NOT NULL
);

--------------------english_games---------------------------------------
CREATE TABLE english_games (
    level integer NOT NULL,
    url text NOT NULL,
    name text NOT NULL
);

--------------------counting---------------------------------------
CREATE TABLE counting (
    level integer NOT NULL,
    score_needed integer DEFAULT 10 NOT NULL,
    start_number integer NOT NULL,
    end_number integer NOT NULL,
    count_by integer DEFAULT 1 NOT NULL
);

--------------------addition---------------------------------------
CREATE TABLE addition (
    level integer NOT NULL,
    score_needed integer DEFAULT 10 NOT NULL,
    addend_min integer NOT NULL,
    addend_max integer NOT NULL,
    number_of_addends integer DEFAULT 2 NOT NULL
);

--------------------subtraction---------------------------------------
CREATE TABLE subtraction (
    level integer NOT NULL,
    score_needed integer DEFAULT 10 NOT NULL,
    minuend_min integer NOT NULL,
    minuend_max integer NOT NULL,
    subtrahend_min integer NOT NULL,
    subtrahend_max integer NOT NULL,
    number_of_subtrahends integer DEFAULT 1 NOT NULL,
    negative_difference boolean DEFAULT false NOT NULL
);

--------------------users---------------------------------------
CREATE TABLE users (
    username text, 
    password text NOT NULL,

    first_name text,
    last_name text,

    math_level integer DEFAULT 1 NOT NULL,
    english_level integer DEFAULT 1 NOT NULL,

    role text NOT NULL,

    admin text NOT NULL,
    teacher text NOT NULL 
);

--------------------home_rooms---------------------------------------
CREATE TABLE home_rooms (
    admin text NOT NULL,
    description text NOT NULL,
    teacher text NOT NULL
);

--------------------home_rooms_users---------------------------------------
CREATE TABLE home_rooms_users (
    admin text,
    description text,
    student text
);

----------------------CREATE SEQUENCES-------------------------
-- for better or for worse i got rid of all sequences and i am using natural pks

--------------------ALTER---------------------------------------
--PASSWORDS
ALTER TABLE public.passwords OWNER TO postgres;
ALTER TABLE passwords ADD PRIMARY KEY (password);

--ROLES
ALTER TABLE public.roles OWNER TO postgres;
ALTER TABLE roles ADD PRIMARY KEY (role);

--GRADE_LEVELS
ALTER TABLE public.grade_levels OWNER TO postgres;
ALTER TABLE grade_levels ADD PRIMARY KEY (grade_level);

--MATH_LEVELS
ALTER TABLE public.math_levels OWNER TO postgres;
ALTER TABLE math_levels ADD PRIMARY KEY (level);

--ENGLISH_LEVELS
ALTER TABLE public.english_levels OWNER TO postgres;
ALTER TABLE english_levels ADD PRIMARY KEY (level);

--SUBJECTS
ALTER TABLE public.subjects OWNER TO postgres;
ALTER TABLE subjects ADD PRIMARY KEY (subject);

--MATH_GAMES
ALTER TABLE public.math_games OWNER TO postgres;
ALTER TABLE math_games ADD PRIMARY KEY (level,url);
ALTER TABLE math_games ADD FOREIGN KEY (level) REFERENCES math_levels(level);

--ENGLISH_GAMES
ALTER TABLE public.english_games OWNER TO postgres;
ALTER TABLE english_games ADD PRIMARY KEY (level,url);
ALTER TABLE english_games ADD FOREIGN KEY (level) REFERENCES english_levels(level);

--COUNTING
ALTER TABLE public.counting OWNER TO postgres;
ALTER TABLE counting ADD PRIMARY KEY (level);

--ADDITION
ALTER TABLE public.addition OWNER TO postgres;
ALTER TABLE addition ADD PRIMARY KEY (level);

--SUBTRACTION
ALTER TABLE public.subtraction OWNER TO postgres;
ALTER TABLE subtraction ADD PRIMARY KEY (level);

--USERS
ALTER TABLE public.users OWNER TO postgres;
ALTER TABLE users ADD PRIMARY KEY (username);
ALTER TABLE users ADD FOREIGN KEY (math_level) REFERENCES math_levels(level);
ALTER TABLE users ADD FOREIGN KEY (english_level) REFERENCES english_levels(level);
ALTER TABLE users ADD FOREIGN KEY (role) REFERENCES roles(role);
ALTER TABLE users ADD FOREIGN KEY (admin) REFERENCES users(username);
ALTER TABLE users ADD FOREIGN KEY (teacher) REFERENCES users(username);

--HOME_ROOMS
ALTER TABLE public.home_rooms OWNER TO postgres;
ALTER TABLE home_rooms ADD PRIMARY KEY (admin,description);
ALTER TABLE home_rooms ADD FOREIGN KEY (admin) REFERENCES users(username);
ALTER TABLE home_rooms ADD FOREIGN KEY (teacher) REFERENCES users(username);

--HOME_ROOMS_USERS
ALTER TABLE public.home_rooms_users OWNER TO postgres;
ALTER TABLE home_rooms_users ADD PRIMARY KEY (admin,description,student);
ALTER TABLE home_rooms_users ADD FOREIGN KEY (admin,description) REFERENCES home_rooms(admin,description);
ALTER TABLE home_rooms_users ADD FOREIGN KEY (admin) REFERENCES users(username);
ALTER TABLE home_rooms_users ADD FOREIGN KEY (student) REFERENCES users(username);

--------------------INSERT---------------------------------------
--PASSWORDS
insert into passwords (password) values ('apple'); 
insert into passwords (password) values ('ant'); 
insert into passwords (password) values ('ape'); 
insert into passwords (password) values ('art'); 
insert into passwords (password) values ('at'); 
insert into passwords (password) values ('as'); 
insert into passwords (password) values ('and'); 
insert into passwords (password) values ('aim'); 
insert into passwords (password) values ('bat'); 
insert into passwords (password) values ('be'); 
insert into passwords (password) values ('bee'); 
insert into passwords (password) values ('been'); 
insert into passwords (password) values ('beet'); 
insert into passwords (password) values ('but'); 
insert into passwords (password) values ('bird'); 
insert into passwords (password) values ('cat'); 
insert into passwords (password) values ('can'); 
insert into passwords (password) values ('cent'); 
insert into passwords (password) values ('cry'); 
insert into passwords (password) values ('dog'); 
insert into passwords (password) values ('do'); 
insert into passwords (password) values ('dip'); 
insert into passwords (password) values ('duck'); 
insert into passwords (password) values ('eat'); 
insert into passwords (password) values ('far'); 
insert into passwords (password) values ('feet'); 
insert into passwords (password) values ('fly'); 
insert into passwords (password) values ('go'); 
insert into passwords (password) values ('get'); 
insert into passwords (password) values ('gone'); 
insert into passwords (password) values ('he'); 
insert into passwords (password) values ('here'); 
insert into passwords (password) values ('hen'); 
insert into passwords (password) values ('hat'); 
insert into passwords (password) values ('help'); 
insert into passwords (password) values ('hit'); 
insert into passwords (password) values ('i'); 
insert into passwords (password) values ('it'); 
insert into passwords (password) values ('jump'); 
insert into passwords (password) values ('lip'); 
insert into passwords (password) values ('low'); 
insert into passwords (password) values ('mom'); 
insert into passwords (password) values ('mat'); 
insert into passwords (password) values ('no'); 
insert into passwords (password) values ('not'); 
insert into passwords (password) values ('oh'); 
insert into passwords (password) values ('pen'); 
insert into passwords (password) values ('pat'); 
insert into passwords (password) values ('pick'); 
insert into passwords (password) values ('park'); 
insert into passwords (password) values ('run'); 
insert into passwords (password) values ('rat'); 
insert into passwords (password) values ('rip'); 
insert into passwords (password) values ('sat'); 
insert into passwords (password) values ('see'); 
insert into passwords (password) values ('sip'); 
insert into passwords (password) values ('sun'); 
insert into passwords (password) values ('sit'); 
insert into passwords (password) values ('tip'); 
insert into passwords (password) values ('top'); 
insert into passwords (password) values ('turn'); 
insert into passwords (password) values ('van'); 
insert into passwords (password) values ('want'); 
insert into passwords (password) values ('you'); 
insert into passwords (password) values ('yoyo'); 
insert into passwords (password) values ('zip'); 

--ROLES
insert into roles (role) values ('Admin'); 
insert into roles (role) values ('Teacher'); 
insert into roles (role) values ('Student'); 
insert into roles (role) values ('Guest'); 

--GRADE_LEVEL
insert into grade_levels (grade_level) values ('PK3');
insert into grade_levels (grade_level) values ('PK4');
insert into grade_levels (grade_level) values ('K');
insert into grade_levels (grade_level) values ('1');
insert into grade_levels (grade_level) values ('2');
insert into grade_levels (grade_level) values ('3');
insert into grade_levels (grade_level) values ('4');
insert into grade_levels (grade_level) values ('5');

--SUBJECTS
insert into subjects (subject,url) values ('Math','../math/chooser.php');
insert into subjects (subject,url) values ('English','../english/chooser.php');

--math_levels
insert into math_levels(level,next_level,skill) values (1,2,'Count from 0 to 10');       
insert into math_levels(level,next_level,skill) values (2,3,'Count from 10 to 20');       
insert into math_levels(level,next_level,skill) values (3,4,'Count from 20 to 30');       
insert into math_levels(level,next_level,skill) values (4,5,'Count from 30 to 40');       
insert into math_levels(level,next_level,skill) values (5,6,'Count from 40 to 50');       
insert into math_levels(level,next_level,skill) values (6,7,'Count from 50 to 60');       
insert into math_levels(level,next_level,skill) values (7,8,'Count from 60 to 70');       
insert into math_levels(level,next_level,skill) values (8,9,'Count from 70 to 80');       
insert into math_levels(level,next_level,skill) values (9,10,'Count from 80 to 90');       
insert into math_levels(level,next_level,skill) values (10,11,'Count from 90 to 100');       

--english_levels
insert into english_levels(level,next_level,skill) values (1,2,'Recognize and A');       

--MATH_GAMES
insert into math_games (level,name,url) values (1,'Dungeon Count','../../template/math/count/count.php');
insert into math_games (level,name,url) values (1,'Racing Count','../../template/math/count/racing.php');
insert into math_games (level,name,url) values (2,'Count','../../template/math/count/count.php');
insert into math_games (level,name,url) values (3,'Count','../../template/math/count/count.php');
insert into math_games (level,name,url) values (4,'Count','../../template/math/count/count.php');
insert into math_games (level,name,url) values (5,'Count','../../template/math/count/count.php');
insert into math_games (level,name,url) values (6,'Count','../../template/math/count/count.php');
insert into math_games (level,name,url) values (7,'Count','../../template/math/count/count.php');
insert into math_games (level,name,url) values (8,'Count','../../template/math/count/count.php');
insert into math_games (level,name,url) values (9,'Count','../../template/math/count/count.php');
insert into math_games (level,name,url) values (10,'Count','../../template/math/count/count.php');

--COUNTING
insert into counting (level,score_needed,start_number,end_number,count_by) values (1,10,0,10,1);
insert into counting (level,score_needed,start_number,end_number,count_by) values (2,10,10,20,1);
insert into counting (level,score_needed,start_number,end_number,count_by) values (3,10,20,30,1);
insert into counting (level,score_needed,start_number,end_number,count_by) values (4,10,30,40,1);
insert into counting (level,score_needed,start_number,end_number,count_by) values (5,10,40,50,1);
insert into counting (level,score_needed,start_number,end_number,count_by) values (6,10,50,60,1);
insert into counting (level,score_needed,start_number,end_number,count_by) values (7,10,60,70,1);
insert into counting (level,score_needed,start_number,end_number,count_by) values (8,10,70,80,1);
insert into counting (level,score_needed,start_number,end_number,count_by) values (9,10,80,90,1);
insert into counting (level,score_needed,start_number,end_number,count_by) values (10,10,90,100,1);

--USERS
--admin=1,teacher=2,student=3,guest=4
--create admin anselm 
insert into users (username,password,first_name,last_name,role,admin,teacher) values ('anselm','p','Father','Foley','Admin','anselm','anselm'); 
--create admin vis 
insert into users (username,password,first_name,last_name,role,admin,teacher) values ('vis','p','Dolores','Egner','Admin','vis','vis'); 

--create teachers anselm 
insert into users (username,password,first_name,last_name,role,admin,teacher) values ('kmary.anselm','p','Sally','Berg','Teacher','anselm','anselm'); 
--create teachers vis 
insert into users (username,password,first_name,last_name,role,admin,teacher) values ('jroache.vis','p','James','Roache','Teacher','vis','vis'); 

--create students anselm 
insert into users (username,password,first_name,last_name,role,admin,teacher) values ('1.anselm','p','Willard','Lackman','Student','anselm','anselm'); 
--create students vis 
insert into users (username,password,first_name,last_name,role,admin,teacher) values ('1.vis','p','Luke','Breslin','Student','vis','vis'); 

--create guest
insert into users (username,password,role,admin,teacher) values ('guest','p','Guest','guest','guest'); 

--------------------REVOKE AND GRANT---------------------------------------
REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;

--
-- PostgreSQL database dump complete
--

