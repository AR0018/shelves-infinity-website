-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Sat Jan 25 10:59:52 2025 
-- * LUN file: C:\xampp\htdocs\shelves-infinity-website\Database\Tecnologie_Web_DB.lun 
-- * Schema: Schema_finale/SQL 
-- ********************************************* 


-- Database Section
-- ________________ 

create database Schema_finale;
use Schema_finale;


-- Tables Section
-- _____________ 

create table Appartenenze_generi (
     codProdotto int not null,
     genere varchar(100) not null,
     constraint ID_Appartenenze_generi_ID primary key (genere, codProdotto));

create table Carrello (
     codProdotto int not null,
     codCliente int not null,
     quantita int not null,
     constraint ID_Carrello_ID primary key (codProdotto, codCliente));

create table CATEGORIE (
     nome varchar(50) not null,
     constraint ID_CATEGORIE_ID primary key (nome));

create table Composizioni (
     codProdotto int not null,
     codOrdine int not null,
     quantita int not null,
     constraint ID_Composizioni_ID primary key (codProdotto, codOrdine));

create table GENERI (
     nome varchar(100) not null,
     constraint ID_GENERI_ID primary key (nome));

create table NOTIFICHE (
     codNotifica int not null,
     messaggio varchar(300) not null,
     data date not null,
     letta char not null,
     codUtente int not null,
     constraint ID_NOTIFICHE_ID primary key (codNotifica));

create table ORDINI (
     codOrdine int not null,
     data date not null,
     indirizzo_di_spedizione varchar(100) not null,
     prezzo_totale float(8) not null,
     stato_spedizione varchar(50) not null,
     codCliente int not null,
     constraint ID_ORDINI_ID primary key (codOrdine));

create table Preferiti (
     codProdotto int not null,
     codCliente int not null,
     constraint ID_Preferiti_ID primary key (codCliente, codProdotto));

create table PRODOTTI (
     codProdotto int not null,
     nome varchar(100) not null,
     immagine varchar(500) not null,
     descrizione varchar(4000) not null,
     prezzo float(8) not null,
     quantita_disponibile int not null,
     opera_di_appartenenza varchar(200) not null,
     altezza float(6) not null,
     larghezza float(6) not null,
     profondita float(6) not null,
     data_inserimento date not null,
     punteggio_medio float(2),
     codVenditore int not null,
     categoria varchar(50) not null,
     constraint ID_PRODOTTI_ID primary key (codProdotto));

create table Recensioni (
     codProdotto int not null,
     codCliente int not null,
     punteggio int not null,
     descrizione varchar(4000),
     data date not null,
     constraint ID_Recensioni_ID primary key (codProdotto, codCliente));

create table UTENTI (
     codUtente int not null,
     username varchar(50) not null,
     email varchar(100) not null,
     password varchar(500) not null,
     venditore char not null,
     constraint ID_UTENTI_ID primary key (codUtente),
     constraint SID_UTENTI_1_ID unique (username),
     constraint SID_UTENTI_ID unique (email));


-- Constraints Section
-- ___________________ 

alter table Appartenenze_generi add constraint REF_Appar_GENER
     foreign key (genere)
     references GENERI (nome);

alter table Appartenenze_generi add constraint EQU_Appar_PRODO_FK
     foreign key (codProdotto)
     references PRODOTTI (codProdotto);

alter table Carrello add constraint REF_Carre_UTENT_FK
     foreign key (codCliente)
     references UTENTI (codUtente);

alter table Carrello add constraint REF_Carre_PRODO
     foreign key (codProdotto)
     references PRODOTTI (codProdotto);

alter table Composizioni add constraint REF_Compo_ORDIN_FK
     foreign key (codOrdine)
     references ORDINI (codOrdine);

alter table Composizioni add constraint REF_Compo_PRODO
     foreign key (codProdotto)
     references PRODOTTI (codProdotto);

alter table NOTIFICHE add constraint REF_NOTIF_UTENT_FK
     foreign key (codUtente)
     references UTENTI (codUtente);

alter table ORDINI add constraint REF_ORDIN_UTENT_FK
     foreign key (codCliente)
     references UTENTI (codUtente);

alter table Preferiti add constraint REF_Prefe_UTENT
     foreign key (codCliente)
     references UTENTI (codUtente);

alter table Preferiti add constraint REF_Prefe_PRODO_FK
     foreign key (codProdotto)
     references PRODOTTI (codProdotto);

-- Not implemented
-- alter table PRODOTTI add constraint ID_PRODOTTI_CHK
--     check(exists(select * from Appartenenze_generi
--                  where Appartenenze_generi.codProdotto = codProdotto)); 

alter table PRODOTTI add constraint REF_PRODO_UTENT_FK
     foreign key (codVenditore)
     references UTENTI (codUtente);

alter table PRODOTTI add constraint REF_PRODO_CATEG_FK
     foreign key (categoria)
     references CATEGORIE (nome);

alter table Recensioni add constraint REF_Recen_UTENT_FK
     foreign key (codCliente)
     references UTENTI (codUtente);

alter table Recensioni add constraint REF_Recen_PRODO
     foreign key (codProdotto)
     references PRODOTTI (codProdotto);


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

create unique index ID_NOTIFICHE_IND
     on NOTIFICHE (codNotifica);

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

create unique index SID_UTENTI_1_IND
     on UTENTI (username);

create unique index SID_UTENTI_IND
     on UTENTI (email);

