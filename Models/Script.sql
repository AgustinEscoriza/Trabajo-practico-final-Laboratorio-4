create database MoviePass;
use MoviePass;

CREATE TABLE cinemas(
	idCinema int AUTO_INCREMENT NOT NULL,
    name varchar(50),
    adress varchar(50),
    CONSTRAINT pkIdCinema PRIMARY KEY (idCinema)
)ENGINE=InnoDB DEFAULT CHARACTER SET = utf8;

CREATE TABLE users(
	idUser int AUTO_INCREMENT NOT NULL,
    userName varchar(50),
    userEmail varchar(100),
    userPassword varchar(50),
    userState int NOT NULL,
    CONSTRAINT pkIdUser PRIMARY KEY (idUser)
)ENGINE=InnoDB DEFAULT CHARACTER SET = utf8;

INSERT INTO users(idUser,userName,userEmail,userPassword,userState) 
VALUES (1,'Agus','agusescoriza@outlook.es','1234',1);

CREATE TABLE auditoriums(
	idAuditorium int auto_increment not null,
    idCinema int not null,
    name varchar(50),
    capacity int,
    ticketValue float,
    constraint pkIdAuditorium primary key (idAuditorium),
    constraint fkIdCinema foreign key (idCinema) references cinemas(idCinema)
)ENGINE=InnoDB DEFAULT CHARACTER SET = utf8;

CREATE TABLE movies(
	idMovie int not null,
    originalLanguage varchar(50),
    originalTitle varchar(50),
    overview varchar(700),
    posterPath varchar(50),
    releaseDate date,
    title varchar(100),
    runtime int,
    constraint pkIdMovie primary key (idMovie)
)ENGINE=InnoDB DEFAULT CHARACTER SET = utf8;

CREATE TABLE genres(
	idGenre int not null,
    name varchar(50) not null,
    constraint pkIdGenre primary key (idGenre)
)ENGINE=InnoDB DEFAULT CHARACTER SET = utf8;

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
)ENGINE=InnoDB DEFAULT CHARACTER SET = utf8;

CREATE TABLE moviesXGenre(
	idMoviesXGenre int not null auto_increment,
	idMovie int not null,
	idGenre int not null,
    constraint pkIdMoviesXGenre primary key (idMoviesXGenre),
    constraint fkIdMovieXGenreMovie foreign key (idMovie) references movies(idMovie),
    constraint fkIdMovieXGenreGenre foreign key (idGenre) references genres(idGenre)
)ENGINE=InnoDB DEFAULT CHARACTER SET = utf8;

CREATE TABLE languages(
	idLanguage int not null,
    iso_639_1 varchar(50),
    name varchar(50),
    constraint pkIdLanguages primary key (idLanguage)
)ENGINE=InnoDB DEFAULT CHARACTER SET = utf8;



CREATE TABLE languagesXMovie(
	idLanguagesXMovie int not null auto_increment,
    idMovie int not null,
    idLanguage int not null,
    constraint pkIdLanguagesXMovie primary key (idLanguagesXMovie),
    constraint fkLanguagesXMovieIdMovie foreign key (idMovie) references movies(idMovie),
    constraint fkLanguagesXMovieIdLanguage foreign key (idLanguage) references languages(idLanguage)
)ENGINE=InnoDB DEFAULT CHARACTER SET = utf8;

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

INSERT INTO Functions (idCinema,idAuditorium,idMovie,functionDate,functionTime) VALUES
(1,2,337401,"2020-10-10","19:30"),
(2,2,337401,"2020-10-11","19:30"),
(2,2,505379,"2020-10-10","19:30");