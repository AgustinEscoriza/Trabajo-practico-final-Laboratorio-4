create database MoviePass;
use MoviePass;
drop database MoviePass;

CREATE TABLE cinemas(
	idCinema int AUTO_INCREMENT NOT NULL,
    name varchar(50),
    adress varchar(50),
    cinemaStatus int not null,
    CONSTRAINT pkIdCinema PRIMARY KEY (idCinema)
)ENGINE=InnoDB;

CREATE TABLE auditoriums(
	idAuditorium int auto_increment not null,
    idCinema int not null,
    name varchar(50),
    capacity int,
    ticketValue float,
    auditoriumStatus int not null,
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
    movieStatus int not null,
    
    constraint pkIdMovie primary key (idMovie)
)ENGINE=InnoDB;

CREATE TABLE Functions(
	idFunction int auto_increment not null,
    idCinema int not null,
    idAuditorium int not null,
    idMovie int not null,
    functionDate date not null,
    functionTime time not null,
    functionStatus int not null,
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

CREATE TABLE roles(
	idRole int AUTO_INCREMENT NOT NULL,
    roleName varchar(50),
    CONSTRAINT pkIdRole PRIMARY KEY (idRole)
)ENGINE=InnoDB;


CREATE TABLE users(
	idUser int AUTO_INCREMENT NOT NULL,
    idRole int NOT NULL,
    userName varchar(50),
    userEmail varchar(100),
    userPassword varchar(50),
    userState int NOT NULL,
    fbId int,
    fbAccesToken int,
    CONSTRAINT pkIdUser PRIMARY KEY (idUser),
    CONSTRAINT fkIdRole FOREIGN KEY (idRole) references roles (idRole)
)ENGINE=InnoDB;

CREATE TABLE tickets(
    idTicket int not null auto_increment,
    idFunction int not null,
    idUser int not null,
    quantity int,
    price float,
    ticketStatus int not null,
    constraint pkIdTicket primary key(idTicket),
    constraint fkTicketIdFunction foreign key (idFunction) references functions(idFunction),
    constraint fkTicketIdUser foreign key (idUser) references users(idUser)
)ENGINE=InnoDB;

select * from Functions where functionDate = '2020-11-11' and idAuditorium=3 order by functionTime desc limit 1;
select * from Functions where functionDate like '%18'  order by functionTime desc limit 1;
select * from Functions;


INSERT INTO cinemas (name,adress, cinemaStatus) VALUES
('Ambassador','Cordoba 1552',1),
('Cines del Paseo','Belgrano 2955',1),
('Aldrey','Las Heras 2551',1);

INSERT INTO auditoriums (idCinema,name,capacity,ticketValue,auditoriumStatus) VALUES
('1','Sala Bolt','100','150',1),
('1','Sala Silio','209','180',1),
('2','Sala Kipchoge','159','210',1),
('2','Sala Borelli','110','195',1),
('3','Sala Casetta','92','170',1),
('3','Sala Luna','116','250',1);

INSERT INTO roles (idRole,roleName) VALUES 
(1,'admin'),(2,'user'),(3,'guest');

INSERT INTO users (idUser,idRole,userName,userEmail,userPassword,userState) VALUES 
('1','1','admin','admin@gmail.com','123456','1');
