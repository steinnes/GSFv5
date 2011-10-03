create table users
(
	user_id serial not null primary key,
	username varchar(32) not null unique,
	password varchar(32) not null
);

create table messages
(
	msg_id serial not null primary key,
	user_id integer not null references users on delete cascade on update cascade,
	timestamp timestamp not null,
	message varchar(140) not null
);

create table follows
(
	user_id integer not null references users on delete cascade on update cascade,
	following integer not null references users on delete cascade on update cascade,
	primary key(user_id,following)
);

