DROP DATABASE IF EXISTS mycoopt;

CREATE DATABASE IF NOT EXISTS mycoopt
    DEFAULT CHARSET utf8;

CREATE TABLE IF NOT EXISTS mycoopt.statuts (
    id SMALLINT NOT NULL AUTO_INCREMENT,
    rh VARCHAR(50),
    cooptant TEXT,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS mycoopt.jobs (
    id SMALLINT NOT NULL AUTO_INCREMENT,
    name VARCHAR(10),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS mycoopt.agences (
    id SMALLINT NOT NULL AUTO_INCREMENT,
    name VARCHAR(25),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS mycoopt.roles (
    id SMALLINT  NOT NULL AUTO_INCREMENT,
    name VARCHAR(25),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS mycoopt.cooptants (
    id SMALLINT  NOT NULL AUTO_INCREMENT,
    login VARCHAR(25),
    pwd VARCHAR(25),
    lname VARCHAR(25),
    fname VARCHAR(25),
    agence SMALLINT,
    mail VARCHAR(50),
    picture VARCHAR(50),
    exp SMALLINT,
    role SMALLINT,
    PRIMARY KEY (id),
    FOREIGN KEY (role) REFERENCES mycoopt.roles(id),
    FOREIGN KEY (agence) REFERENCES mycoopt.agences(id)
);

CREATE TABLE IF NOT EXISTS mycoopt.cooptes (
    id SMALLINT NOT NULL AUTO_INCREMENT,
    lname VARCHAR(25),
    fname VARCHAR(25),
    genre CHAR,
    commend TEXT, 
    student BOOLEAN, 
    origin TEXT, 
    fromm TEXT,
    job SMALLINT,
    creation_date TIMESTAMP,
    cooptant SMALLINT,
    statut SMALLINT,
    cv VARCHAR(50),
    rh TINYINT(1),
    PRIMARY KEY (id),
    FOREIGN KEY (cooptant) REFERENCES mycoopt.cooptants(id),
    FOREIGN KEY (statut) REFERENCES mycoopt.statuts(id),
    FOREIGN KEY (job) REFERENCES mycoopt.jobs(id)
);

CREATE TABLE IF NOT EXISTS mycoopt.notifs (
    cooptant SMALLINT,
    notif TEXT,
    exp INT,
    FOREIGN KEY (cooptant) REFERENCES mycoopt.cooptants(id)
);

INSERT INTO mycoopt.statuts (id, rh, cooptant)
VALUES
    (1, "En attente", "En attente de traitement"),
    (2, "CV NOK", "Keep on trying ton coopte©s # ne correspond pas tout a fait a nos e√©tiers. Ne perds pqs espoir ce sera pour une prochaine fois"),
    (3, "CV OK", "Ton coopte© # corresponda notre cible, nous l'appelons dans les meilleurs de©lais !"),
    (4, "EC1", "Bonne nouvelle ! Ton coopte© # a rendez-vous prochainement dans nos locaux pour un entretien."),
    (5, "EC2", "Bonne nouvelle ! Ton coopte© # a rendez-vous prochainement dans nos locaux pour un deuxi√®me entretien."),
    (6, "EP", "Nous avons envie de travailler avec ton coopte© # et mettons tout en oeuvre pour lui trouver un projet correspondanta ses attentes."),
    (7, "ED", "Nous avons envie de travailler avec ton coopte© # et un processus de recrutement sur profil est en court."),
    (8, "Embauche", "F√©licitations ! Ton coopt√© # va bient√¥t rejoindre nos √©quipes ;)"),
    (9, "Entre©e", "e√©licitations ! Ton cooet√© # fait partie de nes √©quipes :)"),
    (10, "Validation de pe©riode d'essai", "Jackpot ! Ton coope√© # a valed√© se p√©riode d'essai et tu vas donc prochainement recevoir une prime de euro brut.");

INSERT INTO mycoopt.jobs (id, name)
VALUES
    (1, "NONE"),
    (2, "SI"),
    (3, "TELCO"),
    (4, "WEB"),
    (5, "INDUS"),
    (6, "BFA"),
    (7, "SUPPORT");
    
INSERT INTO mycoopt.agences (id, name)
VALUES
    (1, "CGA"),
    (2, "BCH"),
    (3, "BRE"),
    (4, "RHA"),
    (5, "NPC"),
    (6, "BXL"),
    (7, "PACA"),
    (8, "SUISSE"),
    (9, "INTERNE");

INSERT INTO mycoopt.roles (id, name)
VALUES
    (1, "Admin"),
    (2, "RH"),
    (3, "Cooptant");

INSERT INTO mycoopt.cooptants (id, login, pwd, lname, fname, agence, mail, picture, exp, role)
VALUES
    (1, "Cgraux", "123", "Graux", "Camille", 9, "do_s@etna-alternance.net", "../asset/img/avatar.png", 900, 2),
    (2, "Lurquijo", "123", "Urquijo", "Lucille", 9, "driss_m@etna-alternance.net", "../asset/img/avatar.png", 900, 1),
    (3, "Blaureau", "123", "Laureau", "Baptiste", 9, "lauren_b@etna-alternance.net", "../asset/img/avatar.png", 100, 3),
    (4, "Fschrie", "123", "Schriever", "Flavien", 9, "lauren_b@etna-alternance.net", "../asset/img/avatar.png", 100, 3);
