create table rrhh_announcements(
	id 				bigint not null auto_increment primary key,
	code			varchar(64) unique,
	name			varchar(256),
	description		text,
	vacancies		int,
	status			varchar(64),
	start_date		date,
	end_date		date,
	total_score		int,
	min_points		int,
	data			text,
	selected		text,
	creation_date	datetime
);
create table	rrhh_person(
	id						bigint not null auto_increment primary key,
	user_id					bigint,
	first_name				varchar(128),
	fathers_lastname		varchar(64),
	mothers_lastname		varchar(64),
	document_type			varchar(32),
	document				varchar(32),
	document_from			varchar(16),
	birthday				date,
	city_birth				varchar(64),
	country_birth			varchar(64),
	current_city			varchar(64),
	current_country			varchar(32),
	telephone				varchar(32),
	mobile					varchar(32),
	email					varchar(64),
	address_1				varchar(128),
	address_2				varchar(128),
	address_zone			varchar(128),
	last_modification_date	datetime,
	creation_date			datetime
);
create table rrhh_person_meta(
	id		bigint not null auto_increment primary key,
	person_id	bigint not null,
	meta_key	varchar(128),
	meta_value	text,
	creation_date	datetime
);
create table rrhh_announcement2person(
	id 							bigint not null auto_increment primary key,
	announcement_id				bigint not null,
	person_id					bigint not null,
	salary_pretension			decimal(10,2),
	inmediate_availability		varchar(16),
	days						int,
	specific_experience			text,			
	general_experience			text,
	data						text,
	creation_date				datetime
);
create table if not exists rrhh_degree_levels(
	id						bigint not null auto_increment primary key,
	name					varchar(128),
	creation_date			datetime
);
create table if not exists rrhh_academic_records(
	id						bigint not null auto_increment primary key,
	person_id				bigint not null,
	study_level_id			bigint	not null,
	center_name				varchar(256),
	degree					varchar(256),
	degree_date				date,
	degree_city				varchar(64),
	degree_country_code		varchar(3),
	degree_country			varchar(64),
	creation_date			datetime
);
create table rrhh_experience(
	id						bigint not null auto_increment primary key,
	person_id				bigint not null,
	company					varchar(128),
	company_phone			varchar(32),
	position				varchar(128),
	company_industry		varchar(128),
	dependent				int,
	main_functions			text,
	start_date				date,
	end_date				date,
	decouplin_reason		text,
	superior_name			varchar(256),
	superior_position		varchar(256),
	currently_working		tinyint(2),
	creation_date			datetime
);
create table if not exists rrhh_skills(
	id						bigint not null auto_increment primary key,
	person_id				bigint not null,
	name					text,
	level					int,
	creation_date			datetime
);
create table if not exists rrhh_study_levels(
	id						bigint not null auto_increment primary key,
	name					varchar(128),
	creation_date			datetime		
);
create table if not exists rrhh_references(
	id						bigint not null auto_increment primary key,
	person_id				bigint not null,
	name					varchar(128),
	company					varchar(128),
	position				varchar(128),
	relationship			varchar(64),
	telephone				varchar(64),
	cell_phone				varchar(64),
	email					varchar(64),
	type					varchar(32),
	creation_date			datetime
);
