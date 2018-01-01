drop table userAccounts;
create table userAccounts (
	userID varchar(100) not null,
	userPW varchar(100) not null,
	userImage varchar(100) not null,
	constraint userID_pk
        primary key (userID)
	);

