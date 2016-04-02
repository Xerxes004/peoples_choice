

drop table writeIn;
drop table vote;
drop table team;
drop table implementation;
drop table project;
drop table admin;
drop table student;

create table student(
	username varchar(32) primary key,
	realName varchar(32) not null,
	pwHash varchar(64) not null
);

create table admin(
	username varchar(32) primary key,
	foreign key (username) references student(username)
);


create table project(
	name varchar(32) primary key,
	status varchar(7) check(status in ("open", "closed", "pending"))
);

create table implementation(
	implementationID int primary key
);

create table team(
	username varchar(32),
	projectName varchar(32),
	implementationID int,
	primary key(username, projectName, implementationID),
	foreign key (username) references student(username),
	foreign key (projectName) references project(name),
	foreign key (implementationID) references implementation(implementationID)
);

create table vote(
	username varchar(32),
	projectName varchar(32),
	implementationID int,
	value numeric(1) check(value > 0 and value <= 3),
	primary key(username, projectName, implementationID),
	foreign key (username) references student(username),
	foreign key (projectName) references project(name),
	foreign key (implementationID) references implementation(implementationID)
);

create table writeIn(
	username varchar(32),
	projectName varchar(32),
	implementationID int,
	comment varchar(250) not null,
	primary key(username, projectName, implementationID),
	foreign key (username) references student(username),
	foreign key (projectName) references project(name),
	foreign key (implementationID) references implementation(implementationID)
);

insert into project values("Project1", "closed");
insert into project values("Project2", "closed");
insert into project values("Project3", "closed");

insert into student values("sabol", "Joel Sabol", "5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8");
insert into student values("kelly", "Wesley Kelly", "5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8");
insert into student values("gallagd", "Dr. Gallagher", "5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8");

insert into implementation values(1);
insert into implementation values(2);
insert into implementation values(3);
insert into implementation values(4);
insert into implementation values(5);

insert into team values("sabol", "Project1", 1);
insert into team values("kelly", "Project1", 2);
insert into team values("gallagd", "Project1", 3);
insert into team values("gallagd", "Project2", 4);
insert into team values("kelly", "Project2", 4);
insert into team values("kelly", "Project3", 5);
insert into team values("sabol", "Project3", 5);

insert into vote values("kelly", "Project1", 2, 1);
insert into vote values("gallagd", "Project1", 3, 2);
insert into vote values("sabol", "Project1", 3, 2);

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