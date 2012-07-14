

--****************************************************************
--***************************************************************
--******************  DROP TABLES *************************
--**************************************************************
--**************************************************************


--==================================================================
--====================== GAMES  =============================
--==================================================================

DROP TABLE games_levels cascade;
DROP TABLE games_attempts cascade;
DROP TABLE games cascade;

--==================================================================
--====================== LEVELS  =============================
--==================================================================

DROP TABLE counting cascade;
DROP TABLE addition cascade;
DROP TABLE subtraction cascade;
DROP TABLE levels_standards cascade;
DROP TABLE levels_transactions cascade;
DROP TABLE levels cascade;

--==================================================================
--====================== PEOPLE  =============================
--==================================================================

DROP TABLE permissions_users cascade;
DROP TABLE permissions cascade;
DROP TABLE rooms cascade;
DROP TABLE teachers cascade;
DROP TABLE students cascade;
DROP TABLE users cascade;
DROP TABLE schools cascade;

--==================================================================
--=========================== CORE CURRICULUM  ========================
--==================================================================

DROP TABLE standards cascade;
DROP TABLE clusters cascade;
DROP TABLE domains_grades cascade;
DROP TABLE domains_subjects cascade;
DROP TABLE domains cascade;
DROP TABLE grades cascade;
DROP TABLE subjects cascade;

--==================================================================
--=========================== HELPER  ========================
--==================================================================

DROP TABLE passwords cascade;
DROP TABLE error_log cascade; 


--****************************************************************
--***************************************************************
--******************  POSTGRESQL SETTINGS *************************
--**************************************************************
--**************************************************************

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

--****************************************************************
--***************************************************************
--******************  CREATE TABLES *************************
--**************************************************************
--**************************************************************

--==================================================================
--=========================== HELPER  ========================
--==================================================================

--ERROR_LOG
CREATE TABLE error_log (
    id integer NOT NULL,
    error text,
    error_time timestamp,
    username text
);

--PASSWORDS
CREATE TABLE passwords (
    id integer NOT NULL,
    password text UNIQUE 
);

--==================================================================
--================= PEOPLE  ====================================
--==================================================================

--SCHOOLS
CREATE TABLE schools (
    id integer NOT NULL,
    school_name text NOT NULL UNIQUE 
);

--USERS
CREATE TABLE users (
    id integer NOT NULL,
    username text, 
    password text,
    first_name text,
    last_name text,
    school_id integer NOT NULL 
);

--TEACHERS
CREATE TABLE teachers (
    id integer NOT NULL,
    room_id integer
);

--STUDENTS
CREATE TABLE students (
    id integer NOT NULL,
    teacher_id integer 
);

--ROOMS
CREATE TABLE rooms (
    id integer NOT NULL,
    room text NOT NULL,
    school_id integer NOT NULL
);

--PERMISSIONS
CREATE TABLE permissions (
    id integer NOT NULL,
    permission text NOT NULL UNIQUE 
);

--PERMISSIONS_USERS
CREATE TABLE permissions_users (
    permission_id integer NOT NULL,
    user_id integer NOT NULL  
);

--==================================================================
--==================== CORE CURRICULUM  ========================
--==================================================================

--GRADE
CREATE TABLE grades (
    id integer NOT NULL,
    grade text  
);

--SUBJECTS
CREATE TABLE subjects (
    id integer NOT NULL,
    subject text NOT NULL
);

--DOMAINS
CREATE TABLE domains (
    id integer NOT NULL,
    domain text NOT NULL
);

--DOMAINS_SUBJECTS
CREATE TABLE domains_subjects (
    domain_id integer,
    subject_id integer
);

--DOMAINS_GRADES
CREATE TABLE domains_grades (
    domain_id integer,
    grade_id integer 
);

--CLUSTERS
CREATE TABLE clusters (
    id integer NOT NULL,
    cluster text NOT NULL
);

--STANDARDS
CREATE TABLE standards (
    id integer NOT NULL,
    standard text NOT NULL,
    standard_code text NOT NULL
);

--==================================================================
--====================== LEVELS  =============================
--==================================================================

--LEVELS
CREATE TABLE levels (
    id integer NOT NULL,
    level double precision NOT NULL UNIQUE, 
    description text NOT NULL
);

--LEVELS_TRANSACTIONS
CREATE TABLE levels_transactions (
    id integer NOT NULL,
    advancement_time timestamp,
    level_id integer NOT NULL,
    user_id integer NOT NULL
);

--LEVELS_STANDARDS
CREATE TABLE levels_standards (
    level_id integer NOT NULL,
    standard_id integer NOT NULL
);

--COUNTING
CREATE TABLE counting (
    id integer NOT NULL,
    score_needed integer DEFAULT 10 NOT NULL,
    start_number integer NOT NULL,
    end_number integer NOT NULL,
    count_by integer DEFAULT 1 NOT NULL,
    level_id integer NOT NULL
);

--ADDITION
CREATE TABLE addition (
    id integer NOT NULL,
    score_needed integer DEFAULT 10 NOT NULL,
    addend_min integer NOT NULL,
    addend_max integer NOT NULL,
    number_of_addends integer DEFAULT 2 NOT NULL,
    level_id integer NOT NULL
);

--SUBTRACTION
CREATE TABLE subtraction (
    id integer NOT NULL,
    score_needed integer DEFAULT 10 NOT NULL,
    minuend_min integer NOT NULL,
    minuend_max integer NOT NULL,
    subtrahend_min integer NOT NULL,
    subtrahend_max integer NOT NULL,
    number_of_subtrahends integer DEFAULT 1 NOT NULL,
    negative_difference boolean DEFAULT false NOT NULL,
    level_id integer NOT NULL
);

--==================================================================
--===================== GAMES =====================================
--==================================================================

--GAMES
CREATE TABLE games (
    id integer NOT NULL,
    game text NOT NULL UNIQUE,
    url text NOT NULL,
    picture text NOT NULL
);

--GAMES_LEVELS
CREATE TABLE games_levels (
    id integer NOT NULL,
    url text NOT NULL,
    game_id integer NOT NULL,
    level_id integer NOT NULL
);

--GAMES_ATTEMPTS
CREATE TABLE games_attempts (
    id integer NOT NULL,
    game_attempt_time_start timestamp,
    game_attempt_time_end timestamp,
    game_id integer NOT NULL,
    user_id integer NOT NULL,
    level_id integer NOT NULL --should this be standard_id?
);


--==================================================================
--================= ENVIRONMENT  ====================================
--==================================================================

--BROWSERS
--CREATE TABLE browsers (
 --   id integer NOT NULL,
  --  browser text NOT NULL UNIQUE
--);

--Modenizr should help make stuff compatible but we still need webistie to hide certain games.
-- Lets go step by step
-- you have to goto abcandyou.com...when you do...
--i think for now this should be left alone till needed.

--DROP TABLE os cascade; --win98,win2000,winxp,win7,vista,win8,debian3,ubuntu,redhat,fedora,android,mac,etc
--DROP TABLE browser cascade; --ie6,ie7,ie8,ie9,ie10,opera9,opera10,firefox8,firefox9
--DROP TABLE engine cascade; --ogre,torque,javascript,2d_brengine,jmonkey
--i am thinking to show all?






--****************************************************************
--***************************************************************
--******************  CREATE SEQUENCES *************************
--**************************************************************
--**************************************************************

--==================================================================
--================= HELPER  ====================================
--==================================================================

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

--==================================================================
--================= PEOPLE  ====================================
--==================================================================

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

--STUDENTS

--TEACHERS

--ROOMS
CREATE SEQUENCE rooms_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--PERMISSIONS
CREATE SEQUENCE permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--PERMISSIONS_USERS

--==================================================================
--================= CORE CURRICULUM  ====================================
--==================================================================

--SUBJECTS
CREATE SEQUENCE subjects_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--DOMAINS
CREATE SEQUENCE domains_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--CLUSTERS
CREATE SEQUENCE clusters_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--STANDARDS
CREATE SEQUENCE standards_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--GRADES
CREATE SEQUENCE grades_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--==================================================================
--================= LEVELS  ====================================
--==================================================================

--LEVELS
CREATE SEQUENCE levels_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--LEVELS_TRANSACTIONS
CREATE SEQUENCE levels_transactions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--LEVELS_STANDARDS

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


--==================================================================
--================= GAMES  ====================================
--==================================================================

--GAMES
CREATE SEQUENCE games_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--GAMES_LEVELS
CREATE SEQUENCE games_levels_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--GAMES_ATTEMPTS
CREATE SEQUENCE games_attempts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--****************************************************************
--***************************************************************
--****************** ALTER OWNER  *************************
--**************************************************************
--**************************************************************

--==================================================================
--================= HELPER  ====================================
--==================================================================

--PASSWORDS
ALTER TABLE public.passwords OWNER TO postgres;

--ERROR_LOG
ALTER TABLE public.error_log OWNER TO postgres;


--==================================================================
--================= PEOPLE  ====================================
--==================================================================

--USERS
ALTER TABLE public.users OWNER TO postgres;

--SCHOOLS
ALTER TABLE public.schools OWNER TO postgres;

--STUDENTS
ALTER TABLE public.students OWNER TO postgres;

--TEACHERS
ALTER TABLE public.teachers OWNER TO postgres;

--ROOMS
ALTER TABLE public.rooms OWNER TO postgres;

--PERMISSIONS
ALTER TABLE public.permissions OWNER TO postgres;

--PERMISSIONS_USERS
ALTER TABLE public.permissions_users OWNER TO postgres;


--==================================================================
--================= CORE CURRICULUM  ====================================
--==================================================================

--SUBJECTS
ALTER TABLE public.subjects OWNER TO postgres;

--GRADES
ALTER TABLE public.grades OWNER TO postgres;

--DOMAINS
ALTER TABLE public.domains OWNER TO postgres;

--CLUSTERS
ALTER TABLE public.clusters OWNER TO postgres;

--STANDARDS
ALTER TABLE public.standards OWNER TO postgres;


--==================================================================
--================= LEVELS  ====================================
--==================================================================

--LEVELS
ALTER TABLE public.levels OWNER TO postgres;

--LEVELS_TRANSACTIONS
ALTER TABLE public.levels_transactions OWNER TO postgres;

--LEVELS_STANDARDS
ALTER TABLE public.levels_standards OWNER TO postgres;

--COUNTING
ALTER TABLE public.counting OWNER TO postgres;

--ADDITION
ALTER TABLE public.addition OWNER TO postgres;

--SUBTRACTION
ALTER TABLE public.subtraction OWNER TO postgres;


--==================================================================
--================= GAMES  ====================================
--==================================================================

--GAMES
ALTER TABLE public.games OWNER TO postgres;

--GAMES_LEVELS
ALTER TABLE public.games_levels OWNER TO postgres;

--GAMES_ATTEMPTS
ALTER TABLE public.games_attempts OWNER TO postgres;


--****************************************************************
--***************************************************************
--****************** ALTER SEQUENCE  *************************
--**************************************************************
--**************************************************************

--==================================================================
--================= HELPER  ====================================
--==================================================================

--ERROR_LOG
ALTER TABLE public.error_log_id_seq OWNER TO postgres;
ALTER SEQUENCE error_log_id_seq OWNED BY error_log.id;
ALTER TABLE ONLY error_log ALTER COLUMN id SET DEFAULT nextval('error_log_id_seq'::regclass);

--PASSWORDS
ALTER TABLE public.passwords_id_seq OWNER TO postgres;
ALTER SEQUENCE passwords_id_seq OWNED BY passwords.id;
ALTER TABLE ONLY passwords ALTER COLUMN id SET DEFAULT nextval('passwords_id_seq'::regclass);


--==================================================================
--================= PEOPLE   ====================================
--==================================================================

--USERS
ALTER TABLE public.users_id_seq OWNER TO postgres;
ALTER SEQUENCE users_id_seq OWNED BY users.id;
ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);

--SCHOOLS
ALTER TABLE public.schools_id_seq OWNER TO postgres;
ALTER SEQUENCE schools_id_seq OWNED BY schools.id;
ALTER TABLE ONLY schools ALTER COLUMN id SET DEFAULT nextval('schools_id_seq'::regclass);

--STUDENTS

--TEACHERS

--ROOMS
ALTER TABLE public.rooms_id_seq OWNER TO postgres;
ALTER SEQUENCE rooms_id_seq OWNED BY rooms.id;
ALTER TABLE ONLY rooms ALTER COLUMN id SET DEFAULT nextval('rooms_id_seq'::regclass);

--PERMISSIONS
ALTER TABLE public.permissions_id_seq OWNER TO postgres;
ALTER SEQUENCE permissions_id_seq OWNED BY permissions.id;
ALTER TABLE ONLY permissions ALTER COLUMN id SET DEFAULT nextval('permissions_id_seq'::regclass);

--PERMISSIONS_USERS


--==================================================================
--================= CORE CURRICULUM  ====================================
--==================================================================

--GRADES
ALTER TABLE public.grades_id_seq OWNER TO postgres;
ALTER SEQUENCE grades_id_seq OWNED BY grades.id;
ALTER TABLE ONLY grades ALTER COLUMN id SET DEFAULT nextval('grades_id_seq'::regclass);

--SUBJECTS
ALTER TABLE public.subjects_id_seq OWNER TO postgres;
ALTER SEQUENCE subjects_id_seq OWNED BY subjects.id;
ALTER TABLE ONLY subjects ALTER COLUMN id SET DEFAULT nextval('subjects_id_seq'::regclass);

--DOMAINS
ALTER TABLE public.domains_id_seq OWNER TO postgres;
ALTER SEQUENCE domains_id_seq OWNED BY domains.id;
ALTER TABLE ONLY domains ALTER COLUMN id SET DEFAULT nextval('domains_id_seq'::regclass);

--CLUSTERS
ALTER TABLE public.clusters_id_seq OWNER TO postgres;
ALTER SEQUENCE clusters_id_seq OWNED BY clusters.id;
ALTER TABLE ONLY clusters ALTER COLUMN id SET DEFAULT nextval('clusters_id_seq'::regclass);

--STANDARDS
ALTER TABLE public.standards_id_seq OWNER TO postgres;
ALTER SEQUENCE standards_id_seq OWNED BY standards.id;
ALTER TABLE ONLY standards ALTER COLUMN id SET DEFAULT nextval('standards_id_seq'::regclass);


--==================================================================
--================= LEVELS  ====================================
--==================================================================

--LEVELS
ALTER TABLE public.levels_id_seq OWNER TO postgres;
ALTER SEQUENCE levels_id_seq OWNED BY levels.id;
ALTER TABLE ONLY levels ALTER COLUMN id SET DEFAULT nextval('levels_id_seq'::regclass);

--LEVELS_TRANSACTIONS
ALTER TABLE public.levels_transactions_id_seq OWNER TO postgres;
ALTER SEQUENCE levels_transactions_id_seq OWNED BY levels_transactions.id;
ALTER TABLE ONLY levels_transactions ALTER COLUMN id SET DEFAULT nextval('levels_transactions_id_seq'::regclass);

--LEVELS_STANDARDS

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


--==================================================================
--================= GAMES  ====================================
--==================================================================

--GAMES
ALTER TABLE public.games_id_seq OWNER TO postgres;
ALTER SEQUENCE games_id_seq OWNED BY games.id;
ALTER TABLE ONLY games ALTER COLUMN id SET DEFAULT nextval('games_id_seq'::regclass);

--GAMES_LEVELS
ALTER TABLE public.games_levels_id_seq OWNER TO postgres;
ALTER SEQUENCE games_levels_id_seq OWNED BY games_levels.id;
ALTER TABLE ONLY games_levels ALTER COLUMN id SET DEFAULT nextval('games_levels_id_seq'::regclass);

--GAMES_ATTEMPTS
ALTER TABLE public.games_attempts_id_seq OWNER TO postgres;
ALTER SEQUENCE games_attempts_id_seq OWNED BY games_attempts.id;
ALTER TABLE ONLY games_attempts ALTER COLUMN id SET DEFAULT nextval('games_attempts_id_seq'::regclass);


--****************************************************************
--***************************************************************
--****************** PRIMARY KEY  *************************
--**************************************************************
--**************************************************************

--==================================================================
--================= HELPER  ====================================
--==================================================================

--PASSWORDS
ALTER TABLE passwords ADD PRIMARY KEY (password);

--ERROR_LOG
ALTER TABLE error_log ADD PRIMARY KEY (id);

--==================================================================
--================= PEOPLE  ====================================
--==================================================================

--USERS
ALTER TABLE users ADD PRIMARY KEY (id);

--SCHOOLS
ALTER TABLE schools ADD PRIMARY KEY (id);

--STUDENTS
ALTER TABLE students ADD PRIMARY KEY (id);

--TEACHERS
ALTER TABLE teachers ADD PRIMARY KEY (id);

--ROOMS
ALTER TABLE rooms ADD PRIMARY KEY (id);

--PERMISSIONS
ALTER TABLE permissions ADD PRIMARY KEY (id);

--PERMISSIONS_USERS
ALTER TABLE permissions_users ADD PRIMARY KEY (permission_id,user_id);


--==================================================================
--================= CORE CURRICULUM  ====================================
--==================================================================

--SUBJECTS
ALTER TABLE subjects ADD PRIMARY KEY (id);

--GRADES
ALTER TABLE grades ADD PRIMARY KEY (id);

--DOMAINS
ALTER TABLE domains ADD PRIMARY KEY (id);

--DOMAINS_SUBJECTS
ALTER TABLE domains_subjects ADD PRIMARY KEY (domain_id, subject_id);

--DOMAINS_GRADES
ALTER TABLE domains_grades ADD PRIMARY KEY (domain_id, grade_id);


--CLUSTERS
ALTER TABLE clusters ADD PRIMARY KEY (id);

--STANDARDS
ALTER TABLE standards ADD PRIMARY KEY (id);


--==================================================================
--================= LEVELS  ====================================
--==================================================================

--LEVELS
ALTER TABLE levels ADD PRIMARY KEY (id);

--LEVELS_TRANSACTIONS
ALTER TABLE levels_transactions ADD PRIMARY KEY (id);

--LEVELS_STANDARDS
ALTER TABLE levels_standards ADD PRIMARY KEY (level_id,standard_id);

--COUNTING
ALTER TABLE counting ADD PRIMARY KEY (id);

--ADDITION
ALTER TABLE addition ADD PRIMARY KEY (id);

--SUBTRACTION
ALTER TABLE subtraction ADD PRIMARY KEY (id);

--==================================================================
--================= GAMES  ====================================
--==================================================================

--GAMES
ALTER TABLE games ADD PRIMARY KEY (id);

--GAMES_LEVELS
ALTER TABLE games_levels ADD PRIMARY KEY (id);

--GAMES_ATTEMPTS
ALTER TABLE games_attempts ADD PRIMARY KEY (id);


--****************************************************************
--***************************************************************
--****************** FOREIGN KEY  *************************
--**************************************************************
--**************************************************************

--==================================================================
--================= HELPER  ====================================
--==================================================================

--PASSWORDS
--NO FOREIGN KEY

--ERROR_LOG
--NO FOREIGN KEY


--==================================================================
--================= PEOPLE  ====================================
--==================================================================

--USERS
ALTER TABLE users ADD FOREIGN KEY (school_id) REFERENCES schools(id);

--SCHOOLS

--STUDENTS
ALTER TABLE students ADD FOREIGN KEY (id) REFERENCES users(id);

--TEACHERS
ALTER TABLE teachers ADD FOREIGN KEY (id) REFERENCES users(id);

--ROOMS
ALTER TABLE rooms ADD FOREIGN KEY (school_id) REFERENCES schools(id);
ALTER TABLE rooms ADD UNIQUE (school_id,room);

--PERMISSIONS

--PERMISSIONS_USERS
ALTER TABLE permissions_users ADD FOREIGN KEY (permission_id) REFERENCES permissions(id);
ALTER TABLE permissions_users ADD FOREIGN KEY (user_id) REFERENCES users(id);


--==================================================================
--================= CORE CURRICULUM  ====================================
--==================================================================

--GRADES

--SUBJECTS

--DOMAINS

--DOMAINS_SUBJECTS
ALTER TABLE domains_subjects ADD FOREIGN KEY (subject_id) REFERENCES subjects(id);

--DOMAINS_GRADES
ALTER TABLE domains_grades ADD FOREIGN KEY (grade_id) REFERENCES grades(id);

--CLUSTERS

--STANDARDS


--==================================================================
--================= LEVELS  ====================================
--==================================================================

--LEVELS

--LEVELS_TRANSACTIONS
ALTER TABLE levels_transactions ADD FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE levels_transactions ADD FOREIGN KEY (level_id) REFERENCES levels(id);

--LEVELS_STANDARDS
ALTER TABLE levels_standards ADD FOREIGN KEY (level_id) REFERENCES levels(id);
ALTER TABLE levels_standards ADD FOREIGN KEY (standard_id) REFERENCES standards(id);

--COUNTING
ALTER TABLE counting ADD FOREIGN KEY (level_id) REFERENCES levels(id);

--ADDITION
ALTER TABLE addition ADD FOREIGN KEY (level_id) REFERENCES levels(id);

--SUBTRACTION
ALTER TABLE subtraction ADD FOREIGN KEY (level_id) REFERENCES levels(id);


--==================================================================
--================= GAMES  ====================================
--==================================================================

--GAMES

--GAMES_LEVELS
ALTER TABLE games_levels ADD FOREIGN KEY (game_id) REFERENCES games(id);
ALTER TABLE games_levels ADD FOREIGN KEY (level_id) REFERENCES levels(id);

--GAMES_ATTEMPTS
ALTER TABLE games_attempts ADD FOREIGN KEY (game_id) REFERENCES games(id);
ALTER TABLE games_attempts ADD FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE games_attempts ADD FOREIGN KEY (level_id) REFERENCES levels(id);


--****************************************************************
--***************************************************************
--****************** UNIQUE CONSTRAINT  *************************
--**************************************************************
--**************************************************************

--==================================================================
--================= HELPER  ====================================
--==================================================================

--PASSWORDS

--ERROR_LOG


--==================================================================
--================= PEOPLE  ====================================
--==================================================================

--USERS
ALTER TABLE users ADD UNIQUE (username,school_id);

--SCHOOLS

--STUDENTS

--TEACHERS

--ROOMS
ALTER TABLE rooms ADD UNIQUE (school_id,room);

--PERMISSIONS

--PERMISSIONS_USERS


--==================================================================
--================= CORE CURRICULUM  ====================================
--==================================================================

--GRADES

--SUBJECTS

--DOMAINS

--CLUSTERS

--STANDARDS


--==================================================================
--================= LEVELS  ====================================
--==================================================================

--LEVELS

--LEVELS_TRANSACTIONS

--LEVELS_STANDARDS

--COUNTING

--ADDITION

--SUBTRACTION


--==================================================================
--================= GAMES  ====================================
--==================================================================

--GAMES

--GAMES_LEVELS

--GAMES_ATTEMPTS


--****************************************************************
--***************************************************************
--****************** INSERTS  *************************
--**************************************************************
--**************************************************************

--==================================================================
--================= HELPER  ====================================
--==================================================================

--PASSWORDS !!!!!!!!!!!! LISTED BELOW BECAUSE THEY ARE HUGE !!!!!!!!!

--ERROR_LOG

--==================================================================
--================= PEOPLE  ====================================
--==================================================================

--SCHOOLS

--USERS

--TEACHERS

--STUDENTS

--PERMISSIONS
insert into permissions(permission) values ('INSERT');       

--PERMISSIONS_USERS

--==================================================================
--================= CORE CURRICULUM  ====================================
--==================================================================

--GRADE
insert into grades (grade) values ('K');
insert into grades (grade) values ('1');
insert into grades (grade) values ('2');
insert into grades (grade) values ('3');
insert into grades (grade) values ('4');
insert into grades (grade) values ('5');
insert into grades (grade) values ('6');
insert into grades (grade) values ('7');
insert into grades (grade) values ('8');
insert into grades (grade) values ('9');
insert into grades (grade) values ('10');
insert into grades (grade) values ('11');
insert into grades (grade) values ('12');

--SUBJECTS
insert into subjects (subject) values ('Math');
insert into subjects (subject) values ('English');
insert into subjects (subject) values ('History/Social Studies');
insert into subjects (subject) values ('Science');
insert into subjects (subject) values ('Technical');

--DOMAINS
insert into domains (domain) values ('Counting and Cardinality'); --1
insert into domains (domain) values ('Operations and Algebraic Thinking'); --2
insert into domains (domain) values ('Number and Operations in Base Ten'); --3
insert into domains (domain) values ('Measurement and Data'); --4
insert into domains (domain) values ('Geometry'); --4
insert into domains (domain) values ('Number and Operations-Fractions'); --5
insert into domains (domain) values ('Ratios and Proportional Relationships'); --6
insert into domains (domain) values ('The Number System'); --7
insert into domains (domain) values ('Expressions and Equations'); --8
insert into domains (domain) values ('Statistics and Probability'); --9
insert into domains (domain) values ('Functions'); --10
insert into domains (domain) values ('The Real Number System'); --11
insert into domains (domain) values ('Quantities'); --12
insert into domains (domain) values ('The Complex Number System'); --13
insert into domains (domain) values ('Vector and Matrix Quantities'); --14
insert into domains (domain) values ('Seeing Structure in Expressions'); --15
insert into domains (domain) values ('Arithmetic with Polynomials and Rational Expressions'); --16
insert into domains (domain) values ('Creating Equations'); --17
insert into domains (domain) values ('Reasoning with Equations and Inequalities'); --18
insert into domains (domain) values ('Connections to Expressions, Equations, Modeling, and Coordinates'); --19
insert into domains (domain) values ('Interpreting Functions'); --20
insert into domains (domain) values ('Building Functions'); --21
insert into domains (domain) values ('Linear, Quadratic, and Exponential Models'); --22
insert into domains (domain) values ('Trigonometric Functions'); --23
insert into domains (domain) values ('Modeling'); --24
insert into domains (domain) values ('Modeling Standards'); --25
insert into domains (domain) values ('Connections to Equations'); --26
insert into domains (domain) values ('Congruence'); --27
insert into domains (domain) values ('Similiarity, Right Triangles, and Trigonometry'); --28
insert into domains (domain) values ('Circles'); --29
insert into domains (domain) values ('Expressing Geometric Properties with Equations'); --30
insert into domains (domain) values ('Geometric Measurement and Dimension'); --31
insert into domains (domain) values ('Modeling and Geometry'); --32
insert into domains (domain) values ('Connections to Functions and Modeling'); --33
insert into domains (domain) values ('Interpreting Categorical and Quantitative Data'); --34
insert into domains (domain) values ('Making Inferences and Justifying Conclusions'); --35
insert into domains (domain) values ('Conditional Probability and the Rules of Probability'); --36
insert into domains (domain) values ('Using Probability to Make Decisions'); --37

insert into domains (domain) values ('College and Career Readiness Anchor Standards for Reading'); --38
insert into domains (domain) values ('Reading Standards for Literature'); --39
insert into domains (domain) values ('Reading for Informational Text'); --40
insert into domains (domain) values ('Reading Standards: Foundational Skills'); --41
insert into domains (domain) values ('College and Career Readiness Anchor Standards for Writing'); --42
insert into domains (domain) values ('Writing Standards'); --43
insert into domains (domain) values ('College and Career Readiness Anchor Standards for Speaking and Listening'); --44
insert into domains (domain) values ('Speaking and Listening Standards'); --45
insert into domains (domain) values ('College and Career Readiness Anchor Standards for Language'); --46
insert into domains (domain) values ('Language Standards'); --47
insert into domains (domain) values ('Language Progressive Skills, by Grade'); --48
insert into domains (domain) values ('Standard 10: Range, Quality, and Complexity of Student Reading'); --49
insert into domains (domain) values ('Staying on Topic Within a Grade and Across Grades'); --50
insert into domains (domain) values ('College and Career Readiness Anchor Standards for Reading'); --51
insert into domains (domain) values ('Reading Standards for Literacy in History/Social Studies'); --52
insert into domains (domain) values ('Reading Standards for Literacy in Science and Technical Subjects'); --53
insert into domains (domain) values ('College and Career Readiness Anchor Standards for Writing'); --54
insert into domains (domain) values ('Writing Standards for Literacy in History/Social Studies, Science, and Technical Subjects'); --55

--DOMAINS_SUBJECTS
insert into domains_subjects (domain_id, subject_id) values (1,1); 

insert into domains_subjects (domain_id, subject_id) values (39,2); 

--DOMAINS_GRADES
insert into domains_grades (domain_id, grade_id) values (1,1); 

insert into domains_grades (domain_id, grade_id) values (39,1); 

--CLUSTERS
insert into clusters (cluster) values ('Know number names and the count sequence.');
insert into clusters (cluster) values ('Count to tell the number of objects.');

insert into clusters (cluster) values ('Key Ideas and Details.');

--STANDARDS
insert into standards (standard,standard_code) values ('Count to 100 by ones and by tens.','1'); --1
insert into standards (standard,standard_code) values ('Count forward beginning from a given number within the known
sequence (instead of having to begin at 1).','2'); --2
insert into standards (standard,standard_code) values ('Write numbers from 0 to 20. Represent a number of objects with a written numeral 0-20 (with 0 representing a count of no objects.','1'); --3

insert into standards (standard,standard_code) values ('Understand the relationship between numbers and quantities; connect counting to cardinality.','1');
insert into standards (standard,standard_code) values ('When counting objects, say the number names in the standard order, pairing each object with one and only one number name and each number name with one and only one object.','a');

insert into standards (standard,standard_code) values ('With prompting and support, ask and answer questions about key details in a text.','1');

--==================================================================
--================= LEVELS  ====================================
--==================================================================

--LEVELS
--count to 100
insert into levels(level,description) values (1,'Count from 0 to 10'); --1       
insert into levels(level,description) values (.5,'Start of Journey'); --2      
insert into levels(level,description) values (2,'Count from 10 to 20'); --3      
insert into levels(level,description) values (3,'Count from 20 to 30');   --4    
insert into levels(level,description) values (4,'Count from 30 to 40');     --5  
insert into levels(level,description) values (5,'Count from 40 to 50');    --6   
insert into levels(level,description) values (6,'Count from 50 to 60');   --7    
insert into levels(level,description) values (7,'Count from 60 to 70');  --8     
insert into levels(level,description) values (8,'Count from 70 to 80');    --9   
insert into levels(level,description) values (9,'Count from 80 to 90');      --10 
insert into levels(level,description) values (10,'Count from 90 to 100');      --11 

--count by 10's to 100
insert into levels(level,description) values (11,'Count to 100 by tens');      --12 

--count from random known sequence
insert into levels(level,description) values (12,'Count from 87 to 97'); --13
insert into levels(level,description) values (13,'Count from 23 to 33'); --14
insert into levels(level,description) values (14,'Count from 55 to 65'); --15
insert into levels(level,description) values (15,'Count from 26 to 36'); --16
insert into levels(level,description) values (16,'Count from 49 to 59'); --17
insert into levels(level,description) values (17,'Count from 4 to 14'); --18
insert into levels(level,description) values (18,'Count from 67 to 77'); --19
insert into levels(level,description) values (19,'Count from 13 to 23'); --20
insert into levels(level,description) values (20,'Count from 52 to 62'); --21
insert into levels(level,description) values (21,'Count from 38 to 48'); --22

--write numbers from 0 to 20
insert into levels(level,description) values (22,'Write numbers from 0 to 5'); --23
insert into levels(level,description) values (23,'Write numbers from 5 to 10'); --24
insert into levels(level,description) values (24,'Write numbers from 10 to 15'); --25
insert into levels(level,description) values (25,'Write numbers from 15 to 20'); --26


--LEVELS_STANDARDS
--count by 1's to 100
insert into levels_standards(level_id, standard_id) values (1,1);       
--insert into levels_standards(level_id, standard_id) values (2,1); this is the start of journey level_id      
insert into levels_standards(level_id, standard_id) values (3,1);       
insert into levels_standards(level_id, standard_id) values (4,1);       
insert into levels_standards(level_id, standard_id) values (5,1);       
insert into levels_standards(level_id, standard_id) values (6,1);       
insert into levels_standards(level_id, standard_id) values (7,1);       
insert into levels_standards(level_id, standard_id) values (8,1);       
insert into levels_standards(level_id, standard_id) values (9,1);       
insert into levels_standards(level_id, standard_id) values (10,1);       
insert into levels_standards(level_id, standard_id) values (11,1);       
--count by 10's to 100
insert into levels_standards(level_id, standard_id) values (12,1);       

--count from random known sequence
insert into levels_standards(level_id, standard_id) values (13,2);       
insert into levels_standards(level_id, standard_id) values (14,2);       
insert into levels_standards(level_id, standard_id) values (15,2);       
insert into levels_standards(level_id, standard_id) values (16,2);       
insert into levels_standards(level_id, standard_id) values (17,2);       
insert into levels_standards(level_id, standard_id) values (18,2);       
insert into levels_standards(level_id, standard_id) values (19,2);       
insert into levels_standards(level_id, standard_id) values (20,2);       
insert into levels_standards(level_id, standard_id) values (21,2);       
insert into levels_standards(level_id, standard_id) values (22,2);       

--write numbers from 0 to 20
insert into levels_standards(level_id, standard_id) values (23,3);       
insert into levels_standards(level_id, standard_id) values (24,3);       
insert into levels_standards(level_id, standard_id) values (25,3);       
insert into levels_standards(level_id, standard_id) values (26,3);       


--LEVELS_TRANSACTIONS

--COUNTING
--count by 1's to 100
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,0,10,1,1);
-- this is the start value Start of journey
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,10,20,1,3);
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,20,30,1,4);
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,30,40,1,5);
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,40,50,1,6);
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,50,60,1,7);
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,60,70,1,8);
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,70,80,1,9);
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,80,90,1,10);
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,90,100,1,11);

--count by 10's to 100
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,0,100,10,12);

--count from random known sequence
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,87,97,1,13);
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,23,33,1,14);
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,55,65,1,15);
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,26,36,1,16);
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,49,59,1,17);
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,4,14,1,18);
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,67,77,1,19);
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,13,23,1,20);
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,52,62,1,21);
insert into counting (score_needed,start_number,end_number,count_by,level_id) values (0,38,48,1,22);


--ADDITION

--SUBTRACTION


--==================================================================
--================= GAMES ====================================
--==================================================================

--GAMES
insert into games (game,url,picture) values ('Dungeon','/src/games/dungeon.php','/images/doors/door_open.png');

--GAMES_LEVELS
--count by 1's to 100
insert into games_levels (level_id,game_id,url) values  (1,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (3,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (4,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (5,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (6,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (7,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (8,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (9,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (10,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (11,1,'/web/game/count.php');

---count by 10's to 100
insert into games_levels (level_id,game_id,url) values  (12,1,'/web/game/count.php');

--count from random known sequence
insert into games_levels (level_id,game_id,url) values  (13,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (14,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (15,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (16,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (17,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (18,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (19,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (20,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (21,1,'/web/game/count.php');
insert into games_levels (level_id,game_id,url) values  (22,1,'/web/game/count.php');

--write from 0 to 20
insert into games_levels (level_id,game_id,url) values  (23,1,'/web/game/write_0_5.php');
insert into games_levels (level_id,game_id,url) values  (24,1,'/web/game/write_5_10.php');
insert into games_levels (level_id,game_id,url) values  (25,1,'/web/game/write_10_15.php');
insert into games_levels (level_id,game_id,url) values  (26,1,'/web/game/write_15_20.php');


--GAMES_ATTEMPTS





--(CONTINUED PASSWORDS).......

--PASSWORDS
--3 letter easy words
insert into passwords (password) values ('ahh'); 
insert into passwords (password) values ('abs'); 
insert into passwords (password) values ('ace'); 
insert into passwords (password) values ('add'); 
insert into passwords (password) values ('aft'); 
insert into passwords (password) values ('ape'); 
insert into passwords (password) values ('and'); 
insert into passwords (password) values ('aim'); 
insert into passwords (password) values ('aid'); 
insert into passwords (password) values ('air'); 
insert into passwords (password) values ('all'); 
insert into passwords (password) values ('amp'); 
insert into passwords (password) values ('ant'); 
insert into passwords (password) values ('app'); 
insert into passwords (password) values ('apt'); 
insert into passwords (password) values ('arc'); 
insert into passwords (password) values ('arf'); 
insert into passwords (password) values ('ark'); 
insert into passwords (password) values ('arm'); 
insert into passwords (password) values ('art'); 
insert into passwords (password) values ('ash'); 
insert into passwords (password) values ('ask'); 
insert into passwords (password) values ('ate'); 
insert into passwords (password) values ('ave'); 
insert into passwords (password) values ('awe'); 
insert into passwords (password) values ('axe'); 
insert into passwords (password) values ('aye'); 
insert into passwords (password) values ('ays'); 
/*
insert into passwords (password) values ('baa'); 
insert into passwords (password) values ('bad'); 
insert into passwords (password) values ('bag'); 
insert into passwords (password) values ('bam'); 
insert into passwords (password) values ('ban'); 
insert into passwords (password) values ('bap'); 
insert into passwords (password) values ('bar'); 
insert into passwords (password) values ('bat'); 
insert into passwords (password) values ('bay'); 
insert into passwords (password) values ('bed'); 
insert into passwords (password) values ('bee'); 
insert into passwords (password) values ('beg'); 
insert into passwords (password) values ('ben'); 
insert into passwords (password) values ('bet'); 
insert into passwords (password) values ('bib'); 
insert into passwords (password) values ('bid'); 
insert into passwords (password) values ('big'); 
insert into passwords (password) values ('bin'); 
insert into passwords (password) values ('bio'); 
insert into passwords (password) values ('bit'); 
insert into passwords (password) values ('biz'); 
insert into passwords (password) values ('boa'); 
insert into passwords (password) values ('bob'); 
insert into passwords (password) values ('bod'); 
insert into passwords (password) values ('bog'); 
insert into passwords (password) values ('boo'); 
insert into passwords (password) values ('bop'); 
insert into passwords (password) values ('bot'); 
insert into passwords (password) values ('bow'); 
insert into passwords (password) values ('box'); 
insert into passwords (password) values ('boy'); 
insert into passwords (password) values ('bro'); 
insert into passwords (password) values ('brr'); 
insert into passwords (password) values ('bub'); 
insert into passwords (password) values ('bud'); 
insert into passwords (password) values ('bug'); 
insert into passwords (password) values ('bum'); 
insert into passwords (password) values ('bun'); 
insert into passwords (password) values ('bur'); 
insert into passwords (password) values ('bus'); 
insert into passwords (password) values ('but'); 
insert into passwords (password) values ('buy'); 


insert into passwords (password) values ('cab'); 
insert into passwords (password) values ('cad'); 
insert into passwords (password) values ('cam'); 
insert into passwords (password) values ('can'); 
insert into passwords (password) values ('cap'); 
insert into passwords (password) values ('car'); 
insert into passwords (password) values ('cat'); 
insert into passwords (password) values ('caw'); 
insert into passwords (password) values ('cee'); 
insert into passwords (password) values ('cob'); 
insert into passwords (password) values ('cod'); 
insert into passwords (password) values ('cog'); 
insert into passwords (password) values ('col'); 
insert into passwords (password) values ('con'); 
insert into passwords (password) values ('coo'); 
insert into passwords (password) values ('cop'); 
insert into passwords (password) values ('cor'); 
insert into passwords (password) values ('cos'); 
insert into passwords (password) values ('cot'); 
insert into passwords (password) values ('cow'); 
insert into passwords (password) values ('coy'); 
insert into passwords (password) values ('coz'); 
insert into passwords (password) values ('cry'); 
insert into passwords (password) values ('cub'); 
insert into passwords (password) values ('cud'); 
insert into passwords (password) values ('cue'); 
insert into passwords (password) values ('cup'); 
insert into passwords (password) values ('cut'); 

insert into passwords (password) values ('dab'); 
insert into passwords (password) values ('dad'); 
insert into passwords (password) values ('dag'); 
insert into passwords (password) values ('dah'); 
insert into passwords (password) values ('dak'); 
insert into passwords (password) values ('dal'); 
insert into passwords (password) values ('dam'); 
insert into passwords (password) values ('dan'); 
insert into passwords (password) values ('dap'); 
insert into passwords (password) values ('daw'); 
insert into passwords (password) values ('day'); 
insert into passwords (password) values ('deb'); 
insert into passwords (password) values ('dee'); 
insert into passwords (password) values ('def'); 
insert into passwords (password) values ('del'); 
insert into passwords (password) values ('den'); 
insert into passwords (password) values ('dev'); 
insert into passwords (password) values ('dew'); 
insert into passwords (password) values ('dex'); 
insert into passwords (password) values ('dey'); 
insert into passwords (password) values ('dib'); 
insert into passwords (password) values ('did'); 
insert into passwords (password) values ('die'); 
insert into passwords (password) values ('dif'); 
insert into passwords (password) values ('dig'); 
insert into passwords (password) values ('dim'); 
insert into passwords (password) values ('din'); 
insert into passwords (password) values ('dip'); 
insert into passwords (password) values ('dis'); 
insert into passwords (password) values ('dit'); 
insert into passwords (password) values ('doc'); 
insert into passwords (password) values ('doe'); 
insert into passwords (password) values ('dog'); 
insert into passwords (password) values ('dol'); 
insert into passwords (password) values ('dom'); 
insert into passwords (password) values ('don'); 
insert into passwords (password) values ('dor'); 
insert into passwords (password) values ('dos'); 
insert into passwords (password) values ('dot'); 
insert into passwords (password) values ('dow'); 
insert into passwords (password) values ('dry'); 
insert into passwords (password) values ('dub'); 
insert into passwords (password) values ('dud'); 
insert into passwords (password) values ('due'); 
insert into passwords (password) values ('dug'); 
insert into passwords (password) values ('duh'); 
insert into passwords (password) values ('dun'); 
insert into passwords (password) values ('duo'); 
insert into passwords (password) values ('dup'); 
insert into passwords (password) values ('dye'); 

insert into passwords (password) values ('ear'); 
insert into passwords (password) values ('eat'); 
insert into passwords (password) values ('ebb'); 
insert into passwords (password) values ('eds'); 
insert into passwords (password) values ('eek'); 
insert into passwords (password) values ('eel'); 
insert into passwords (password) values ('egg'); 
insert into passwords (password) values ('ego'); 
insert into passwords (password) values ('eke'); 
insert into passwords (password) values ('eld'); 
insert into passwords (password) values ('elf'); 
insert into passwords (password) values ('elk'); 
insert into passwords (password) values ('ell'); 
insert into passwords (password) values ('elm'); 
insert into passwords (password) values ('end'); 
insert into passwords (password) values ('eon'); 
insert into passwords (password) values ('era'); 
insert into passwords (password) values ('ere'); 
insert into passwords (password) values ('err'); 
insert into passwords (password) values ('eve'); 
insert into passwords (password) values ('eye'); 

insert into passwords (password) values ('fab'); 
insert into passwords (password) values ('fad'); 
insert into passwords (password) values ('fan'); 
insert into passwords (password) values ('far'); 
insert into passwords (password) values ('fat'); 
insert into passwords (password) values ('fax'); 
insert into passwords (password) values ('fay'); 
insert into passwords (password) values ('fed'); 
insert into passwords (password) values ('fee'); 
insert into passwords (password) values ('fen'); 
insert into passwords (password) values ('fer'); 
insert into passwords (password) values ('fes'); 
insert into passwords (password) values ('fet'); 
insert into passwords (password) values ('few'); 
insert into passwords (password) values ('fey'); 
insert into passwords (password) values ('fez'); 
insert into passwords (password) values ('fib'); 
insert into passwords (password) values ('fid'); 
insert into passwords (password) values ('fie'); 
insert into passwords (password) values ('fig'); 
insert into passwords (password) values ('fin'); 
insert into passwords (password) values ('fir'); 
insert into passwords (password) values ('fit'); 
insert into passwords (password) values ('fix'); 
insert into passwords (password) values ('fiz'); 
insert into passwords (password) values ('flu'); 
insert into passwords (password) values ('fly'); 
insert into passwords (password) values ('fob'); 
insert into passwords (password) values ('foe'); 
insert into passwords (password) values ('fog'); 
insert into passwords (password) values ('foh'); 
insert into passwords (password) values ('fon'); 
insert into passwords (password) values ('fop'); 
insert into passwords (password) values ('for'); 
insert into passwords (password) values ('fox'); 
insert into passwords (password) values ('foy'); 
insert into passwords (password) values ('fro'); 
insert into passwords (password) values ('fry'); 
insert into passwords (password) values ('fub'); 
insert into passwords (password) values ('fud'); 
insert into passwords (password) values ('fun'); 
insert into passwords (password) values ('fur'); 

insert into passwords (password) values ('gab'); 
insert into passwords (password) values ('gad'); 
insert into passwords (password) values ('gag'); 
insert into passwords (password) values ('gal'); 
insert into passwords (password) values ('gam'); 
insert into passwords (password) values ('gan'); 
insert into passwords (password) values ('gap'); 
insert into passwords (password) values ('gar'); 
insert into passwords (password) values ('gas'); 
insert into passwords (password) values ('gat'); 
insert into passwords (password) values ('ged'); 
insert into passwords (password) values ('gee'); 
insert into passwords (password) values ('gel'); 
insert into passwords (password) values ('gem'); 
insert into passwords (password) values ('gen'); 
insert into passwords (password) values ('get'); 
insert into passwords (password) values ('gey'); 
insert into passwords (password) values ('gib'); 
insert into passwords (password) values ('gid'); 
insert into passwords (password) values ('gie'); 
insert into passwords (password) values ('gig'); 
insert into passwords (password) values ('gin'); 
insert into passwords (password) values ('gip'); 
insert into passwords (password) values ('git'); 
insert into passwords (password) values ('gnu'); 
insert into passwords (password) values ('goa'); 
insert into passwords (password) values ('gob'); 
insert into passwords (password) values ('god'); 
insert into passwords (password) values ('goo'); 
insert into passwords (password) values ('gor'); 
insert into passwords (password) values ('gos'); 
insert into passwords (password) values ('got'); 
insert into passwords (password) values ('gox'); 
insert into passwords (password) values ('goy'); 
insert into passwords (password) values ('gul'); 
insert into passwords (password) values ('gum'); 
insert into passwords (password) values ('gun'); 
insert into passwords (password) values ('gut'); 
insert into passwords (password) values ('guv'); 
insert into passwords (password) values ('guy'); 
insert into passwords (password) values ('gym'); 
insert into passwords (password) values ('gyp'); 

insert into passwords (password) values ('had'); 
insert into passwords (password) values ('hag'); 
insert into passwords (password) values ('hah'); 
insert into passwords (password) values ('ham'); 
insert into passwords (password) values ('hap'); 
insert into passwords (password) values ('has'); 
insert into passwords (password) values ('hat'); 
insert into passwords (password) values ('haw'); 
insert into passwords (password) values ('hay'); 
insert into passwords (password) values ('heh'); 
insert into passwords (password) values ('hem'); 
insert into passwords (password) values ('hen'); 
insert into passwords (password) values ('hep'); 
insert into passwords (password) values ('her'); 
insert into passwords (password) values ('hes'); 
insert into passwords (password) values ('hew'); 
insert into passwords (password) values ('hex'); 
insert into passwords (password) values ('hey'); 
insert into passwords (password) values ('hic'); 
insert into passwords (password) values ('hid'); 
insert into passwords (password) values ('hie'); 
insert into passwords (password) values ('him'); 
insert into passwords (password) values ('hin'); 
insert into passwords (password) values ('hip'); 
insert into passwords (password) values ('his'); 
insert into passwords (password) values ('hit'); 
insert into passwords (password) values ('hmm'); 
insert into passwords (password) values ('hob'); 
insert into passwords (password) values ('hod'); 
insert into passwords (password) values ('hoe'); 
insert into passwords (password) values ('hog'); 
insert into passwords (password) values ('hon'); 
insert into passwords (password) values ('hop'); 
insert into passwords (password) values ('hot'); 
insert into passwords (password) values ('how'); 
insert into passwords (password) values ('hoy'); 
insert into passwords (password) values ('hub'); 
insert into passwords (password) values ('hue'); 
insert into passwords (password) values ('hug'); 
insert into passwords (password) values ('huh'); 
insert into passwords (password) values ('hun'); 
insert into passwords (password) values ('hup'); 
insert into passwords (password) values ('hut'); 
insert into passwords (password) values ('hyp'); 

insert into passwords (password) values ('ice'); 
insert into passwords (password) values ('ich'); 
insert into passwords (password) values ('ick'); 
insert into passwords (password) values ('icy'); 
insert into passwords (password) values ('ids'); 
insert into passwords (password) values ('iff'); 
insert into passwords (password) values ('ifs'); 
insert into passwords (password) values ('igg'); 
insert into passwords (password) values ('ilk'); 
insert into passwords (password) values ('ill'); 
insert into passwords (password) values ('imp'); 
insert into passwords (password) values ('ink'); 
insert into passwords (password) values ('inn'); 
insert into passwords (password) values ('ins'); 
insert into passwords (password) values ('ion'); 
insert into passwords (password) values ('ire'); 
insert into passwords (password) values ('irk'); 
insert into passwords (password) values ('ism'); 
insert into passwords (password) values ('its'); 
insert into passwords (password) values ('ivy'); 

insert into passwords (password) values ('jab'); 
insert into passwords (password) values ('jag'); 
insert into passwords (password) values ('jam'); 
insert into passwords (password) values ('jar'); 
insert into passwords (password) values ('jaw'); 
insert into passwords (password) values ('jay'); 
insert into passwords (password) values ('jee'); 
insert into passwords (password) values ('jet'); 
insert into passwords (password) values ('jib'); 
insert into passwords (password) values ('jig'); 
insert into passwords (password) values ('jin'); 
insert into passwords (password) values ('job'); 
insert into passwords (password) values ('joe'); 
insert into passwords (password) values ('jog'); 
insert into passwords (password) values ('jot'); 
insert into passwords (password) values ('jow'); 
insert into passwords (password) values ('joy'); 
insert into passwords (password) values ('jug'); 
insert into passwords (password) values ('jun'); 
insert into passwords (password) values ('jus'); 
insert into passwords (password) values ('jut'); 

insert into passwords (password) values ('kab'); 
insert into passwords (password) values ('kae'); 
insert into passwords (password) values ('kaf'); 
insert into passwords (password) values ('kas'); 
insert into passwords (password) values ('kat'); 
insert into passwords (password) values ('kea'); 
insert into passwords (password) values ('keg'); 
insert into passwords (password) values ('ken'); 
insert into passwords (password) values ('kep'); 
insert into passwords (password) values ('kex'); 
insert into passwords (password) values ('key'); 
insert into passwords (password) values ('kid'); 
insert into passwords (password) values ('kin'); 
insert into passwords (password) values ('kip'); 
insert into passwords (password) values ('kis'); 
insert into passwords (password) values ('kit'); 
insert into passwords (password) values ('koa'); 
insert into passwords (password) values ('kob'); 
insert into passwords (password) values ('koi'); 
insert into passwords (password) values ('kop'); 
insert into passwords (password) values ('kor'); 
insert into passwords (password) values ('kos'); 
insert into passwords (password) values ('lab'); 
insert into passwords (password) values ('lad'); 
insert into passwords (password) values ('lag'); 
insert into passwords (password) values ('lam'); 
insert into passwords (password) values ('lap'); 
insert into passwords (password) values ('lar'); 
insert into passwords (password) values ('las'); 
insert into passwords (password) values ('lat'); 
insert into passwords (password) values ('lav'); 
insert into passwords (password) values ('law'); 
insert into passwords (password) values ('lax'); 
insert into passwords (password) values ('lay'); 
insert into passwords (password) values ('lea'); 
insert into passwords (password) values ('led'); 
insert into passwords (password) values ('lee'); 
insert into passwords (password) values ('leg'); 
insert into passwords (password) values ('lei'); 
insert into passwords (password) values ('lek'); 
insert into passwords (password) values ('let'); 
insert into passwords (password) values ('lex'); 
insert into passwords (password) values ('ley'); 
insert into passwords (password) values ('lib'); 
insert into passwords (password) values ('lid'); 
insert into passwords (password) values ('lie'); 
insert into passwords (password) values ('lin'); 
insert into passwords (password) values ('lip'); 
insert into passwords (password) values ('lit'); 
insert into passwords (password) values ('lob'); 
insert into passwords (password) values ('log'); 
insert into passwords (password) values ('loo'); 
insert into passwords (password) values ('lop'); 
insert into passwords (password) values ('lot'); 
insert into passwords (password) values ('low'); 
insert into passwords (password) values ('lox'); 
insert into passwords (password) values ('lug'); 
insert into passwords (password) values ('lum'); 
insert into passwords (password) values ('luv'); 
insert into passwords (password) values ('lux'); 
insert into passwords (password) values ('lye'); 

insert into passwords (password) values ('mac'); 
insert into passwords (password) values ('mad'); 
insert into passwords (password) values ('mae'); 
insert into passwords (password) values ('mag'); 
insert into passwords (password) values ('man'); 
insert into passwords (password) values ('map'); 
insert into passwords (password) values ('mar'); 
insert into passwords (password) values ('mas'); 
insert into passwords (password) values ('mat'); 
insert into passwords (password) values ('maw'); 
insert into passwords (password) values ('max'); 
insert into passwords (password) values ('may'); 
insert into passwords (password) values ('med'); 
insert into passwords (password) values ('mel'); 
insert into passwords (password) values ('men'); 
insert into passwords (password) values ('met'); 
insert into passwords (password) values ('mew'); 
insert into passwords (password) values ('mib'); 
insert into passwords (password) values ('mic'); 
insert into passwords (password) values ('mid'); 
insert into passwords (password) values ('mig'); 
insert into passwords (password) values ('mil'); 
insert into passwords (password) values ('mim'); 
insert into passwords (password) values ('mir'); 
insert into passwords (password) values ('mis'); 
insert into passwords (password) values ('mix'); 
insert into passwords (password) values ('moa'); 
insert into passwords (password) values ('mob'); 
insert into passwords (password) values ('moc'); 
insert into passwords (password) values ('mod'); 
insert into passwords (password) values ('mog'); 
insert into passwords (password) values ('mol'); 
insert into passwords (password) values ('mom'); 
insert into passwords (password) values ('mon'); 
insert into passwords (password) values ('moo'); 
insert into passwords (password) values ('mop'); 
insert into passwords (password) values ('mor'); 
insert into passwords (password) values ('mos'); 
insert into passwords (password) values ('mot'); 
insert into passwords (password) values ('mow'); 
insert into passwords (password) values ('mud'); 
insert into passwords (password) values ('mug'); 
insert into passwords (password) values ('mum'); 
insert into passwords (password) values ('mun'); 
insert into passwords (password) values ('mut'); 

insert into passwords (password) values ('nab'); 
insert into passwords (password) values ('nag'); 
insert into passwords (password) values ('nah'); 
insert into passwords (password) values ('nam'); 
insert into passwords (password) values ('nan'); 
insert into passwords (password) values ('nap'); 
insert into passwords (password) values ('naw'); 
insert into passwords (password) values ('nay'); 
insert into passwords (password) values ('neb'); 
insert into passwords (password) values ('nee'); 
insert into passwords (password) values ('neg'); 
insert into passwords (password) values ('net'); 
insert into passwords (password) values ('new'); 
insert into passwords (password) values ('nib'); 
insert into passwords (password) values ('nil'); 
insert into passwords (password) values ('nim'); 
insert into passwords (password) values ('nip'); 
insert into passwords (password) values ('nit'); 
insert into passwords (password) values ('nix'); 
insert into passwords (password) values ('nob'); 
insert into passwords (password) values ('nod'); 
insert into passwords (password) values ('nog'); 
insert into passwords (password) values ('nom'); 
insert into passwords (password) values ('noo'); 
insert into passwords (password) values ('nor'); 
insert into passwords (password) values ('nos'); 
insert into passwords (password) values ('not'); 
insert into passwords (password) values ('now'); 
insert into passwords (password) values ('nub'); 
insert into passwords (password) values ('nun'); 
insert into passwords (password) values ('nut'); 

insert into passwords (password) values ('oaf'); 
insert into passwords (password) values ('oak'); 
insert into passwords (password) values ('oar'); 
insert into passwords (password) values ('oat'); 
insert into passwords (password) values ('obe'); 
insert into passwords (password) values ('odd'); 
insert into passwords (password) values ('off'); 
insert into passwords (password) values ('oil'); 
insert into passwords (password) values ('old'); 
insert into passwords (password) values ('one'); 
insert into passwords (password) values ('ono'); 
insert into passwords (password) values ('opt'); 
insert into passwords (password) values ('orc'); 
insert into passwords (password) values ('ore'); 
insert into passwords (password) values ('our'); 
insert into passwords (password) values ('out'); 
insert into passwords (password) values ('owe'); 
insert into passwords (password) values ('owl'); 
insert into passwords (password) values ('own'); 
insert into passwords (password) values ('oxy'); 

insert into passwords (password) values ('pac'); 
insert into passwords (password) values ('pad'); 
insert into passwords (password) values ('pal'); 
insert into passwords (password) values ('pam'); 
insert into passwords (password) values ('pan'); 
insert into passwords (password) values ('pap'); 
insert into passwords (password) values ('par'); 
insert into passwords (password) values ('pas'); 
insert into passwords (password) values ('pat'); 
insert into passwords (password) values ('paw'); 
insert into passwords (password) values ('pax'); 
insert into passwords (password) values ('pay'); 
insert into passwords (password) values ('pec'); 
insert into passwords (password) values ('ped'); 
insert into passwords (password) values ('peg'); 
insert into passwords (password) values ('pen'); 
insert into passwords (password) values ('pep'); 
insert into passwords (password) values ('per'); 
insert into passwords (password) values ('pes'); 
insert into passwords (password) values ('pet'); 
insert into passwords (password) values ('pew'); 
insert into passwords (password) values ('pic'); 
insert into passwords (password) values ('pie'); 
insert into passwords (password) values ('pig'); 
insert into passwords (password) values ('pin'); 
insert into passwords (password) values ('pip'); 
insert into passwords (password) values ('pit'); 
insert into passwords (password) values ('ply'); 
insert into passwords (password) values ('pod'); 
insert into passwords (password) values ('pol'); 
insert into passwords (password) values ('pom'); 
insert into passwords (password) values ('pop'); 
insert into passwords (password) values ('pot'); 
insert into passwords (password) values ('pow'); 
insert into passwords (password) values ('pox'); 
insert into passwords (password) values ('pro'); 
insert into passwords (password) values ('pry'); 
insert into passwords (password) values ('pug'); 
insert into passwords (password) values ('pun'); 
insert into passwords (password) values ('pup'); 
insert into passwords (password) values ('pur'); 
insert into passwords (password) values ('put'); 

insert into passwords (password) values ('rad'); 
insert into passwords (password) values ('rag'); 
insert into passwords (password) values ('rah'); 
insert into passwords (password) values ('raj'); 
insert into passwords (password) values ('ram'); 
insert into passwords (password) values ('ran'); 
insert into passwords (password) values ('rap'); 
insert into passwords (password) values ('rat'); 
insert into passwords (password) values ('raw'); 
insert into passwords (password) values ('rax'); 
insert into passwords (password) values ('ray'); 
insert into passwords (password) values ('reb'); 
insert into passwords (password) values ('rec'); 
insert into passwords (password) values ('red'); 
insert into passwords (password) values ('ref'); 
insert into passwords (password) values ('reg'); 
insert into passwords (password) values ('rem'); 
insert into passwords (password) values ('rep'); 
insert into passwords (password) values ('res'); 
insert into passwords (password) values ('ret'); 
insert into passwords (password) values ('rev'); 
insert into passwords (password) values ('rex'); 
insert into passwords (password) values ('rib'); 
insert into passwords (password) values ('rid'); 
insert into passwords (password) values ('rif'); 
insert into passwords (password) values ('rig'); 
insert into passwords (password) values ('rim'); 
insert into passwords (password) values ('rin'); 
insert into passwords (password) values ('rip'); 
insert into passwords (password) values ('rob'); 
insert into passwords (password) values ('roc'); 
insert into passwords (password) values ('rod'); 
insert into passwords (password) values ('rom'); 
insert into passwords (password) values ('rot'); 
insert into passwords (password) values ('row'); 
insert into passwords (password) values ('rub'); 
insert into passwords (password) values ('rue'); 
insert into passwords (password) values ('rug'); 
insert into passwords (password) values ('run'); 
insert into passwords (password) values ('rut'); 
insert into passwords (password) values ('rye'); 

insert into passwords (password) values ('sab'); 
insert into passwords (password) values ('sac'); 
insert into passwords (password) values ('sad'); 
insert into passwords (password) values ('sag'); 
insert into passwords (password) values ('sal'); 
insert into passwords (password) values ('sap'); 
insert into passwords (password) values ('sat'); 
insert into passwords (password) values ('saw'); 
insert into passwords (password) values ('sax'); 
insert into passwords (password) values ('say'); 
insert into passwords (password) values ('sea'); 
insert into passwords (password) values ('sec'); 
insert into passwords (password) values ('see'); 
insert into passwords (password) values ('set'); 
insert into passwords (password) values ('sew'); 
insert into passwords (password) values ('she'); 
insert into passwords (password) values ('shy'); 
insert into passwords (password) values ('sib'); 
insert into passwords (password) values ('sic'); 
insert into passwords (password) values ('sim'); 
insert into passwords (password) values ('sin'); 
insert into passwords (password) values ('sip'); 
insert into passwords (password) values ('sir'); 
insert into passwords (password) values ('sis'); 
insert into passwords (password) values ('sit'); 
insert into passwords (password) values ('six'); 
insert into passwords (password) values ('ska'); 
insert into passwords (password) values ('ski'); 
insert into passwords (password) values ('sky'); 
insert into passwords (password) values ('sly'); 
insert into passwords (password) values ('sob'); 
insert into passwords (password) values ('sod'); 
insert into passwords (password) values ('sol'); 
insert into passwords (password) values ('son'); 
insert into passwords (password) values ('sop'); 
insert into passwords (password) values ('sos'); 
insert into passwords (password) values ('sow'); 
insert into passwords (password) values ('sox'); 
insert into passwords (password) values ('soy'); 
insert into passwords (password) values ('spa'); 
insert into passwords (password) values ('spy'); 
insert into passwords (password) values ('sub'); 
insert into passwords (password) values ('sue'); 
insert into passwords (password) values ('sum'); 
insert into passwords (password) values ('sun'); 
insert into passwords (password) values ('sup'); 
insert into passwords (password) values ('syn'); 
insert into passwords (password) values ('tab'); 
insert into passwords (password) values ('tad'); 
insert into passwords (password) values ('tag'); 
insert into passwords (password) values ('taj'); 
insert into passwords (password) values ('tam'); 
insert into passwords (password) values ('tan'); 
insert into passwords (password) values ('tao'); 
insert into passwords (password) values ('tap'); 
insert into passwords (password) values ('tar'); 
insert into passwords (password) values ('tat'); 
insert into passwords (password) values ('taw'); 
insert into passwords (password) values ('tax'); 
insert into passwords (password) values ('tea'); 
insert into passwords (password) values ('ted'); 
insert into passwords (password) values ('tee'); 
insert into passwords (password) values ('teg'); 
insert into passwords (password) values ('tel'); 
insert into passwords (password) values ('ten'); 
insert into passwords (password) values ('the'); 
insert into passwords (password) values ('thy'); 
insert into passwords (password) values ('tic'); 
insert into passwords (password) values ('tie'); 
insert into passwords (password) values ('til'); 
insert into passwords (password) values ('tin'); 
insert into passwords (password) values ('tip'); 
insert into passwords (password) values ('tis'); 
insert into passwords (password) values ('tod'); 
insert into passwords (password) values ('toe'); 
insert into passwords (password) values ('tog'); 
insert into passwords (password) values ('tom'); 
insert into passwords (password) values ('ton'); 
insert into passwords (password) values ('too'); 
insert into passwords (password) values ('top'); 
insert into passwords (password) values ('tor'); 
insert into passwords (password) values ('tot'); 
insert into passwords (password) values ('tow'); 
insert into passwords (password) values ('toy'); 
insert into passwords (password) values ('try'); 
insert into passwords (password) values ('tub'); 
insert into passwords (password) values ('tug'); 
insert into passwords (password) values ('tun'); 
insert into passwords (password) values ('tup'); 
insert into passwords (password) values ('tut'); 
insert into passwords (password) values ('tux'); 
insert into passwords (password) values ('two'); 
insert into passwords (password) values ('tye'); 
insert into passwords (password) values ('ugh'); 
insert into passwords (password) values ('uke'); 
insert into passwords (password) values ('ulu'); 
insert into passwords (password) values ('umm'); 
insert into passwords (password) values ('ump'); 
insert into passwords (password) values ('upo'); 
insert into passwords (password) values ('use'); 
insert into passwords (password) values ('vac'); 
insert into passwords (password) values ('van'); 
insert into passwords (password) values ('var'); 
insert into passwords (password) values ('vas'); 
insert into passwords (password) values ('vat'); 
insert into passwords (password) values ('veg'); 
insert into passwords (password) values ('vet'); 
insert into passwords (password) values ('vex'); 
insert into passwords (password) values ('via'); 
insert into passwords (password) values ('vid'); 
insert into passwords (password) values ('vie'); 
insert into passwords (password) values ('vim'); 
insert into passwords (password) values ('vis'); 
insert into passwords (password) values ('voe'); 
insert into passwords (password) values ('vow'); 
insert into passwords (password) values ('vox'); 
insert into passwords (password) values ('vug'); 
insert into passwords (password) values ('vum'); 
insert into passwords (password) values ('wab'); 
insert into passwords (password) values ('wad'); 
insert into passwords (password) values ('wag'); 
insert into passwords (password) values ('wan'); 
insert into passwords (password) values ('wap'); 
insert into passwords (password) values ('war'); 
insert into passwords (password) values ('was'); 
insert into passwords (password) values ('wat'); 
insert into passwords (password) values ('wax'); 
insert into passwords (password) values ('way'); 
insert into passwords (password) values ('web'); 
insert into passwords (password) values ('wed'); 
insert into passwords (password) values ('wee'); 
insert into passwords (password) values ('wet'); 
insert into passwords (password) values ('wha'); 
insert into passwords (password) values ('who'); 
insert into passwords (password) values ('why'); 
insert into passwords (password) values ('wig'); 
insert into passwords (password) values ('win'); 
insert into passwords (password) values ('wis'); 
insert into passwords (password) values ('wit'); 
insert into passwords (password) values ('wiz'); 
insert into passwords (password) values ('woe'); 
insert into passwords (password) values ('wok'); 
insert into passwords (password) values ('won'); 
insert into passwords (password) values ('woo'); 
insert into passwords (password) values ('wot'); 
insert into passwords (password) values ('wow'); 
insert into passwords (password) values ('wry'); 
insert into passwords (password) values ('wud'); 
insert into passwords (password) values ('wyn'); 
insert into passwords (password) values ('yag'); 
insert into passwords (password) values ('yah'); 
insert into passwords (password) values ('yak'); 
insert into passwords (password) values ('yam'); 
insert into passwords (password) values ('yap'); 
insert into passwords (password) values ('yar'); 
insert into passwords (password) values ('yaw'); 
insert into passwords (password) values ('yay'); 
insert into passwords (password) values ('yea'); 
insert into passwords (password) values ('yen'); 
insert into passwords (password) values ('yep'); 
insert into passwords (password) values ('yes'); 
insert into passwords (password) values ('yet'); 
insert into passwords (password) values ('yew'); 
insert into passwords (password) values ('yin'); 
insert into passwords (password) values ('yip'); 
insert into passwords (password) values ('yob'); 
insert into passwords (password) values ('yok'); 
insert into passwords (password) values ('yom'); 
insert into passwords (password) values ('yon'); 
insert into passwords (password) values ('you'); 
insert into passwords (password) values ('yow'); 
insert into passwords (password) values ('yuk'); 
insert into passwords (password) values ('yum'); 
insert into passwords (password) values ('yup'); 
insert into passwords (password) values ('zag'); 
insert into passwords (password) values ('zap'); 
insert into passwords (password) values ('zas'); 
insert into passwords (password) values ('zax'); 
insert into passwords (password) values ('zed'); 
insert into passwords (password) values ('zee'); 
insert into passwords (password) values ('zek'); 
insert into passwords (password) values ('zep'); 
insert into passwords (password) values ('zig'); 
insert into passwords (password) values ('zin'); 
insert into passwords (password) values ('zip'); 
insert into passwords (password) values ('zoa'); 
insert into passwords (password) values ('zuz'); 
insert into passwords (password) values ('zzz'); 
*/
--------------------REVOKE AND GRANT---------------------------------------
REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;

--
-- PostgreSQL database dump complete
--

