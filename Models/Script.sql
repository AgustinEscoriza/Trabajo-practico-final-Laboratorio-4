create database MoviePass;
use MoviePass;
drop database MoviePass;

CREATE TABLE cinemas(
	idCinema int AUTO_INCREMENT NOT NULL,
    name varchar(50),
    adress varchar(50),
    CONSTRAINT pkIdCinema PRIMARY KEY (idCinema)
)ENGINE=InnoDB;

CREATE TABLE Billboard(
	idBillboard int auto_increment not null,
    idCinema int not null,
    constraint pkidBillboard primary key (idBillboard),
    CONSTRAINT fkBillboard_Cinemas foreign key (idCinema) REFERENCES cinemas(idCinema)
)ENGINE=InnoDB;

CREATE TABLE auditoriums(
	idAuditorium int auto_increment not null,
    idCinema int not null,
    name varchar(50),
    capacity int,
    ticketValue float,
    constraint pkIdAuditorium primary key (idAuditorium),
    constraint fkIdCinema foreign key (idCinema) references cinemas(idCinema)
)ENGINE=InnoDB;

CREATE TABLE movies(
	idMovie int not null,
    title varchar(500),
	originalTitle varchar(500),
    originalLanguage varchar(50),
    overview varchar(7500),
    posterPath varchar(50),
    releaseDate date,
    runtime int,
    
    constraint pkIdMovie primary key (idMovie)
)ENGINE=InnoDB;

CREATE TABLE Functions(
	idFunction int auto_increment not null,
    idCinema int not null,
    idAuditorium int not null,
    idMovie int not null,
    functionDate date not null,
    functionTime time not null,
    constraint pkidFunction primary key (idFunction),
    CONSTRAINT fkFunction_Cinemas foreign key (idCinema) REFERENCES cinemas(idCinema),
    CONSTRAINT fkFunction_Auditorium foreign key (idAuditorium) REFERENCES auditoriums(idAuditorium),
    CONSTRAINT fkFunction_Movie foreign key (idMovie) REFERENCES movies(idMovie)
)ENGINE=InnoDB;

CREATE TABLE genres(
	idGenre int not null,
    name varchar(50) not null,
    constraint pkIdGenre primary key (idGenre)
)ENGINE=InnoDB;

CREATE TABLE languages(
	idLanguage int not null,
    iso_639_1 varchar(50),
    name varchar(50),
    constraint pkIdLanguages primary key (idLanguage)
)ENGINE=InnoDB;

CREATE TABLE moviesXGenre(
	idMoviesXGenre int not null auto_increment,
	idMovie int not null,
	idGenre int not null,
    constraint pkIdMoviesXGenre primary key (idMoviesXGenre),
    constraint fkIdMovieXGenreMovie foreign key (idMovie) references movies(idMovie),
    constraint fkIdMovieXGenreGenre foreign key (idGenre) references genres(idGenre)
)ENGINE=InnoDB;

CREATE TABLE languagesXMovie(
	idLanguagesXMovie int not null auto_increment,
    idMovie int not null,
    idLanguage int not null,
    constraint pkIdLanguagesXMovie primary key (idLanguagesXMovie),
    constraint fkLanguagesXMovieIdMovie foreign key (idMovie) references movies(idMovie),
    constraint fkLanguagesXMovieIdLanguage foreign key (idLanguage) references languages(idLanguage)
)ENGINE=InnoDB;

CREATE TABLE users(
	idUser int AUTO_INCREMENT NOT NULL,
    userName varchar(50),
    userEmail varchar(100),
    userPassword varchar(50),
    userState int NOT NULL,
    CONSTRAINT pkIdUser PRIMARY KEY (idUser)
)ENGINE=InnoDB;

select * from Functions;

alter table users add column fbAccesToken varchar(100);
alter table users add column fbId varchar(100);


INSERT INTO users (userName,userEmail,userPassword,userState) VALUES
('admin','admin@amin.com','123456','1');

INSERT INTO cinemas (name,adress) VALUES
('Ambassador','Cordoba 1552'),
('Cines del Paseo','Belgrano 2955'),
('Aldrey','Las Heras 2551');

INSERT INTO auditoriums (idCinema,name,capacity,ticketValue) VALUES
('1','Sala Bolt','100','150'),
('1','Sala Silio','209','180'),
('2','Sala Kipchoge','159','210'),
('2','Sala Borelli','110','195'),
('3','Sala Casetta','92','170'),
('3','Sala Luna','116','250');