

drop table writeIn;
drop table vote;
drop table team;
drop table implementation;
drop table project;
drop table admin;
drop table student;

create table wkjs_student(
	username varchar(32) primary key,
	realName varchar(32) not null,
	pwHash varchar(64) not null
);

create table wkjs_admin(
	username varchar(32) primary key,
	foreign key (username) references wkjs_student(username)
);


create table wkjs_project(
	name varchar(32) primary key,
	status varchar(7) check(status in ("open", "closed", "pending"))
);

create table wkjs_implementation(
	implementationID int primary key
);

create table wkjs_team(
	username varchar(32),
	projectName varchar(32),
	implementationID int,
	primary key(username, projectName, implementationID),
	foreign key (username) references wkjs_student(username),
	foreign key (projectName) references wkjs_project(name),
	foreign key (implementationID) references wkjs_implementation(implementationID)
);

create table wkjs_vote(
	username varchar(32),
	projectName varchar(32),
	implementationID int,
	value numeric(1) check(value > 0 and value <= 3),
	primary key(username, projectName, implementationID),
	foreign key (username) references wkjs_student(username),
	foreign key (projectName) references wkjs_project(name),
	foreign key (implementationID) references wkjs_implementation(implementationID)
);

create table wkjs_writeIn(
	projectName varchar(32) primary key,
	teamMembers: varchar(100),
	comment varchar(250) not null
);

insert into wkjs_project values("Project1", "closed");
insert into wkjs_project values("Project2", "closed");
insert into wkjs_project values("Project3", "closed");

insert into wkjs_student values("sabol", "Joel Sabol", "5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8");
insert into wkjs_student values("kelly", "Wesley Kelly", "5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8");
insert into wkjs_student values("gallagd", "Dr. Gallagher", "5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8");

insert into wkjs_implementation values(1);
insert into wkjs_implementation values(2);
insert into wkjs_implementation values(3);
insert into wkjs_implementation values(4);
insert into wkjs_implementation values(5);

insert into wkjs_team values("sabol", "Project1", 1);
insert into wkjs_team values("kelly", "Project1", 2);
insert into wkjs_team values("gallagd", "Project1", 3);
insert into wkjs_team values("gallagd", "Project2", 4);
insert into wkjs_team values("kelly", "Project2", 4);
insert into wkjs_team values("kelly", "Project3", 5);
insert into wkjs_team values("sabol", "Project3", 5);

insert into wkjs_vote values("kelly", "Project1", 2, 1);
insert into wkjs_vote values("gallagd", "Project1", 3, 2);
insert into wkjs_vote values("sabol", "Project1", 3, 2);

select username, sum(value) score
from vote
where projectName="Project1"
group by implementationID;

select distinct implementationID
from team
where projectName="Project3";

select *
from 
	(select count(value) bronze
	from vote
	where projectName='$project'
	and implementationID='$teamid'
	and value=1) t1,
	(select count(value) silver
	from vote
	where projectName='$project'
	and implementationID='$teamid'
	and value=2)t2,
	(select count(value) gold
	from vote
	where projectName='$project'
	and implementationID='$teamid'
	and value=3)t3,
	(select sum(value) total
	from vote
	where projectName='$project'
	and implementationID='$teamid')t4;

select count(*)
from vote
where value=2;