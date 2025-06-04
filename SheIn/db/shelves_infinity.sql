-- Database Section
-- ________________ 

create database if not exists shelves_infinity;

use shelves_infinity;

-- Tables Section
-- _____________ 

create table Appartenenze_generi (
     codProdotto int(10) not null,
     genere varchar(100) not null,
     constraint ID_Appartenenze_generi_ID primary key (genere, codProdotto));

create table Carrello (
     codProdotto int(10) not null,
     codCliente int(10) not null,
     quantita int(4) not null check(quantita > 0),
     constraint ID_Carrello_ID primary key (codProdotto, codCliente));

create table CATEGORIE (
     nome varchar(50) not null,
     constraint ID_CATEGORIE_ID primary key (nome));

create table UTENTI (
     codUtente int(10) not null auto_increment,
     username varchar(50) not null,
     email varchar(100) not null,
     password varchar(500) not null,
     venditore char not null check(venditore in(0, 1)),
     constraint ID_UTENTI_ID primary key (codUtente),
     constraint SID_USERNAME unique (username),
     constraint SID_EMAIL unique (email));

create table GENERI (
     nome varchar(100) not null,
     constraint ID_GENERI_ID primary key (nome));

create table Composizioni (
     codProdotto int(10) not null,
     codOrdine int(10) not null,
     quantita int not null check(quantita > 0),
     constraint ID_Composizioni_ID primary key (codProdotto, codOrdine));

create table NOTIFICHE (
     codNotifica int(10) not null auto_increment,
     messaggio varchar(300) not null,
     data datetime not null,
     letta char not null default 0 check(letta in(0, 1)),
     codUtente int(10) not null,
     constraint ID_NOTIFICHE_ID primary key (codNotifica));

create table ORDINI (
     codOrdine int(10) not null auto_increment,
     data date not null,
     indirizzo_di_spedizione varchar(100) not null,
     prezzo_totale float(8) not null check(prezzo_totale >= 0),
     stato_spedizione varchar(50) not null,
     codCliente int(10) not null,
     constraint ID_ORDINI_ID primary key (codOrdine));

create table Preferiti (
     codProdotto int(10) not null,
     codCliente int(10) not null,
     constraint ID_Preferiti_ID primary key (codCliente, codProdotto));

create table PRODOTTI (
     codProdotto int(10) not null auto_increment,
     nome varchar(100) not null,
     immagine varchar(500) not null,
     descrizione varchar(4000) not null,
     prezzo float(8) not null check(prezzo >= 0),
     quantita_disponibile int(8) not null check(quantita_disponibile >= 0),
     opera_di_appartenenza varchar(200) not null,
     altezza float(6) not null check(altezza >= 0),
     larghezza float(6) not null check(larghezza >= 0),
     profondita float(6) not null check(profondita >= 0),
     data_inserimento date not null,
     punteggio_medio float(2) check(punteggio_medio between 1.0 and 5.0),
     codVenditore int(10) not null,
     categoria varchar(50) not null,
     constraint ID_PRODOTTI_ID primary key (codProdotto));

create table Recensioni (
     codProdotto int(10) not null,
     codCliente int(10) not null,
     punteggio int(1) not null check(punteggio between 1 and 5),
     descrizione varchar(4000),
     data date not null,
     constraint ID_Recensioni_ID primary key (codProdotto, codCliente));

create table failedloginattempts (
     PHPSESSID varchar(26) not null,
     logtime varchar(30) not null,
     constraint ID_failedloginattempts_ID primary key (PHPSESSID, logtime));

-- Constraints Section
-- ___________________ 

alter table Appartenenze_generi add constraint appartenenze_ref_generi
     foreign key (genere)
     references GENERI(nome);

alter table Appartenenze_generi add constraint appartenenze_ref_prodotti
     foreign key (codProdotto)
     references PRODOTTI(codProdotto);

alter table Carrello add constraint carrello_ref_utenti
     foreign key (codCliente)
     references UTENTI(codUtente);

alter table Carrello add constraint carrello_ref_prodotti
     foreign key (codProdotto)
     references PRODOTTI(codProdotto);

alter table Composizioni add constraint composizioni_ref_ordini
     foreign key (codOrdine)
     references ORDINI(codOrdine);

alter table Composizioni add constraint composizioni_ref_prodotti
     foreign key (codProdotto)
     references PRODOTTI(codProdotto);

alter table NOTIFICHE add constraint notifiche_ref_utenti
     foreign key (codUtente)
     references UTENTI(codUtente);

alter table ORDINI add constraint ordini_ref_utenti
     foreign key (codCliente)
     references UTENTI(codUtente);

alter table Preferiti add constraint preferiti_ref_utenti
     foreign key (codCliente)
     references UTENTI(codUtente);

alter table Preferiti add constraint preferiti_ref_prodotti
     foreign key (codProdotto)
     references PRODOTTI(codProdotto);

alter table PRODOTTI add constraint prodotti_ref_utenti
     foreign key (codVenditore)
     references UTENTI(codUtente);

alter table PRODOTTI add constraint prodotti_ref_categorie
     foreign key (categoria)
     references CATEGORIE(nome);

alter table Recensioni add constraint recensioni_ref_utenti
     foreign key (codCliente)
     references UTENTI(codUtente);

alter table Recensioni add constraint recensioni_ref_prodotti
     foreign key (codProdotto)
     references PRODOTTI(codProdotto);
     
-- Index Section
-- _____________ 

create unique index ID_Appartenenze_generi_IND
     on Appartenenze_generi (genere, codProdotto);

create index EQU_Appar_PRODO_IND
     on Appartenenze_generi (codProdotto);

create unique index ID_Carrello_IND
     on Carrello (codProdotto, codCliente);

create index REF_Carre_UTENT_IND
     on Carrello (codCliente);

create unique index ID_CATEGORIE_IND
     on CATEGORIE (nome);

create unique index ID_Composizioni_IND
     on Composizioni (codProdotto, codOrdine);

create index REF_Compo_ORDIN_IND
     on Composizioni (codOrdine);

create unique index ID_GENERI_IND
     on GENERI (nome);

create index REF_NOTIF_UTENT_IND
     on NOTIFICHE (codUtente);

create unique index ID_ORDINI_IND
     on ORDINI (codOrdine);

create index REF_ORDIN_UTENT_IND
     on ORDINI (codCliente);

create unique index ID_Preferiti_IND
     on Preferiti (codCliente, codProdotto);

create index REF_Prefe_PRODO_IND
     on Preferiti (codProdotto);

create unique index ID_PRODOTTI_IND
     on PRODOTTI (codProdotto);

create index REF_PRODO_UTENT_IND
     on PRODOTTI (codVenditore);

create index REF_PRODO_CATEG_IND
     on PRODOTTI (categoria);

create unique index ID_Recensioni_IND
     on Recensioni (codProdotto, codCliente);

create index REF_Recen_UTENT_IND
     on Recensioni (codCliente);

create unique index ID_UTENTI_IND
     on UTENTI (codUtente);

create unique index SID_USERNAME_IND
     on UTENTI (username);

create unique index SID_EMAIL_IND
     on UTENTI (email);
