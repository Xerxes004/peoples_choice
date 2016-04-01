

drop table writeIn;
drop table vote;
drop table team;
drop table implementation;
drop table project;
drop table student;
create database app;
use app;
create table student(
	username varchar(32) primary key,
	realName varchar(32) not null,
	pwHash varchar(64) not null
);


create table project(
	name varchar(32) primary key,
	status varchar(7) check(status in ("open", "closed", "pending"))
);

create table implementation(
	implementationID int primary key,
	implementationName varchar(32)
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

insert into student values("sabol", "Joel Sabol", "password");
insert into student values("kelly", "Wesley Kelly", "password");
insert into student values("gallagd", "Dr. Gallagher", "password");

insert into implementation values(1, "Joel's project");
insert into implementation values(2, "Wes's Project");
insert into implementation values(3, "G's Project");

insert into team values("sabol", "Project1", 1);
insert into team values("kelly", "Project1", 2);
insert into team values("gallagd", "Project1", 3);

insert into vote values("kelly", "Project1", 2, 1);
insert into vote values("gallagd", "Project1", 3, 2);
insert into vote values("sabol", "Project1", 3, 2);

select username, sum(value) score
from vote
where projectName="Project1"
group by implementationID;

select count(*)
from vote
where value=2;