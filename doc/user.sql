create table USER(
	id not null auto_increment,
	pseudo varchar(30),
	mail varchar(30),
	pass varchar(255),
	droit int(1),
	jeton int(1),
	primary key id
)