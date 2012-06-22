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
--DROP TABLE homerooms cascade;
DROP TABLE schools cascade;
DROP TABLE admins cascade;
DROP TABLE students cascade;
DROP TABLE teachers cascade;
DROP TABLE users cascade;
DROP TABLE math_levels cascade;
DROP TABLE students_math_levels cascade;
DROP TABLE english_levels cascade;
DROP TABLE passwords cascade;
DROP TABLE error_log cascade; 

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


--------------------error_log---------------------------------------
CREATE TABLE error_log (
    id integer NOT NULL,
    error text,
    error_time timestamp,
    username text
);

--------------------passwords---------------------------------------
CREATE TABLE passwords (
    id integer NOT NULL,
    password text  
);

--------------------grade_levels---------------------------------------
CREATE TABLE grade_levels (
    id integer NOT NULL,
    grade_level text  
);

--------------------math_levels---------------------------------------
CREATE TABLE math_levels (
    id integer NOT NULL,
    level integer NOT NULL,
    next_level integer NOT NULL,
    skill text NOT NULL
);

--------------------english_levels---------------------------------------
CREATE TABLE english_levels (
    id integer NOT NULL,
    level integer NOT NULL,
    next_level integer NOT NULL,
    skill text NOT NULL
);

--------------------subjects---------------------------------------
CREATE TABLE subjects (
    id integer NOT NULL,
    subject text NOT NULL UNIQUE,
    url text NOT NULL UNIQUE
);

--------------------math_games---------------------------------------
CREATE TABLE math_games (
    id integer NOT NULL,
    level integer NOT NULL,
    url text NOT NULL,
    name text NOT NULL
);

--------------------english_games---------------------------------------
CREATE TABLE english_games (
    id integer NOT NULL,
    level integer NOT NULL,
    url text NOT NULL,
    name text NOT NULL
);

--------------------counting---------------------------------------
CREATE TABLE counting (
    id integer NOT NULL,
    level integer NOT NULL,
    score_needed integer DEFAULT 10 NOT NULL,
    start_number integer NOT NULL,
    end_number integer NOT NULL,
    count_by integer DEFAULT 1 NOT NULL
);

--------------------addition---------------------------------------
CREATE TABLE addition (
    id integer NOT NULL,
    level integer NOT NULL,
    score_needed integer DEFAULT 10 NOT NULL,
    addend_min integer NOT NULL,
    addend_max integer NOT NULL,
    number_of_addends integer DEFAULT 2 NOT NULL
);

--------------------subtraction---------------------------------------
CREATE TABLE subtraction (
    id integer NOT NULL,
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
    id integer NOT NULL,
    username text, 
    password text NOT NULL,

    first_name text,
    last_name text
);

--------------------schools---------------------------------------
CREATE TABLE schools (
    id integer NOT NULL,
    user_id integer
);

--------------------admins---------------------------------------
CREATE TABLE admins (
    id integer NOT NULL,
    user_id integer
);


--------------------students---------------------------------------
CREATE TABLE students (
    id integer NOT NULL,
    user_id integer, 

    math_level integer DEFAULT 1 NOT NULL,
    english_level integer DEFAULT 1 NOT NULL
);

-----------------------students_math_levels-------------------
CREATE TABLE students_math_levels (
    student_id integer,
    level_id integer NOT NULL
); 

--------------------teacher---------------------------------------
CREATE TABLE teachers (
    id integer NOT NULL,
    user_id integer  
);

--------------------homerooms---------------------------------------
/*
CREATE TABLE homerooms (
    id integer NOT NULL,
    admin text NOT NULL,
    homeroom text NOT NULL,
    teacher text NOT NULL
);
*/
----------------------CREATE SEQUENCES-------------------------
-- for better or for worse i got rid of all sequences and i am using natural pks except for HOME ROOMS
--ERROR_LOG
CREATE SEQUENCE error_log_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--PASSWORDS
CREATE SEQUENCE passwords_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--GRADE_LEVELS
CREATE SEQUENCE grade_levels_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--MATH_LEVELS
CREATE SEQUENCE math_levels_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--ENGLISH_LEVELS
CREATE SEQUENCE english_levels_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--SUBJECTS
CREATE SEQUENCE subjects_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--MATH_GAMES
CREATE SEQUENCE math_games_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--ENGLISH_GAMES
CREATE SEQUENCE english_games_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--COUNTING
CREATE SEQUENCE counting_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--ADDITION
CREATE SEQUENCE addition_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--SUBTRACTION
CREATE SEQUENCE subtraction_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--USERS
CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--SCHOOLS
CREATE SEQUENCE schools_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--ADMINS
CREATE SEQUENCE admins_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--STUDENTS
CREATE SEQUENCE students_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--TEACHERS
CREATE SEQUENCE teachers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--HOME_ROOMS
--CREATE SEQUENCE homerooms_id_seq
 --   START WITH 1
  --  INCREMENT BY 1
   -- NO MINVALUE
    --NO MAXVALUE
    --CACHE 1;


--------------------ALTER OWNER---------------------------------------
--PASSWORDS
ALTER TABLE public.passwords OWNER TO postgres;

--GRADE_LEVELS
ALTER TABLE public.grade_levels OWNER TO postgres;

--MATH_LEVELS
ALTER TABLE public.math_levels OWNER TO postgres;

--ENGLISH_LEVELS
ALTER TABLE public.english_levels OWNER TO postgres;

--SUBJECTS
ALTER TABLE public.subjects OWNER TO postgres;

--MATH_GAMES
ALTER TABLE public.math_games OWNER TO postgres;

--ENGLISH_GAMES
ALTER TABLE public.english_games OWNER TO postgres;

--COUNTING
ALTER TABLE public.counting OWNER TO postgres;

--ADDITION
ALTER TABLE public.addition OWNER TO postgres;

--SUBTRACTION
ALTER TABLE public.subtraction OWNER TO postgres;

--USERS
ALTER TABLE public.users OWNER TO postgres;

--SCHOOLS
ALTER TABLE public.schools OWNER TO postgres;

--ADMINS
ALTER TABLE public.admins OWNER TO postgres;

--STUDENTS
ALTER TABLE public.students OWNER TO postgres;

--TEACHERS
ALTER TABLE public.teachers OWNER TO postgres;

--HOME_ROOMS
--ALTER TABLE public.homerooms OWNER TO postgres;

--------------------ALTER SEQUENCE---------------------------------------
--ERROR_LOG
ALTER TABLE public.error_log_id_seq OWNER TO postgres;
ALTER SEQUENCE error_log_id_seq OWNED BY error_log.id;
ALTER TABLE ONLY error_log ALTER COLUMN id SET DEFAULT nextval('error_log_id_seq'::regclass);

--PASSWORDS
ALTER TABLE public.passwords_id_seq OWNER TO postgres;
ALTER SEQUENCE passwords_id_seq OWNED BY passwords.id;
ALTER TABLE ONLY passwords ALTER COLUMN id SET DEFAULT nextval('passwords_id_seq'::regclass);

--GRADE_LEVELS
ALTER TABLE public.grade_levels_id_seq OWNER TO postgres;
ALTER SEQUENCE grade_levels_id_seq OWNED BY grade_levels.id;
ALTER TABLE ONLY grade_levels ALTER COLUMN id SET DEFAULT nextval('grade_levels_id_seq'::regclass);

--MATH_LEVELS
ALTER TABLE public.math_levels_id_seq OWNER TO postgres;
ALTER SEQUENCE math_levels_id_seq OWNED BY math_levels.id;
ALTER TABLE ONLY math_levels ALTER COLUMN id SET DEFAULT nextval('math_levels_id_seq'::regclass);

--ENGLISH_LEVELS
ALTER TABLE public.english_levels_id_seq OWNER TO postgres;
ALTER SEQUENCE english_levels_id_seq OWNED BY english_levels.id;
ALTER TABLE ONLY english_levels ALTER COLUMN id SET DEFAULT nextval('english_levels_id_seq'::regclass);

--SUBJECTS
ALTER TABLE public.subjects_id_seq OWNER TO postgres;
ALTER SEQUENCE subjects_id_seq OWNED BY subjects.id;
ALTER TABLE ONLY subjects ALTER COLUMN id SET DEFAULT nextval('subjects_id_seq'::regclass);

--MATH_GAMES
ALTER TABLE public.math_games_id_seq OWNER TO postgres;
ALTER SEQUENCE math_games_id_seq OWNED BY math_games.id;
ALTER TABLE ONLY math_games ALTER COLUMN id SET DEFAULT nextval('math_games_id_seq'::regclass);

--ENGLISH_GAMES
ALTER TABLE public.english_games_id_seq OWNER TO postgres;
ALTER SEQUENCE english_games_id_seq OWNED BY english_games.id;
ALTER TABLE ONLY english_games ALTER COLUMN id SET DEFAULT nextval('english_games_id_seq'::regclass);

--COUNTING
ALTER TABLE public.counting_id_seq OWNER TO postgres;
ALTER SEQUENCE counting_id_seq OWNED BY counting.id;
ALTER TABLE ONLY counting ALTER COLUMN id SET DEFAULT nextval('counting_id_seq'::regclass);

--ADDITION
ALTER TABLE public.addition_id_seq OWNER TO postgres;
ALTER SEQUENCE addition_id_seq OWNED BY addition.id;
ALTER TABLE ONLY addition ALTER COLUMN id SET DEFAULT nextval('addition_id_seq'::regclass);

--SUBTRACTION
ALTER TABLE public.subtraction_id_seq OWNER TO postgres;
ALTER SEQUENCE subtraction_id_seq OWNED BY subtraction.id;
ALTER TABLE ONLY subtraction ALTER COLUMN id SET DEFAULT nextval('subtraction_id_seq'::regclass);

--USERS
ALTER TABLE public.users_id_seq OWNER TO postgres;
ALTER SEQUENCE users_id_seq OWNED BY users.id;
ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);

--SCHOOLS
ALTER TABLE public.schools_id_seq OWNER TO postgres;
ALTER SEQUENCE schools_id_seq OWNED BY schools.id;
ALTER TABLE ONLY schools ALTER COLUMN id SET DEFAULT nextval('schools_id_seq'::regclass);

--ADMINS
ALTER TABLE public.admins_id_seq OWNER TO postgres;
ALTER SEQUENCE admins_id_seq OWNED BY admins.id;
ALTER TABLE ONLY admins ALTER COLUMN id SET DEFAULT nextval('admins_id_seq'::regclass);

--STUDENTS
ALTER TABLE public.students_id_seq OWNER TO postgres;
ALTER SEQUENCE students_id_seq OWNED BY students.id;
ALTER TABLE ONLY students ALTER COLUMN id SET DEFAULT nextval('students_id_seq'::regclass);

--TEACHERS
ALTER TABLE public.teachers_id_seq OWNER TO postgres;
ALTER SEQUENCE teachers_id_seq OWNED BY teachers.id;
ALTER TABLE ONLY teachers ALTER COLUMN id SET DEFAULT nextval('teachers_id_seq'::regclass);

--HOME_ROOMS
--ALTER TABLE public.homerooms_id_seq OWNER TO postgres;
--ALTER SEQUENCE homerooms_id_seq OWNED BY homerooms.id;
--ALTER TABLE ONLY homerooms ALTER COLUMN id SET DEFAULT nextval('homerooms_id_seq'::regclass);

--------------------PRIMARY KEYS---------------------------------------
--PASSWORDS
ALTER TABLE passwords ADD PRIMARY KEY (password);

--GRADE_LEVELS
ALTER TABLE grade_levels ADD PRIMARY KEY (grade_level);

--MATH_LEVELS
ALTER TABLE math_levels ADD PRIMARY KEY (level);

--ENGLISH_LEVELS
ALTER TABLE english_levels ADD PRIMARY KEY (level);

--SUBJECTS
ALTER TABLE subjects ADD PRIMARY KEY (subject);

--MATH_GAMES
ALTER TABLE math_games ADD PRIMARY KEY (level,url);

--ENGLISH_GAMES
ALTER TABLE english_games ADD PRIMARY KEY (level,url);

--COUNTING
ALTER TABLE counting ADD PRIMARY KEY (level);

--ADDITION
ALTER TABLE addition ADD PRIMARY KEY (level);

--SUBTRACTION
ALTER TABLE subtraction ADD PRIMARY KEY (level);

--USERS
ALTER TABLE users ADD PRIMARY KEY (id);

--SCHOOLS
ALTER TABLE schools ADD PRIMARY KEY (id);

--ADMINS
ALTER TABLE admins ADD PRIMARY KEY (id);

--STUDENTS
ALTER TABLE students ADD PRIMARY KEY (id);

--TEACHERS
ALTER TABLE teachers ADD PRIMARY KEY (id);

--HOME_ROOMS
--ALTER TABLE homerooms ADD PRIMARY KEY (id);

--------------------------------FOREIGN KEYS----------------------------

--MATH_GAMES
ALTER TABLE math_games ADD FOREIGN KEY (level) REFERENCES math_levels(level);

--ENGLISH_GAMES
ALTER TABLE english_games ADD FOREIGN KEY (level) REFERENCES english_levels(level);

--HOME_ROOMS
--ALTER TABLE homerooms ADD FOREIGN KEY () REFERENCES users(username);

--USERS
--ALTER TABLE users ADD FOREIGN KEY (math_level) REFERENCES math_levels(level);
--ALTER TABLE users ADD FOREIGN KEY (english_level) REFERENCES english_levels(level);
--ALTER TABLE users ADD FOREIGN KEY (admin) REFERENCES users(username);
--ALTER TABLE users ADD FOREIGN KEY (homeroom_id) REFERENCES homerooms(id);

--SCHOOLS
ALTER TABLE schools ADD FOREIGN KEY (user_id) REFERENCES users(id);

--ADMINS
ALTER TABLE admins ADD FOREIGN KEY (user_id) REFERENCES users(id);

--STUDENTS
ALTER TABLE admins ADD FOREIGN KEY (user_id) REFERENCES users(id);

--TEACHERS
ALTER TABLE admins ADD FOREIGN KEY (user_id) REFERENCES users(id);

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
insert into users (username,password,first_name,last_name) values ('anselm','p','Father','Foley'); 
--create admin vis 
insert into users (username,password,first_name,last_name) values ('vis','p','Dolores','Egner'); 

--create teachers anselm 
insert into users (username,password,first_name,last_name) values ('kmary.anselm','p','Sally','Berg'); 
--create teachers vis 
insert into users (username,password,first_name,last_name) values ('jroache.vis','p','James','Roache'); 

--create students anselm 
insert into users (username,password,first_name,last_name) values ('1.anselm','p','Willard','Lackman'); 
--create students vis 
insert into users (username,password,first_name,last_name) values ('1.vis','p','Luke','Breslin'); 

--------------------REVOKE AND GRANT---------------------------------------
REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;

--
-- PostgreSQL database dump complete
--

