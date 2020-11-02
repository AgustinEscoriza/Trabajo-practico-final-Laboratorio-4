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
    constraint pkIdMovie primary key (idMovie)
)ENGINE=InnoDB DEFAULT CHARACTER SET = utf8;

CREATE TABLE genres(
	idGenre int not null,
    name varchar(50) not null,
    constraint pkIdGenre primary key (idGenre)
)ENGINE=InnoDB DEFAULT CHARACTER SET = utf8;

CREATE TABLE functions(
	idFunction int not null auto_increment,
    idAuditorium int not null,
    idMovie int not null,
    date date,
    tickets int,
    runtime time,
    constraint pkIdFunction primary key (idFunction),
    constraint fkFunctionIdAuditorium foreign key (idAuditorium) references auditoriums(idAuditorium),
    constraint fkFunctionIdMovie foreign key (idMovie) references movies(idMovies)
)ENGINE=InnoDB DEFAULT CHARACTER SET = utf8;

CREATE TABLE moviesXGenre(
	idMoviesXGenre int not null auto_increment,
	idMovie int not null,
	idGenre int not null,
    constraint pkIdMoviesXGenre primary key (idMoviesXGenre),
    constraint fkIdMovieXGenreMovie foreign key (idMovie) references movies(idMovie),
    constraint fkIdMovieXGenreGenre foreign key (idGenre) references genres(idGenre)
)ENGINE=InnoDB DEFAULT CHARACTER SET = utf8;

CREATE TABLE moviesXCinema(
	idMoviesXCinema int not null auto_increment,
    idMovie int not null,
    idCinema int not null,
    constraint pkIdMoviesXCinema primary key (idMoviesXCinema),
    constraint fkIdMoviesXCinema foreign key (idMovie) references movies(idMovie),
    constraint fkIdMoviesXCinema foreign key (idCinema) references cinemas(idCinema)
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
