/* Categorie */
INSERT INTO `categorie` (`nome`) VALUES
('Anime'),
('Film'),
('Fumetti'),
('Serie TV'),
('Videogiochi');

/* Generi */
INSERT INTO `generi` (`nome`) VALUES
('Avventura'),
('Azione'),
('Commedia'),
('Fantascientifico'),
('Fantasy'),
('Horror'),
('Investigativo'),
('Thriller'),
('Western');

/* Utenti */
INSERT INTO `utenti` (`codUtente`, `username`, `email`, `password`, `venditore`) VALUES
(1, 'admin', 'shein.admin@prova.com', '$2y$10$25UGEQfzPs1JS6jHhQ634ejeHWgI01ALbeBOZ53Yt.Qe01lERB1O.', '1'), /* Passsword: admin */
(2, 'mario01', 'mario.rossi@prova.com', '$2y$10$LNgZunU0ZteBZm655IBzeeOxxkU6jHKIw34iusX4sJ9XzQLyoL5qm', '0'), /* Passsword: mario01 */
(5, 'luigi01', 'luigi.rossi@prova.com', '$2y$10$dizWh1.B8M8HrIQpIs/BIOSmO3oKqeGFT67meTeNoSSyNNc/ZY8Se', '0'); /* Passsword: luigi01 */

/* Prodotti */
INSERT INTO `prodotti` (`codProdotto`, `nome`, `immagine`, `descrizione`, `prezzo`, `quantita_disponibile`, `opera_di_appartenenza`, `altezza`, `larghezza`, `profondita`, `data_inserimento`, `punteggio_medio`, `codVenditore`, `categoria`) VALUES
(1, 'Mario', 'World_of_Nintendo_2.5_Inch_Mario.png', 'Action figure del nostro idraulico preferito: Mario di Super Mario.', 20, 3, 'Super Mario', 20, 8, 5, '2025-04-18', 5, 1, 'Videogiochi'),
(2, 'Luigi', 'World_of_Nintendo_2.5_Inch_Luigi.png', 'Action figure di Luigi, dala serie di Super Mario.', 20, 4, 'Super Mario Bros.', 20, 8, 5, '2025-04-18', 5, 1, 'Videogiochi'),
(3, 'Goomba', 'World_of_Nintendo_2.5_Inch_Goomba.jpg', 'Forse il nemico più iconico della saga di Super Mario: Goomba', 20, 7, 'Super Mario', 8, 8, 5, '2025-01-10', 4.5, 1, 'Videogiochi'),
(4, 'Blooming Pikachu', 'Blooming_Curiousity_Funko_Pop.jpg', 'Funko Pop della serie A Day With Pikachu', 99.99, 2, 'Pokémon', 6, 6, 6, '2025-05-22', 3.5, 1, 'Anime'),
(5, 'Eevee With Friends', 'Eevee_An_Afternoon_With_Eevee_Friends.png', 'Eevee in compagnia', 40.99, 0, 'Pokémon', 6, 20, 5, '2024-10-10', 5, 1, 'Anime'),
(7, 'Yugi Itadori', 'yugi_itadori.jpg', 'Action figure di Yugi Itadori da Jujutsu Kaisen.', 15.99, 0, 'Jujutsu Kaisen', 15.5, 5, 3.4, '2025-05-23', NULL, 1, 'Anime'),
(8, 'Todo Jujutsu Kaisen', 'todo_jujutsu_kaisen.jpg', 'Action figure di Todo di Jujustsu Kaisen.', 15.99, 3, 'Jujutsu Kaisen', 16.5, 6, 4, '2025-05-23', NULL, 1, 'Anime'),
(9, 'CuttleFish', 'World_of_Nintendo_2.5_Inch_Blooper.jpg', 'Una piccola seppia che rincorre i suoi nemici. State attenti al suo inchiostro', 15, 10, 'Super Mario', 5, 10, 5, '2025-05-21', NULL, 1, 'Videogiochi'),
(10, 'Palla di Ferro', 'World_of_Nintendo_2.5_Inch_Chain_Chomp.jpg', 'Una fidata palla da guardia feroce e leale.', 35, 10, 'Super Mario', 20, 30, 20, '2025-05-21', NULL, 1, 'Videogiochi'),
(11, 'Delorean Time Machine', 'Delorean.jpg', 'Direttamente da Ritorno al Futuro, la macchina del tempo più iconica del cinema.', 41.35, 3, 'Ritorno al Futuro', 5, 6, 12, '2025-05-23', 5, 1, 'Film'),
(12, 'Marty McFly', 'Marty_McFly.jpg', 'Marty McFly nella sua versione cowboy.', 39.99, 5, 'Ritorno al Futuro 3', 12, 5, 3, '2025-05-23', 5, 1, 'Film'),
(13, 'Doc Brown', 'Doc_Brown.jpg', 'Il Dottor Emmett Brown da \"Ritorno al Futuro\".', 40.39, 3, 'Ritorno al Futuro', 11, 6, 3, '2025-05-23', 5, 1, 'Film'),
(14, 'Darth Vader', 'darth_vader.jpg', 'Il più temuto Sith della galassia: Darth Vader.', 29.9, 6, 'Star Wars', 12.5, 5.5, 3.4, '2025-05-23', 5, 1, 'Film'),
(15, 'Luke Skywalker', 'luke_skywalker.jpg', 'Il Jedi Luke Skywalker dalla saga di Star Wars.', 25, 6, 'Star Wars', 14, 4, 3, '2025-05-23', NULL, 1, 'Film'),
(16, 'Chewbecca e Han Solo', 'star-wars-han-solo-chewbacca-statua-model-kit.jpg', 'Gli inseparabili Chewbecca e Han Solo dalla saga di Star Wars.', 34.52, 4, 'Star Wars', 14, 6.2, 3, '2025-05-23', NULL, 1, 'Film'),
(17, 'Ghostbusters', 'ghostbusters.jpg', 'La squadra di Ghostbusters al completo, pronti a salvare la città. Who you gonna call?', 35.2, 5, 'Ghostbusters', 12, 20, 3, '2025-05-23', 3, 1, 'Film'),
(18, 'Marshmallow Ghost', 'balloon_ghost.jpg', 'Il temuto (e enorme) Uomo della pubblicità dei Marshmallow da \"Ghostbusters\".', 19.99, 4, 'Ghostbusters', 16, 7, 5, '2025-05-23', NULL, 1, 'Film'),
(19, 'L Death Note', 'L_deathnote.jpg', 'Il formidabile investigatore L dalla saga di Death Note.', 15.5, 8, 'Death Note', 8, 5, 5, '2025-05-23', NULL, 1, 'Anime'),
(20, 'Light Yagami', 'light_yagami.jpg', 'Light Yagami, il possessore del Death Note.', 15.5, 4, 'Death Note', 12, 4, 3, '2025-05-23', NULL, 1, 'Anime'),
(21, 'Ryuk', 'ryuk_deathnote.jpg', 'Ryuk dall\'anime Death Note', 20, 5, 'Death Note', 15.5, 6, 4, '2025-05-23', NULL, 1, 'Anime'),
(22, 'Gojo', 'Gojo.jpg', 'Il potente Gojo dall\'anime Jujutsu Kaisen.', 24.5, 6, 'Jujutsu Kaisen', 12.5, 4, 3, '2025-05-23', NULL, 1, 'Anime'),
(23, 'Demogorgone', 'Demogorgon.jpg', 'L\'iconico Demogorgone dalla serie Stranger Things', 21.99, 4, 'Stranger Things', 10, 5, 4, '2025-05-23', NULL, 1, 'Serie TV'),
(24, 'Sceriffo Hopper', 'Hopper_Stranger_Things.jpg', 'Lo sceriffo Hopper dalla serie di Stranger Things', 12.9, 6, 'Stranger Things', 12, 5, 3, '2025-05-23', NULL, 1, 'Serie TV'),
(25, 'Eddie Guitarist', 'eddie-munson-deluxe_stranger-things_silo.png', 'Eddie Munson dalla serie di Stranger Things, durante un epico assolo di chitarra.', 40.99, 8, 'Stranger Things', 12.5, 5, 4, '2025-05-23', NULL, 1, 'Serie TV');

/* Appartenenze generi */
INSERT INTO `appartenenze_generi` (`codProdotto`, `genere`) VALUES
(1, 'Avventura'),
(2, 'Avventura'),
(3, 'Avventura'),
(4, 'Avventura'),
(5, 'Avventura'),
(9, 'Avventura'),
(10, 'Avventura'),
(1, 'Azione'),
(2, 'Azione'),
(3, 'Azione'),
(7, 'Azione'),
(8, 'Azione'),
(9, 'Azione'),
(10, 'Azione'),
(11, 'Azione'),
(12, 'Azione'),
(13, 'Azione'),
(14, 'Azione'),
(15, 'Azione'),
(16, 'Azione'),
(22, 'Azione'),
(23, 'Azione'),
(24, 'Azione'),
(25, 'Azione'),
(17, 'Commedia'),
(18, 'Commedia'),
(11, 'Fantascientifico'),
(12, 'Fantascientifico'),
(13, 'Fantascientifico'),
(14, 'Fantascientifico'),
(15, 'Fantascientifico'),
(16, 'Fantascientifico'),
(17, 'Fantascientifico'),
(18, 'Fantascientifico'),
(4, 'Fantasy'),
(5, 'Fantasy'),
(7, 'Fantasy'),
(8, 'Fantasy'),
(22, 'Fantasy'),
(21, 'Horror'),
(23, 'Horror'),
(24, 'Horror'),
(25, 'Horror'),
(19, 'Investigativo'),
(20, 'Investigativo'),
(21, 'Investigativo'),
(24, 'Investigativo'),
(19, 'Thriller'),
(20, 'Thriller'),
(21, 'Thriller'),
(12, 'Western');

/* Carrello */
INSERT INTO `carrello` (`codProdotto`, `codCliente`, `quantita`) VALUES
(15, 5, 1),
(16, 5, 1);

/* Preferiti */
INSERT INTO `preferiti` (`codProdotto`, `codCliente`) VALUES
(5, 2),
(8, 2),
(7, 5);

/* Recensioni */
INSERT INTO `recensioni` (`codProdotto`, `codCliente`, `punteggio`, `descrizione`, `data`) VALUES
(1, 2, 5, 'Ottimo prodotto, lo ricomprerei.', '2025-05-22'),
(1, 5, 5, 'Prodotto di ottima qualità. Un\'ottima abbinazione con l\'action figure di Luigi.', '2025-05-24'),
(2, 2, 5, 'Qualità impeccabile, consigliato.', '2025-05-22'),
(2, 5, 5, 'Ottima action figure! Molto fedele all\'originale.', '2025-05-24'),
(3, 2, 5, 'Ottimo prodotto! Proprio come me l\'aspettavo.', '2025-02-03'),
(3, 5, 4, 'Bello, ma l\'appoggio dei piedi è instabile.', '2025-05-24'),
(4, 2, 3, 'Bello, ma costa troppo.', '2025-01-30'),
(4, 5, 4, 'Prodotto di ottima qualità. L\'unica pecca è il costo eccessivo.', '2025-05-23'),
(5, 2, 5, 'Bellissimo. Lo consiglierò ai miei amici.', '2025-02-03'),
(11, 5, 5, 'Qualità impeccabile, molto dettagliata. Sicuramente un ottimo acquisto!', '2025-05-24'),
(12, 2, 5, 'Ottimo prodotto! Iconico, dettagliato e ben fatto. Lo consiglio!', '2025-05-24'),
(13, 2, 5, 'Bellissima action figure, molto dettagliata. Belli anche gli accessori inclusi.', '2025-05-24'),
(14, 5, 5, 'Ottimo prodotto! Sembra quasi di avere tra le mani il Darth Vader vero!', '2025-05-24'),
(17, 2, 3, 'Bello, ma sotto le aspettative. Speravo che le action figure fossero più dettagliate.', '2025-05-24');

/* Ordini */
INSERT INTO `ordini` (`codOrdine`, `data`, `indirizzo_di_spedizione`, `prezzo_totale`, `stato_spedizione`, `codCliente`) VALUES
(1, '2025-01-12', 'Via dell\'Università, 51', 100, 'Consegnato', 2),
(2, '2024-12-05', 'Via dell\'Università, 51', 99.99, 'Consegnato', 2),
(3, '2025-01-28', 'Via dell\'Università, 51', 162.97, 'Spedito', 2),
(4, '2025-01-28', 'Via dell\'Università, 51', 80, 'Spedito', 2),
(5, '2025-02-03', 'Via dell\'Università, 51', 161.98, 'Spedito', 2),
(6, '2025-02-03', 'Via dell\'Università, 51', 81.98, 'Consegnato', 2),
(7, '2025-02-04', 'Via dell\'Università, 51', 40, 'Spedito', 2),
(8, '2025-03-03', 'Via dell\'Università, 51', 35.99, 'Confermato', 2),
(9, '2025-05-20', 'Via dell\'Università, 51', 35.99, 'Confermato', 2),
(10, '2025-05-22', 'Via dell\'Università, 51', 20, 'Confermato', 2),
(11, '2025-05-23', 'Via dell\'Università, 51', 119.99, 'Consegnato', 5),
(12, '2025-05-24', 'Via dell\'Università, 51', 111.25, 'Consegnato', 5),
(13, '2025-05-24', 'Via dell\'Università, 51', 155.97, 'Consegnato', 2);

/* Composizioni */
INSERT INTO `composizioni` (`codProdotto`, `codOrdine`, `quantita`) VALUES
(1, 1, 3),
(1, 4, 2),
(1, 5, 4),
(1, 10, 1),
(1, 12, 1),
(2, 1, 2),
(2, 4, 2),
(2, 7, 2),
(2, 8, 1),
(2, 9, 1),
(2, 11, 1),
(3, 3, 2),
(3, 12, 1),
(4, 2, 1),
(4, 11, 1),
(5, 3, 3),
(5, 5, 2),
(5, 6, 2),
(8, 8, 1),
(8, 9, 1),
(11, 12, 1),
(12, 13, 1),
(13, 13, 2),
(14, 12, 1),
(17, 13, 1);

/* Notifiche */
INSERT INTO `notifiche` (`codNotifica`, `messaggio`, `data`, `letta`, `codUtente`) VALUES
(6, 'L\'utente mario01 ha recensito il prodotto Eevee With Friends avente ID = 5.', '2025-02-03 00:00:00', '0', 1),
(7, 'L\'utente mario01 ha recensito il prodotto Goomba avente ID = 3.', '2025-02-03 00:00:00', '0', 1),
(8, 'Il prodotto  avente ID = 5 è esaurito. Puoi rifornire le scorte nella sezione Gestione prodotti del tuo profilo.', '2025-02-03 00:00:00', '0', 1),
(9, 'Hai ricevuto un nuovo ordine con ID = 5. Puoi consultare i dettagli sull\'ordine nella sezione Ordini del tuo profilo.', '2025-02-03 00:00:00', '0', 1),
(10, 'Il prodotto Eevee With Friends avente ID = 5 è esaurito. Puoi rifornire le scorte nella sezione Gestione prodotti del tuo profilo.', '2025-02-03 23:08:06', '0', 1),
(11, 'Hai ricevuto un nuovo ordine con ID = 6. Puoi consultare i dettagli sull\'ordine nella sezione Ordini del tuo profilo.', '2025-02-03 23:08:06', '0', 1),
(12, 'Il tuo ordine con ID = 6 è stato Consegnato.', '2025-02-04 23:52:24', '0', 2),
(13, 'Hai ricevuto un nuovo ordine con ID = 7. Puoi consultare i dettagli sull\'ordine nella sezione Ordini del tuo profilo.', '2025-02-04 23:54:02', '0', 1),
(14, 'Il tuo ordine con ID = 7 è stato Spedito.', '2025-02-04 23:54:41', '0', 2),
(17, 'Il prodotto Todo Jujutsu Kaisen nel tuo carrello è finalmente disponibile!', '2025-02-06 21:46:35', '1', 2),
(18, 'Il prodotto Todo Jujutsu Kaisen nei tuoi preferiti è finalmente disponibile!', '2025-02-06 21:46:35', '0', 2),
(19, 'Hai ricevuto un nuovo ordine con ID = 8. Puoi consultare i dettagli sull\'ordine nella sezione Ordini del tuo profilo.', '2025-03-03 21:38:55', '0', 1),
(22, 'Il tuo ordine con ID = 7 è stato Consegnato.', '2025-04-29 21:52:54', '0', 2),
(23, 'Il tuo ordine con ID = 8 è stato Spedito.', '2025-04-29 21:54:00', '0', 2),
(26, 'Il tuo ordine con ID = 8 è stato Consegnato.', '2025-04-29 21:54:19', '0', 2),
(44, 'Il tuo ordine con ID = 1 è stato Consegnato.', '2025-05-02 17:16:40', '0', 2),
(46, 'Hai ricevuto un nuovo ordine con ID = 9.<br>Puoi consultare i dettagli sull\'ordine nella sezione Ordini del tuo profilo.', '2025-05-20 21:34:54', '0', 1),
(47, 'Hai ricevuto un nuovo ordine con ID = 10.<br>Puoi consultare i dettagli sull\'ordine nella sezione Ordini del tuo profilo.', '2025-05-22 11:31:46', '0', 1),
(48, 'Hai ricevuto un nuovo ordine con ID = 11.<br>Puoi consultare i dettagli sull\'ordine nella sezione Ordini del tuo profilo.', '2025-05-23 21:54:46', '1', 1),
(49, 'Il tuo ordine con ID = 11 è stato Spedito.', '2025-05-23 21:55:25', '1', 5),
(50, 'Il tuo ordine con ID = 11 è stato Consegnato.', '2025-05-23 21:55:27', '1', 5),
(51, 'L\'utente luigi01 ha recensito il prodotto Blooming Curiosity Pikachu avente ID = 4.', '2025-05-23 21:57:30', '0', 1),
(52, 'Hai ricevuto un nuovo ordine con ID = 12.<br>Puoi consultare i dettagli sull\'ordine nella sezione Ordini del tuo profilo.', '2025-05-24 11:05:38', '0', 1),
(53, 'Il tuo ordine con ID = 12 è stato Spedito.', '2025-05-24 11:06:21', '1', 5),
(54, 'Il tuo ordine con ID = 12 è stato Consegnato.', '2025-05-24 11:06:23', '1', 5),
(55, 'L\'utente luigi01 ha recensito il prodotto Delorean Time Machine avente ID = 11.', '2025-05-24 11:07:32', '0', 1),
(56, 'L\'utente luigi01 ha recensito il prodotto Darth Vader avente ID = 14.', '2025-05-24 11:08:24', '0', 1),
(57, 'L\'utente luigi01 ha recensito il prodotto Goomba avente ID = 3.', '2025-05-24 11:10:01', '0', 1),
(58, 'L\'utente luigi01 ha recensito il prodotto Luigi avente ID = 2.', '2025-05-24 11:11:34', '0', 1),
(59, 'L\'utente luigi01 ha recensito il prodotto Mario avente ID = 1.', '2025-05-24 11:12:44', '0', 1),
(60, 'Hai ricevuto un nuovo ordine con ID = 13.<br>Puoi consultare i dettagli sull\'ordine nella sezione Ordini del tuo profilo.', '2025-05-24 11:16:03', '0', 1),
(61, 'Il tuo ordine con ID = 13 è stato Spedito.', '2025-05-24 11:16:15', '0', 2),
(62, 'Il tuo ordine con ID = 13 è stato Consegnato.', '2025-05-24 11:16:15', '0', 2),
(63, 'L\'utente mario01 ha recensito il prodotto Doc Brown avente ID = 13.', '2025-05-24 11:18:01', '0', 1),
(64, 'L\'utente mario01 ha recensito il prodotto Ghostbusters avente ID = 17.', '2025-05-24 11:18:49', '0', 1),
(65, 'L\'utente mario01 ha recensito il prodotto Marty McFly avente ID = 12.', '2025-05-24 11:19:58', '0', 1);
