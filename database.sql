
CREATE SEQUENCE "public".seq_besoin START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".seq_commande START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".seq_departement START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".seq_detailbesoin START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".seq_detailcommande START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".seq_detailproforma START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".seq_employee START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".seq_fournisseur START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".seq_materiel START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".seq_nature START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".seq_poste START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".seq_proforma START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".seq_global START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".seq_detail_global START WITH 1 INCREMENT BY 1;

CREATE  TABLE "public".departement ( 
	iddepartement        varchar(70) DEFAULT ('DEP'::text || nextval('seq_departement'::regclass)) NOT NULL  ,
	nomdepartement       varchar(70)    ,
	CONSTRAINT pk_departement PRIMARY KEY ( iddepartement )
 );

CREATE  TABLE "public".fournisseur ( 
	idfournisseur        varchar(70) DEFAULT ('FOU'::text || nextval('seq_fournisseur'::regclass)) NOT NULL  ,
	nomfournisseur       varchar(100)    ,
	adresse              varchar(100)    ,
	contact              varchar(100)    ,
	responsable          varchar(100)    ,
	email                varchar(100)    ,
	CONSTRAINT pk_fournisseur PRIMARY KEY ( idfournisseur )
 );

CREATE  TABLE "public".modepaiement ( 
	idmodepaiement       varchar(70)  NOT NULL  ,
	nommodepaiement      varchar(100)    ,
	CONSTRAINT pk_modepaiement PRIMARY KEY ( idmodepaiement )
 );

CREATE  TABLE "public".nature ( 
	idnature             varchar(70) DEFAULT ('NAT'::text || nextval('seq_nature'::regclass)) NOT NULL  ,
	nomnature            varchar(100)    ,
	CONSTRAINT pk_nature PRIMARY KEY ( idnature )
 );

CREATE  TABLE "public".poste ( 
	idposte              varchar(70) DEFAULT ('POS'::text || nextval('seq_poste'::regclass)) NOT NULL  ,
	nomposte             varchar    ,
	iddepartement        varchar(70)    ,
	idboss               varchar(70)    ,
	privilege            integer DEFAULT 0   ,
	CONSTRAINT pk_poste PRIMARY KEY ( idposte ),
	CONSTRAINT fk_poste_departement FOREIGN KEY ( iddepartement ) REFERENCES "public".departement( iddepartement )   ,
	CONSTRAINT fk_poste_poste FOREIGN KEY ( idboss ) REFERENCES "public".poste( idposte )   
 );

CREATE  TABLE "public".unite ( 
	idunite              varchar(70)  NOT NULL  ,
	nomunite             varchar(100)    ,
	CONSTRAINT pk_unite PRIMARY KEY ( idunite )
 );

CREATE  TABLE "public".employee ( 
	idemployee           varchar(70) DEFAULT ('EMP'::text || nextval('seq_employee'::regclass)) NOT NULL  ,
	nom                  varchar(100)    ,
	prenom               varchar(100)    ,
	dtn                  date    ,
	genre                integer DEFAULT 1   ,
	email                varchar(100)    ,
	pwd                  varchar(100)    ,
	contact              varchar(100)    ,
	idposte              varchar(70)    ,
	CONSTRAINT pk_employee PRIMARY KEY ( idemployee ),
	CONSTRAINT fk_employee_poste FOREIGN KEY ( idposte ) REFERENCES "public".poste( idposte )   
 );

CREATE  TABLE "public".fournisseur_nature ( 
	idfournisseurnature  varchar(70)  NOT NULL  ,
	idfournisseur        varchar(70)    ,
	idnature             varchar(70)    ,
	CONSTRAINT pk_fournisseur_unite PRIMARY KEY ( idfournisseurnature ),
	CONSTRAINT fk_fournisseur_nature FOREIGN KEY ( idfournisseur ) REFERENCES "public".fournisseur( idfournisseur )   ,
	CONSTRAINT fk_fournisseur_nature_nature FOREIGN KEY ( idnature ) REFERENCES "public".nature( idnature )   
 );

CREATE  TABLE "public"."global" ( 
	idglobal             varchar(70)  NOT NULL  ,
	idemployee           varchar(70)    ,
	"date"               date DEFAULT CURRENT_DATE   ,
	CONSTRAINT pk_tbl PRIMARY KEY ( idglobal ),
	CONSTRAINT fk_tbl_employee FOREIGN KEY ( idemployee ) REFERENCES "public".employee( idemployee )   
 );

CREATE  TABLE "public".materiel ( 
	idmateriel           varchar(70) DEFAULT ('MAT'::text || nextval('seq_materiel'::regclass)) NOT NULL  ,
	nommateriel          varchar(100)    ,
	idnature             varchar(70)    ,
	idunite              varchar(70)    ,
	tva                  double precision DEFAULT 20   ,
	CONSTRAINT pk_materiel PRIMARY KEY ( idmateriel ),
	CONSTRAINT fk_materiel_nature FOREIGN KEY ( idnature ) REFERENCES "public".nature( idnature )   ,
	CONSTRAINT fk_materiel_unite FOREIGN KEY ( idunite ) REFERENCES "public".unite( idunite )   
 );

CREATE  TABLE "public".proforma ( 
	idproforma           varchar(70) DEFAULT ('PRO'::text || nextval('seq_proforma'::regclass)) NOT NULL  ,
	idfournisseur        varchar(70)    ,
	dateproformasent     date DEFAULT CURRENT_DATE   ,
	dateproformareceived date DEFAULT CURRENT_DATE   ,
	idglobal             varchar(70)    ,
	status               integer DEFAULT 0   ,
	CONSTRAINT pk_proforma PRIMARY KEY ( idproforma ),
	CONSTRAINT fk_proforma_fournisseur FOREIGN KEY ( idfournisseur ) REFERENCES "public".fournisseur( idfournisseur )   ,
	CONSTRAINT fk_proforma_global FOREIGN KEY ( idglobal ) REFERENCES "public"."global"( idglobal )   
 );

CREATE  TABLE "public".besoin ( 
	idbesoin             varchar(70) DEFAULT ('BES'::text || nextval('seq_besoin'::regclass)) NOT NULL  ,
	"date"               date DEFAULT CURRENT_DATE   ,
	iddepartement        varchar(70)    ,
	situation            integer    ,
	idemployee           varchar(70)    ,
	CONSTRAINT pk_besoin PRIMARY KEY ( idbesoin ),
	CONSTRAINT fk_besoin_departement FOREIGN KEY ( iddepartement ) REFERENCES "public".departement( iddepartement )   ,
	CONSTRAINT fk_besoin_employee FOREIGN KEY ( idemployee ) REFERENCES "public".employee( idemployee )   
 );

CREATE  TABLE "public".boncommande ( 
	idboncommande        varchar(70) DEFAULT ('COM'::text || nextval('seq_commande'::regclass)) NOT NULL  ,
	total                double precision    ,
	datecommande         date DEFAULT CURRENT_DATE   ,
	idmodepaiement       varchar(70)    ,
	livraisonpartielle   integer    ,
	delailivraison       date    ,
	validationfinance    integer    ,
	validationadjoint    integer    ,
	idglobal             varchar(70)    ,
	CONSTRAINT pk_commande PRIMARY KEY ( idboncommande ),
	CONSTRAINT fk_boncommande_modepaiement FOREIGN KEY ( idmodepaiement ) REFERENCES "public".modepaiement( idmodepaiement )   ,
	CONSTRAINT fk_boncommande_global FOREIGN KEY ( idglobal ) REFERENCES "public"."global"( idglobal )   
 );

CREATE  TABLE "public".detailbesoin ( 
	iddetail             varchar(70) DEFAULT ('BDET'::text || nextval('seq_detailbesoin'::regclass)) NOT NULL  ,
	idbesoin             varchar(70)    ,
	idmateriel           varchar(70)    ,
	qte                  double precision    ,
	CONSTRAINT pk_detailbesoin PRIMARY KEY ( iddetail ),
	CONSTRAINT fk_detailbesoin_detail FOREIGN KEY ( idmateriel ) REFERENCES "public".materiel( idmateriel )   ,
	CONSTRAINT fk_detailbesoin_besoin FOREIGN KEY ( idbesoin ) REFERENCES "public".besoin( idbesoin )   
 );

CREATE  TABLE "public".detailglobal ( 
	iddetailglobal       varchar(70)    ,
	idglobal             varchar(70)    ,
	idbesoin             varchar(70)    ,
	CONSTRAINT fk_detailglobal_global FOREIGN KEY ( idglobal ) REFERENCES "public"."global"( idglobal )   ,
	CONSTRAINT fk_detailglobal_besoin FOREIGN KEY ( idbesoin ) REFERENCES "public".besoin( idbesoin )   
 );

CREATE  TABLE "public".detailproforma ( 
	iddetail             varchar(70) DEFAULT ('PDET'::text || nextval('seq_detailproforma'::regclass)) NOT NULL  ,
	idproforma           varchar(70)    ,
	idmateriel           varchar(70)    ,
	pu                   double precision    ,
	qte                  double precision    ,
	totalmontant         double precision    ,
	CONSTRAINT pk_detail PRIMARY KEY ( iddetail ),
	CONSTRAINT fk_detail_proforma FOREIGN KEY ( idproforma ) REFERENCES "public".proforma( idproforma )   ,
	CONSTRAINT fk_detail_materiel FOREIGN KEY ( idmateriel ) REFERENCES "public".materiel( idmateriel )   
 );

CREATE  TABLE "public".detailcommande ( 
	iddetail             varchar(70) DEFAULT ('CDET'::text || nextval('seq_detailcommande'::regclass)) NOT NULL  ,
	qte                  double precision    ,
	idboncommande        varchar(70)    ,
	idmateriel           varchar(70)    ,
	pu                   double precision    ,
	montantht            double precision    ,
	montantttc           double precision    ,
	CONSTRAINT pk_detailcommande PRIMARY KEY ( iddetail ),
	CONSTRAINT fk_detailcommande_commande FOREIGN KEY ( idboncommande ) REFERENCES "public".boncommande( idboncommande )   ,
	CONSTRAINT fk_detailcommande_materiel FOREIGN KEY ( idmateriel ) REFERENCES "public".materiel( idmateriel )   
 );


-- Ajouter des données à la table fournisseur 
INSERT INTO "public".fournisseur (nomfournisseur, adresse, contact, responsable, email)
VALUES 
  ('SCORE', '123 Rue A', '034 00 032 02', 'John', 'score@mg.com'),
  ('LEADER PRICE', '456 Rue B', '034 00 032 11', 'Lala', 'leader@mg.com'),
  ('F SHOP', '789 Rue C', '034 00 032 23', 'Nivo', 'shopfC@mg.com');


-- Ajouter des données à la table nature
INSERT INTO "public".nature ( nomnature)
VALUES 
  ( 'electronique'),
  ( 'Bureau');


  INSERT INTO "public".departement ( nomdepartement)
VALUES 
  ( 'Informatique'),
  ( 'RH'),
( 'Achat & vente'),
('Finance');


-- Ajouter des données à la table poste
INSERT INTO "public".poste (nomposte, iddepartement, idboss, privilege)
VALUES 
  ( 'Directeur de systeme informatique', 'DEP1', NULL, 2),
  ( 'Developpeur Senior', 'DEP1', 'POS1', 0),
  ( 'Developpeur Junior', 'DEP1', 'POS2', 0),
  ( 'Responsable RH', 'DEP2', NULL, 1),
  ('Assistant RH', 'DEP2', 'POS4', 0),
  ( 'Responsable Achat&vente', 'DEP3', NULL, 1),
     ( 'Comptable', 'DEP3', 'POS6', 0),
	 ( 'Directeur Finance', 'DEP4', NULL, 1);

-- Ajouter 10 données à la table materiel sans spécifier l'ID
INSERT INTO "public".materiel (nommateriel, idnature,idunite)
VALUES 
  ('Ordinateur portable HP', 'NAT1','U3'),
  ('Bureau en verre', 'NAT2','U3'),
  ('Imprimante laser', 'NAT1','U3'),
  ('Clavier sans fil', 'NAT1','U3'),
  ('Chaise ergonomique', 'NAT2','U3'),
  ('Scanner 3D', 'NAT1','U3'),
  ('Stylo  encre noire', 'NAT2','U3'),
  ('Ecran LCD 24 pouces', 'NAT1','U3'),
  ('Tapis de souris', 'NAT1','U3'),
  ('Lampe de bureau LED', 'NAT2','U3');	


-- Ajouter des données à la table employee pour chaque poste
INSERT INTO "public".employee (nom, prenom, dtn, genre, email, pwd, contact, idposte)
VALUES 
  ('Doe', 'John', '1990-01-15', 1, 'john.doe@example.com', 'motdepasse1', '123-456-7890', 'POS1'),
  ('Smith', 'Jane', '1985-03-20', 0, 'jane.smith@example.com', 'motdepasse2', '987-654-3210', 'POS2'),
  ('Johnson', 'Bob', '1992-07-05', 1, 'bob.johnson@example.com', 'motdepasse3', '555-123-4567', 'POS3'),
  ('Brown', 'Alice', '1988-09-10', 0, 'alice.brown@example.com', 'motdepasse4', '111-222-3333', 'POS4'),
  ('Williams', 'Chris', '1995-12-25', 1, 'chris.williams@example.com', 'motdepasse5', '444-555-6666', 'POS5'),
  ('Davis', 'Emily', '1980-06-30', 0, 'emily.davis@example.com', 'motdepasse6', '777-888-9999', 'POS6'),
  ('Miller', 'Michael', '1998-04-12', 1, 'michael.miller@example.com', 'motdepasse7', '000-111-2222', 'POS7'),
  ('Jayson', 'Tatum', '1998-04-15', 1, 'jayson@example.com', 'motdepasse8', '123-476-7890', 'POS8');

INSERT INTO "public".modepaiement (nommodepaiement)
VALUES 
  ('Espèce'),
  ('Chèque'),
  ('Au comptant');

  INSERT INTO "public".unite (idunite, nomunite)
VALUES 
  ('U1', 'kg'),
  ('U2', 'litre'),
  ('U3', 'unity');

  -- ------------------------------------------------------------------

	create or replace view v_employee_detail as (
  select employee.*, poste.nomposte, poste.iddepartement, poste.idboss, poste.privilege, departement.nomdepartement
  from employee
  inner join poste on poste.idposte = employee.idposte
  inner join departement on departement.iddepartement = poste.iddepartement);

  -- ----------------------------------------------------------

  create or replace view v_materiel_detail as(
  select materiel.idmateriel, materiel.nommateriel, materiel.tva, nature.*, unite.*
  from materiel
  inner join nature on nature.idnature = materiel.idnature
  inner join unite on unite.idunite = materiel.idunite);

  -- -----------------------------------------------------------
  
create or replace view v_besoin_detail as(
	select besoin.idbesoin, v_materiel_detail.*, detailbesoin.qte
	from detailbesoin
	inner join besoin on besoin.idbesoin = detailbesoin.idbesoin
	inner join v_materiel_detail on detailbesoin.idmateriel = v_materiel_detail.idmateriel
);

-- ---------------------------------------------------------------
create or replace view v_besoin_general as(
select besoin.idbesoin, besoin.date, departement.*, employee.nom, employee.prenom, employee.idemployee, besoin.situation
from besoin
inner join employee on employee.idemployee = besoin.idemployee
inner join departement on departement.iddepartement = besoin.iddepartement);

-- ----------------------------------------------------------------

create or replace view v_global_general as(
	select global.idglobal, global.date, employee.nom, employee.prenom, global.status
	from global
	inner join employee on employee.idemployee = global.idemployee
)

-- -------------------------------------------------------------
-- select v_materiel_detail.*, t1.total
-- from
-- (select t.idmateriel, sum(qte) as total
-- from (select v_besoin_detail.*, detailglobal.idglobal
-- from detailglobal
-- inner join v_besoin_detail on v_besoin_detail.idbesoin = detailglobal.idbesoin
-- where detailglobal.idglobal = 'GLO_26') as t
-- group by t.idmateriel) as t1
-- inner join v_materiel_detail on v_materiel_detail.idmateriel = t1.idmateriel

-- ------------------------------------------------------------------------

-- select t.idnature
-- from (select v_besoin_detail.*, detailglobal.idglobal
-- from detailglobal
-- inner join v_besoin_detail on v_besoin_detail.idbesoin = detailglobal.idbesoin
-- where detailglobal.idglobal = 'GLO_5') as t
-- group by t.idnature

-- -------------------------------------------------------------------
insert into fournisseur_nature values('FN1', 'FOU1', 'NAT1');
insert into fournisseur_nature values('FN2', 'FOU2', 'NAT2');
insert into fournisseur_nature values('FN3', 'FOU3', 'NAT1');
insert into fournisseur_nature values('FN4', 'FOU3', 'NAT2');

-- -------------------------------------------------------------------


delete from detailcommande;
delete from boncommande;
delete from detailproforma;
delete from proforma;
delete from detailglobal;
delete from global;
delete from detailbesoin;
delete from besoin;

	update besoin set situation = 1 where situation != 0;

-- ----------------------other------------------------------------------

create or replace view v_proforma_detail as(
	select detailproforma.qte, proforma.dateproformasent, proforma.idproforma, fournisseur.*, v_materiel_detail.*, proforma.idglobal
	from detailproforma
	inner join proforma on proforma.idproforma = detailproforma.idproforma
	inner join v_materiel_detail on v_materiel_detail.idmateriel = detailproforma.idmateriel
	inner join fournisseur on fournisseur.idfournisseur = proforma.idfournisseur
);

-- ------------------------------------------------------------------


create OR REPLACE  view v_proformadetail as(
	select proforma.idfournisseur,proforma.dateproformasent,proforma.dateproformareceived,proforma.idglobal,proforma.status,detailproforma.*,
	v_materiel_detail.nommateriel, v_materiel_detail.tva, v_materiel_detail.nomunite, v_materiel_detail.idunite,  v_materiel_detail.idnature,  v_materiel_detail.nomnature
	from detailproforma 
	join v_materiel_detail on v_materiel_detail.idmateriel = detailproforma.idmateriel
	join proforma on detailproforma.idproforma= proforma.idproforma
);

-- ---------------------------------------------------------

create OR REPLACE  view v_proformacomplete as
select v_proformadetail.* , fournisseur.nomfournisseur from v_proformadetail
join fournisseur on v_proformadetail.idfournisseur= fournisseur.idfournisseur;

-- --------------------------------------------

alter table global add column status integer default 0;

-- --------------------------------------------------

create  OR REPLACE view v_globalcomplete as 
select global.* , detailglobal.iddetailglobal,v_besoin_detail.*
from detailglobal join global on global.idglobal= detailglobal.idglobal
join v_besoin_detail on detailglobal.idbesoin = v_besoin_detail.idbesoin;

-- ------------------------------------------------
CREATE VIEW v_besoins_detail AS
SELECT
    b.idbesoin,
    b.date,
    b.iddepartement,
    b.situation,
    b.idemployee,
    d.iddetail,
    d.idmateriel,
    d.qte
FROM
    public.besoin b
JOIN
    public.detailbesoin d ON b.idbesoin = d.idbesoin;

-- ---------------------------------------------------------------

CREATE VIEW v_globals_detail AS
SELECT
    g.idglobal,
    g.idemployee,
    g.date AS global_date,
    dg.iddetailglobal,
    dg.idbesoin
FROM
    public.global g
JOIN public.detailglobal dg ON g.idglobal = dg.idglobal;

-- ---------------------------------------------

CREATE VIEW v_global_besoin AS
SELECT
    gb.idglobal,
    gb.idemployee AS global_idemployee,
    gb.global_date,
    gb.iddetailglobal,
    gb.idbesoin AS global_idbesoin,
    bd.idbesoin,
    bd.date AS besoin_date,
    bd.iddepartement,
    bd.situation,
    bd.idemployee AS besoin_idemployee,
    bd.iddetail,
    bd.idmateriel,
    bd.qte,
	m.nommateriel,
    nat.nomnature,
    u.nomunite,
    m.tva
FROM
    v_globals_detail gb
JOIN
    v_besoins_detail bd ON gb.idbesoin = bd.idbesoin
JOIN
	materiel m ON bd.idmateriel = m.idmateriel
JOIN
    nature nat ON m.idnature = nat.idnature
JOIN
    unite u ON m.idunite = u.idunite;

-- ----------------------------------------

CREATE VIEW v_proformas_detail AS
SELECT
    p.idproforma,
    p.idfournisseur,
    p.dateproformasent,
    p.dateproformareceived,
    p.idglobal,
    f.nomfournisseur,
    f.adresse,
    f.contact,
    f.responsable,
    f.email
FROM
    proforma p
JOIN
    fournisseur f ON p.idfournisseur = f.idfournisseur;


-- ----------------------------------------------

alter table boncommande add column idfournisseur varchar;
ALTER TABLE boncommande
ADD CONSTRAINT fk_fournisseur
FOREIGN KEY (idfournisseur) 
REFERENCES fournisseur(idfournisseur);
alter table boncommande add column status integer default 0;

-- ----------------------------------------------------

create or replace view v_commandedetail as 
(select  v_materiel_detail.nommateriel,v_materiel_detail.tva,v_materiel_detail.idnature,v_materiel_detail.nomnature,v_materiel_detail.idunite,v_materiel_detail.nomunite
 ,detailcommande.* from detailcommande join  v_materiel_detail on
 v_materiel_detail.idmateriel = detailcommande.idmateriel);




create or replace view v_commandes as
select boncommande.status,boncommande.total, boncommande.idglobal,
fournisseur.*,v_commandedetail.*, boncommande.datecommande  from
 boncommande 
join v_commandedetail on boncommande.idboncommande = v_commandedetail.idboncommande
join fournisseur on boncommande.idfournisseur = fournisseur.idfournisseur;

-- ----------------- PART 3 -------------------------

-- STOCKAGE

create table type_stockage(
	idStockage varchar(50) primary key not null,
	nameStockage varchar(100)
);

insert into type_stockage values('ST1', 'LIFO');
insert into type_stockage values('ST2', 'FIFO');
insert into type_stockage values('ST3', 'CMUP');

-- PRODUIT


alter table materiel add column idStockage varchar(50);
alter table materiel add foreign key(idStockage) REFERENCES type_stockage(idStockage);
alter table materiel add column stock_minimum numeric;
alter table materiel add column stock_alerte numeric;

-- DEPARTEMENT AJOUT
insert into departement values('DEP5', 'Logistique');
insert into departement values('DEP6', 'Marketing et Vente');

-- POSTE
insert into poste values('POS9', 'Directeur Vente et Marketing', 'DEP6', null, 1);
insert into poste values('POS10', 'Directeur Logistique', 'DEP5', null, 1);
insert into poste values('POS11', 'Commercial local', 'DEP6', 'POS9', 0);
insert into poste values('POS12', 'Receptionniste', 'DEP5', 'POS10', 0);
insert into poste values('POS13', 'Magasinier', 'DEP5', 'POS10', 0);

-- EMPLOYE

INSERT INTO "public".employee (nom, prenom, dtn, genre, email, pwd, contact, idposte)
VALUES 
  ('Kawhi', 'Leonard', '1999-01-15', 1, 'kawhi@example.com', 'kawhi', '123-456-7890', 'POS9'),
  ('Paul', 'Georges', '1983-09-20', 1, 'george@example.com', 'george', '987-654-3210', 'POS10'),
  ('Norman', 'Powell', '1998-02-05', 1, 'powell@example.com', 'powell', '555-123-4567', 'POS11'),
  ('James', 'Harden', '1980-07-05', 1, 'harden@example.com', 'powell', '555-123-4567', 'POS12'),
  ('Russel', 'West', '1998-09-05', 1, 'west@example.com', 'west', '123-476-7890', 'POS13');
  
-- BON COMMADNDE
create or replace view v_bon_commande_general as(
	select 
		boncommande.idboncommande,
		boncommande.idglobal,
		boncommande.total,
		boncommande.datecommande,
		boncommande.status,
		fournisseur.nomfournisseur,
		fournisseur.idfournisseur
	from
		boncommande
	inner join 
		fournisseur on fournisseur.idfournisseur = boncommande.idfournisseur
);



-- ------------- BON DE LIVRAISON

CREATE SEQUENCE "public".seq_bon_livraison START WITH 1 INCREMENT BY 1;

create table bon_livraison(
	idBonLivraison varchar(70) DEFAULT ('BL_'::text || nextval('seq_bon_livraison'::regclass)) PRIMARY KEY NOT NULL,
	numeroLivraison varchar(100),
	idboncommande varchar(70),
	dateLivraison date,
	pathJustificatif varchar(100),
	idemployee varchar(70),
	status_livraison numeric,
	foreign key(idboncommande) REFERENCES boncommande(idboncommande),
	foreign key(idemployee) REFERENCES employee(idemployee)
);

-- --------------- DETAIL B.L
CREATE SEQUENCE "public".seq_detail_livraison START WITH 1 INCREMENT BY 1;

create table detail_livraison(
	idDetailLivraison varchar(100) DEFAULT ('BL_DET_'::text || nextval('seq_detail_livraison'::regclass)) PRIMARY KEY NOT NULL,
	idBonLivraison varchar(70),
	idmateriel varchar(70),
	qty_request numeric,
	qty_received numeric,
	remarque text,
	foreign key(idBonLivraison) REFERENCES bon_livraison(idBonLivraison),
	foreign key(idmateriel) REFERENCES materiel(idmateriel)
);

-- ---------------------------------------------------
create or replace view v_general_livraison as(
	select 
		bon_livraison.idBonLivraison,
		bon_livraison.idboncommande,
		bon_livraison.dateLivraison,
		bon_livraison.numeroLivraison,
		bon_livraison.status_livraison,
		bon_livraison.pathJustificatif,
		employee.nom,
		employee.prenom,
		v_bon_commande_general.idfournisseur,
		v_bon_commande_general.nomfournisseur
	from bon_livraison
	inner join employee on employee.idemployee = bon_livraison.idemployee
	inner join v_bon_commande_general on v_bon_commande_general.idboncommande = bon_livraison.idboncommande
);

-- ---------------------------------------------------------

create or replace view v_detail_livraison as(
	select 
		bon_livraison.idBonLivraison,
		detail_livraison.idDetailLivraison,
		detail_livraison.idmateriel,
		v_materiel_detail.nommateriel,
		v_materiel_detail.nomunite,
		detail_livraison.qty_received,
		detail_livraison.remarque
	from detail_livraison
	inner join bon_livraison on bon_livraison.idBonLivraison = detail_livraison.idBonLivraison
	inner join v_materiel_detail on v_materiel_detail.idmateriel = detail_livraison.idmateriel
);

-- ----------------- BON DE RECEPTION

CREATE SEQUENCE "public".seq_bon_reception START WITH 1 INCREMENT BY 1;
create table bon_reception(
	idBonReception varchar(100) PRIMARY KEY NOT NULL,
	idBonLivraison varchar(70),
	dateReception date,
	idemployee varchar(70),
	status_reception numeric,
	foreign key(idBonLivraison) REFERENCES bon_livraison(idBonLivraison),
	foreign key(idemployee) REFERENCES employee(idemployee)
);

-- ---------------- DETAIL RECEPTION

CREATE SEQUENCE "public".seq_detail_reception START WITH 1 INCREMENT BY 1;

create table detail_reception(
	idDetailReception varchar(100) PRIMARY KEY NOT NULL,
	idBonReception varchar(100),
	idmateriel varchar(70),
	qty_request numeric,
	qty_received numeric,
	remarque text,
	foreign key(idBonReception) REFERENCES bon_reception(idBonReception),
	foreign key(idmateriel) REFERENCES materiel(idmateriel)
);

-- --------------------------------
create or replace view v_general_reception as (
	select 
		bon_reception.idBonReception,
		v_general_livraison.idBonLivraison,
		v_general_livraison.pathJustificatif,
		bon_reception.dateReception,
		employee.nom,
		employee.prenom,
		fournisseur.*,
		bon_reception.status_reception
	from bon_reception
	inner join employee on employee.idemployee = bon_reception.idemployee
	inner join v_general_livraison on v_general_livraison.idBonLivraison = bon_reception.idBonLivraison
	inner join fournisseur on fournisseur.idfournisseur = v_general_livraison.idfournisseur
);

-- ------------------------------------------

create or replace view v_detail_reception as(
	select 
		bon_reception.idBonReception,
		detail_reception.idDetailReception,
		detail_reception.idmateriel,
		v_materiel_detail.nommateriel,
		v_materiel_detail.nomunite,
		detail_reception.qty_request,
		detail_reception.qty_received
	from detail_reception
	inner join bon_reception on bon_reception.idBonReception = detail_reception.idBonReception
	inner join v_materiel_detail on v_materiel_detail.idmateriel = detail_reception.idmateriel
);

-- --------------- FACTURE
CREATE SEQUENCE "public".seq_facture_received START WITH 1 INCREMENT BY 1;

create table facture_received(
	idFactureReceived varchar(70) DEFAULT ('FA_RE_'::text || nextval('seq_facture_received'::regclass)) PRIMARY KEY NOT NULL,
	numeroFacture varchar(100),
	idboncommande varchar(70),
	dateFacture date,
	pathJustificatif varchar(100),
	idemployee varchar(70),
	status_facture numeric,
	montant_ht_facture numeric,
	montant_ttc_facture numeric,
	foreign key(idboncommande) REFERENCES boncommande(idboncommande),
	foreign key(idemployee) REFERENCES employee(idemployee)
);

-- --------------- DETAIL B.L
CREATE SEQUENCE "public".seq_detail_facture_received START WITH 1 INCREMENT BY 1;

create table detail_facture_received(
	idDetailFactureReceived varchar(100) DEFAULT ('FA_RE_DET_'::text || nextval('seq_detail_facture_received'::regclass)) PRIMARY KEY NOT NULL,
	idFactureReceived varchar(70),
	idmateriel varchar(70),
	qty_request numeric,
	qty_received numeric,
	unit_price numeric,
	montant_detail_ht numeric,
	montant_detail_ttc numeric,
	remarque text,
	foreign key(idFactureReceived) REFERENCES facture_received(idFactureReceived),
	foreign key(idmateriel) REFERENCES materiel(idmateriel)
);

-- ---------------------------------------------------
create or replace view v_general_facture_received as(
	select 
		facture_received.idFactureReceived,
		facture_received.idboncommande,
		facture_received.dateFacture,
		facture_received.numeroFacture,
		facture_received.status_facture,
		facture_received.pathJustificatif,
		facture_received.montant_ht_facture,
		facture_received.montant_ttc_facture,
		employee.nom,
		employee.prenom,
		v_bon_commande_general.idfournisseur,
		v_bon_commande_general.nomfournisseur
	from facture_received
	inner join employee on employee.idemployee = facture_received.idemployee
	inner join v_bon_commande_general on v_bon_commande_general.idboncommande = facture_received.idboncommande
);

-- ---------------------------------------------------------

create or replace view v_detail_facture_received as(
	select 
		facture_received.idFactureReceived,
		facture_received.idboncommande,
		detail_facture_received.idDetailFactureReceived,
		detail_facture_received.idmateriel,
		v_materiel_detail.nommateriel,
		v_materiel_detail.nomunite,
		detail_facture_received.qty_received,
		detail_facture_received.remarque,
		detail_facture_received.unit_price,
		detail_facture_received.montant_detail_ht,
		detail_facture_received.montant_detail_ttc
	from detail_facture_received
	inner join facture_received on facture_received.idFactureReceived = detail_facture_received.idFactureReceived
	inner join v_materiel_detail on v_materiel_detail.idmateriel = detail_facture_received.idmateriel
);

-- ------------------------------ BON D'ENTREE

CREATE SEQUENCE "public".seq_bon_entree START WITH 1 INCREMENT BY 1;

create table bon_entree(
	idbonentree varchar(70) DEFAULT ('BE_'::text || nextval('seq_bon_entree'::regclass)) PRIMARY KEY NOT NULL,
	idBonReception varchar(70),
	dateEntree date,
	pathJustificatif varchar(100),
	idemployee varchar(70),
	status_entree numeric,
	foreign key(idBonReception) REFERENCES bon_reception(idBonReception),
	foreign key(idemployee) REFERENCES employee(idemployee)
);

-- --------------- DETAIL Bon entree
CREATE SEQUENCE "public".seq_detail_entree START WITH 1 INCREMENT BY 1;

create table detail_entree(
	iddetailentree varchar(100) DEFAULT ('BE_DET_'::text || nextval('seq_detail_entree'::regclass)) PRIMARY KEY NOT NULL,
	idbonentree varchar(70),
	idmateriel varchar(70),
	qty_request numeric,
	qty_received numeric,
	remarque text,
	foreign key(idbonentree) REFERENCES bon_entree(idbonentree),
	foreign key(idmateriel) REFERENCES materiel(idmateriel)
);

-- ---------------------------------------------------
create or replace view v_general_entree as(
	select 
		bon_entree.idbonentree,
		bon_entree.idBonReception,
		bon_entree.dateEntree,
		bon_entree.status_entree,
		bon_entree.pathJustificatif,
		employee.nom,
		employee.prenom,
		v_general_reception.idfournisseur,
		v_general_reception.nomfournisseur
	from bon_entree
	inner join employee on employee.idemployee = bon_entree.idemployee
	inner join v_general_reception on v_general_reception.idBonReception = bon_entree.idBonReception
);

-- ---------------------------------------------------------

create or replace view v_detail_entree as(
	select 
		bon_entree.idbonentree,
		bon_entree.idBonReception,
		detail_entree.iddetailentree,
		detail_entree.idmateriel,
		v_materiel_detail.nommateriel,
		v_materiel_detail.nomunite,
		detail_entree.qty_received,
		detail_entree.remarque
	from detail_entree
	inner join bon_entree on bon_entree.idbonentree = detail_entree.idbonentree
	inner join v_materiel_detail on v_materiel_detail.idmateriel = detail_entree.idmateriel
);

-- ----------------------- STOCK PRODUIT

CREATE SEQUENCE "public".seq_stock_entree START WITH 1 INCREMENT BY 1;

create table stock_entree(
    idstockentree varchar(50) primary key not null,
    idmateriel varchar(70),
    dateentree timestamp, 
    quantity numeric,
    unitPriceEntree numeric,
    montant_ht numeric, 
	montant_ttc numeric,
    availability numeric,
	idemployee varchar(70),
    foreign key(idmateriel) references materiel(idmateriel),
	foreign key(idemployee) REFERENCES employee(idemployee)
);



-- ----------------------------
CREATE SEQUENCE "public".seq_stock_sortie START WITH 1 INCREMENT BY 1;

create table stock_sortie(
    idstocksortie varchar(50) primary key not null,
    idmateriel varchar(50),
    datesortie timestamp, 
    quantity numeric,
	unitPriceSortie numeric,
	idemployee varchar(70),
	iddepartement varchar(70),
    foreign key(idmateriel) references materiel(idmateriel),
	foreign key(idemployee) REFERENCES employee(idemployee),
	foreign key(iddepartement) REFERENCES departement(iddepartement)
);

-- ---------------------------

-- CREATE SEQUENCE "public".seq_detail_sortie START WITH 1 INCREMENT BY 1;

-- CREATE TABLE detail_sortie (
--     iddetail_sortie varchar(50) primary key not null,
--     idstocksortie varchar(50),
--     idstockentree varchar(50),
--     quantityDetail numeric,
--     FOREIGN KEY (idstocksortie) REFERENCES stock_sortie(idstocksortie), 
--     FOREIGN KEY (idstockentree) REFERENCES stock_entree(idstockentree) 
-- );

-- -------------------------------

create or replace view v_materiel_detail_stockage as(
  select 
  	materiel.idmateriel, 
	
	materiel.nommateriel, 
	materiel.tva, 
	materiel.stock_minimum,
	materiel.stock_alerte,
	unite.*,
	type_stockage.*
  from materiel
  inner join nature on nature.idnature = materiel.idnature
  inner join unite on unite.idunite = materiel.idunite
  inner join type_stockage on type_stockage.idStockage = materiel.idStockage
  );

-- -----------------------------------

create table taux_benefice(
	idtauxbenefice varchar(100) primary key not null,
	datechoice date,
	marge numeric
);

insert into taux_benefice values('BEN1', '2023-01-01', 1.4);

-- ----------------------- CLIENT
create table customer(
	idcustomer varchar(100) primary key not null,
	name_company varchar(100),
	adresse_customer varchar(100),
	email_customer varchar(100),
	responsable_customer varchar(100),
	numero_customer varchar(50),
	numero_nif varchar(50),
	numero_stat varchar(50)
);

insert into customer values('CUS_1', 'RAFIA', 'Tsarahonenana', 'rafia@gmail.com', 'Mme Rova', '125145', 'NIF78', 'STAT458');
insert into customer values('CUS_2', 'VANILLA', 'Ivato', 'vanilla@gmail.com', 'Mme Santatra', '17489', 'NIF7820', 'STAT741');

-- ------------------------ PROFORMA CLIENT

CREATE SEQUENCE "public".seq_proforma_client START WITH 1 INCREMENT BY 1;

create table proforma_client(
	idproformaclient varchar(100) primary key not null,
	idcustomer varchar(100),
	numeroproforma varchar(100),
	date_proforma_client_received date,
	date_proforma_client_send date,
	date_proforma_client_last date,
	pathJustificatif varchar(100),
	pathJustificatif_sent varchar(100),
	idemployee varchar(70),
	status_proforma_client numeric,
	FOREIGN KEY (idcustomer) REFERENCES customer(idcustomer),
	foreign key(idemployee) REFERENCES employee(idemployee)
);

-- ----------------------------------------
CREATE SEQUENCE "public".seq_detail_proforma_client START WITH 1 INCREMENT BY 1;

create table detail_proforma_client(
	id_detail_proforma_client varchar(100) primary key not null,
	idproformaclient varchar(100),
	idmateriel varchar(70),
	qty_request numeric,
	qty_in_stock numeric,
	unit_price_ht numeric,
	montant_ht numeric,
	montant_ttc numeric,
	FOREIGN KEY (idproformaclient) REFERENCES proforma_client(idproformaclient),
	FOREIGN KEY (idmateriel) REFERENCES materiel(idmateriel) 
);

-- --------------------------------------------------

create or replace view v_general_proforma_client as(
	select 
		proforma_client.idproformaclient,
		proforma_client.numeroproforma,
		proforma_client.status_proforma_client,
		proforma_client.date_proforma_client_received,
		proforma_client.date_proforma_client_send,
		proforma_client.date_proforma_client_last,
		proforma_client.pathJustificatif,
		proforma_client.pathJustificatif_sent,
		employee.nom,
		employee.prenom,
		customer.*
	from proforma_client
	inner join customer on customer.idcustomer = proforma_client.idcustomer
	inner join employee on employee.idemployee = proforma_client.idemployee
);

-- -----------------------------------------------------

create or replace view v_detail_proforma_client as(
	select 
		detail_proforma_client.idproformaclient,
		detail_proforma_client.id_detail_proforma_client,
		detail_proforma_client.idmateriel,
		v_materiel_detail.nommateriel,
		v_materiel_detail.nomunite,
		detail_proforma_client.qty_request,
		detail_proforma_client.qty_in_stock,
		detail_proforma_client.unit_price_ht,
		detail_proforma_client.montant_ht,
		detail_proforma_client.montant_ttc
	from detail_proforma_client
	inner join v_materiel_detail on v_materiel_detail.idmateriel = detail_proforma_client.idmateriel
);

-- -------------------------------------- BON COMMANDE RECU
CREATE SEQUENCE "public".seq_commande_client START WITH 1 INCREMENT BY 1;

create table commande_client(
	idcommandeclient varchar(100) primary key not null,
	idcustomer varchar(100),
	numerocommande varchar(100),
	date_commande_client_received date,
	pathJustificatif varchar(100),
	idemployee varchar(70),
	status_commande_client numeric,
	FOREIGN KEY (idcustomer) REFERENCES customer(idcustomer),
	foreign key(idemployee) REFERENCES employee(idemployee)
);

-- ----------------------------------------
CREATE SEQUENCE "public".seq_detail_commande_client START WITH 1 INCREMENT BY 1;

create table detail_commande_client(
	id_detail_commande_client varchar(100) primary key not null,
	idcommandeclient varchar(100),
	idmateriel varchar(70),
	qty_request numeric,
	unit_price_ht numeric,
	montant_ht numeric,
	montant_ttc numeric,
	FOREIGN KEY (idcommandeclient) REFERENCES commande_client(idcommandeclient),
	FOREIGN KEY (idmateriel) REFERENCES materiel(idmateriel) 
);


-- ---------------------------------------------------
create or replace view v_general_commande_client as(
	select 
		commande_client.idcommandeclient,
		commande_client.numerocommande,
		commande_client.status_commande_client,
		commande_client.date_commande_client_received,
		commande_client.pathJustificatif,
		employee.nom,
		employee.prenom,
		customer.*
	from commande_client
	inner join customer on customer.idcustomer = commande_client.idcustomer
	inner join employee on employee.idemployee = commande_client.idemployee
);

-- -------------------------------------------------------
create or replace view v_detail_commande_client as(
	select 
		detail_commande_client.idcommandeclient,
		detail_commande_client.id_detail_commande_client,
		detail_commande_client.idmateriel,
		v_materiel_detail.nommateriel,
		v_materiel_detail.nomunite,
		detail_commande_client.qty_request,
		detail_commande_client.unit_price_ht,
		detail_commande_client.montant_ht,
		detail_commande_client.montant_ttc
	from detail_commande_client
	inner join v_materiel_detail on v_materiel_detail.idmateriel = detail_commande_client.idmateriel
);

-- -----------------------  FACTURATION

CREATE SEQUENCE "public".seq_facturation START WITH 1 INCREMENT BY 1;

create table facturation(
	idfacturation varchar(100) primary key not null,
	date_facturation date,
	idcommandeclient varchar(100),
	idemployee varchar(70),
	pathjustificatif varchar(100),
	FOREIGN KEY (idcommandeclient) REFERENCES commande_client(idcommandeclient),
	foreign key(idemployee) REFERENCES employee(idemployee)
);

-- ----------------------------------------

create or replace view v_general_facturation_client as(
	select 
		facturation.idfacturation,
		facturation.date_facturation,
		facturation.pathjustificatif as pathfacture,
		v_general_commande_client.*,
		employee.nom as nom_emp,
		employee.prenom as prenom_emp
	from facturation
	inner join v_general_commande_client on v_general_commande_client.idcommandeclient = facturation.idcommandeclient
	inner join employee on employee.idemployee = facturation.idemployee
);

-- ------------------------------------------

create or replace view v_detail_facturation_client as(
	select 
		facturation.idfacturation,
		v_detail_commande_client.*
	from v_detail_commande_client
	inner join facturation on facturation.idcommandeclient = v_detail_commande_client.idcommandeclient
);

-- -------------------- BON LIVRAISON POUR CLIENT
CREATE SEQUENCE "public".seq_bl_client START WITH 1 INCREMENT BY 1;

create table bon_livraison_client(
	idlivraisonclient varchar(100) primary key not null,
	date_livraison date,
	idcommandeclient varchar(100),
	idemployee varchar(70),
	pathjustificatif varchar(100),
	FOREIGN KEY (idcommandeclient) REFERENCES commande_client(idcommandeclient),
	foreign key(idemployee) REFERENCES employee(idemployee)
);

-- -----------------------------------------------

create or replace view v_general_livraison_client as(
	select 
		bon_livraison_client.idlivraisonclient,
		bon_livraison_client.date_livraison,
		bon_livraison_client.pathjustificatif as path_livraison,
		v_general_commande_client.*,
		employee.nom as nom_emp,
		employee.prenom as prenom_emp
	from bon_livraison_client
	inner join v_general_commande_client on v_general_commande_client.idcommandeclient = bon_livraison_client.idcommandeclient
	inner join employee on employee.idemployee = bon_livraison_client.idemployee
);

-- ------------------------------------------


create or replace view v_detail_livraison_client as(
	select 
		bon_livraison_client.idlivraisonclient,
		v_detail_commande_client.idcommandeclient,
		v_detail_commande_client.id_detail_commande_client,
		v_detail_commande_client.idmateriel,
		v_detail_commande_client.nommateriel,
		v_detail_commande_client.qty_request,
		v_detail_commande_client.nomunite,
		v_detail_commande_client.unit_price_ht
	from v_detail_commande_client
	inner join bon_livraison_client on bon_livraison_client.idcommandeclient = v_detail_commande_client.idcommandeclient
);

-- ------------------------- BON SORTIE

CREATE SEQUENCE "public".seq_bon_sortie START WITH 1 INCREMENT BY 1;

create table bon_sortie(
	idbonsortie varchar(70) DEFAULT ('BS_'::text || nextval('seq_bon_sortie'::regclass)) PRIMARY KEY NOT NULL,
	dateSortie date,
	pathJustificatif varchar(100),
	idemployee varchar(70),
	status_sortie numeric,
	iddepartement varchar(70),
	foreign key(idemployee) REFERENCES employee(idemployee),
	foreign key(iddepartement) REFERENCES departement(iddepartement)
);

-- --------------- DETAIL Bon sortie
CREATE SEQUENCE "public".seq_detail_sortie START WITH 1 INCREMENT BY 1;

create table detail_sortie(
	iddetailsortie varchar(100) DEFAULT ('BS_DET_'::text || nextval('seq_detail_sortie'::regclass)) PRIMARY KEY NOT NULL,
	idbonsortie varchar(70),
	idmateriel varchar(70),
	qty_leave numeric,
	remarque text,
	foreign key(idbonsortie) REFERENCES bon_sortie(idbonsortie),
	foreign key(idmateriel) REFERENCES materiel(idmateriel)
);

-- ---------------------------------------------------
create or replace view v_general_sortie as(
	select 
		bon_sortie.idbonsortie,
		bon_sortie.dateSortie,
		bon_sortie.status_sortie,
		bon_sortie.pathJustificatif,
		bon_sortie.iddepartement,
		employee.nom,
		employee.prenom,
		departement.nomdepartement
	from bon_sortie
	inner join employee on employee.idemployee = bon_sortie.idemployee
	inner join departement on departement.iddepartement = bon_sortie.iddepartement
);

-- ---------------------------------------------------------

create or replace view v_detail_sortie as(
	select 
		bon_sortie.idbonsortie,
		detail_sortie.iddetailsortie,
		detail_sortie.idmateriel,
		v_materiel_detail.nommateriel,
		v_materiel_detail.nomunite,
		detail_sortie.qty_leave,
		detail_sortie.remarque
	from detail_sortie
	inner join bon_sortie on bon_sortie.idbonsortie = detail_sortie.idbonsortie
	inner join v_materiel_detail on v_materiel_detail.idmateriel = detail_sortie.idmateriel
);


-- ----------------------------------------------------------

-- ---------- INVENTAIRE

CREATE SEQUENCE "public".seq_inventaire START WITH 1 INCREMENT BY 1;

create table inventaire(
	idinventaire varchar(70) PRIMARY KEY NOT NULL,
	dateInventaire date,
	idemployee varchar(70),
	status_inventaire numeric,
	foreign key(idemployee) REFERENCES employee(idemployee)
);

-- detail inventaire

CREATE SEQUENCE "public".seq_detail_inventaire START WITH 1 INCREMENT BY 1;

create table detail_inventaire(
	iddetail_inventaire varchar(100) DEFAULT ('BS_DET_'::text || nextval('seq_detail_sortie'::regclass)) PRIMARY KEY NOT NULL,
	idinventaire varchar(70),
	idmateriel varchar(70),
	qty_inventaire numeric,
	remarque text,
	pu_materiel numeric,
	foreign key(idinventaire) REFERENCES inventaire(idinventaire),
	foreign key(idmateriel) REFERENCES materiel(idmateriel)
);

-- ------------------------------ 
create or replace view v_general_inventaire as(
	select 
		inventaire.idinventaire,
		inventaire.dateInventaire,
		inventaire.status_inventaire,
		employee.nom,
		employee.prenom,
		inventaire.pathcsv
	from inventaire
	inner join employee on employee.idemployee = inventaire.idemployee
	order by inventaire.dateInventaire DESC
);

-- ---------------------------------------------------------

create or replace view v_detail_inventaire as(
	select 
		inventaire.idinventaire,
		detail_inventaire.iddetail_inventaire,
		detail_inventaire.idmateriel,
		v_materiel_detail.nommateriel,
		v_materiel_detail.nomunite,
		detail_inventaire.qty_inventaire,
		detail_inventaire.remarque,
		detail_inventaire.pu_materiel
	from detail_inventaire
	inner join inventaire on inventaire.idinventaire = detail_inventaire.idinventaire
	inner join v_materiel_detail on v_materiel_detail.idmateriel = detail_inventaire.idmateriel
);

-- --------------------------------------------------------

alter table inventaire add column pathcsv varchar(100);
alter table detail_inventaire add pu_materiel numeric;

-- ---------------------------------------------- INITIALIZE INVENTAIRE


-- -------------------------------------------------------------

delete from detail_ecart_materiel;
delete from ecart;
delete from detail_inventaire;
delete from inventaire;

-- ---------------------- ECART

CREATE SEQUENCE "public".seq_ecart START WITH 1 INCREMENT BY 1;

create table ecart(
	idecart varchar(70) PRIMARY KEY NOT NULL,
	idlastinventaire varchar(70),
	idinventaire varchar(70),
	status_ecart numeric,
	foreign key(idlastinventaire) REFERENCES inventaire(idinventaire),
	foreign key(idinventaire) REFERENCES inventaire(idinventaire)
);

CREATE SEQUENCE "public".seq_detail_ecart START WITH 1 INCREMENT BY 1;


create table detail_ecart_materiel(
	iddetail_ecart varchar(70) PRIMARY KEY NOT NULL,
	idecart varchar(70),
	idmateriel varchar(70),
	pu_materiel numeric,
	qty_normal numeric,
	qty_inventaire numeric,
	qty_ecart numeric,
	remarque varchar(100),
	foreign key(idecart) REFERENCES ecart(idecart),
	foreign key(idmateriel) REFERENCES materiel(idmateriel)
);


-- -------------------------------------------

create or replace view v_detail_ecart as(
	select
		ecart.idecart,
		ecart.idinventaire,
		inventaire.dateInventaire,
		detail_ecart_materiel.iddetail_ecart,
		detail_ecart_materiel.qty_normal,
		detail_ecart_materiel.qty_inventaire,
		detail_ecart_materiel.qty_ecart,
		detail_ecart_materiel.idmateriel,
		detail_ecart_materiel.pu_materiel,
		detail_ecart_materiel.pu_materiel * detail_ecart_materiel.qty_ecart as value_ecart,
		v_materiel_detail.nomunite
	from detail_ecart_materiel
	inner join ecart on ecart.idecart = detail_ecart_materiel.idecart
	inner join inventaire on inventaire.idinventaire = ecart.idinventaire
	inner join v_materiel_detail on v_materiel_detail.idmateriel = detail_ecart_materiel.idmateriel
);

-- ------------------------------------------

insert into inventaire values('I1', '2023-01-01', 'EMP10', 2);

insert into detail_inventaire values('DE_INV_1', 'I1', 'MAT22', 0, '', 0);
insert into detail_inventaire values('DE_INV_2', 'I1', 'MAT25', 0, '', 0);
insert into detail_inventaire values('DE_INV_3', 'I1', 'MAT28', 0, '', 0);

insert into ecart values('E1', null, 'I1', 1);
insert into detail_ecart_materiel values('D1', 'E1', 'MAT22', 0, 0, 0, 0, '');
insert into detail_ecart_materiel values('D2', 'E1', 'MAT25', 0, 0, 0, 0, '');
insert into detail_ecart_materiel values('D3', 'E1', 'MAT28', 0, 0, 0, 0, '');

-- ----------------------------------------
-- select idinventaire, sum(value_ecart) as total
-- from v_detail_ecart
-- group by idinventaire

-- -----------------------------------------------------------

-- Marque voiture
CREATE SEQUENCE "public".seq_marque START WITH 1 INCREMENT BY 1;

CREATE  TABLE "public".marque ( 
	idmarque      varchar(70) DEFAULT ('MRQ_'::text || nextval('seq_marque'::regclass)) NOT NULL  ,
	nommarque       varchar(70)    ,
	CONSTRAINT pk_marque PRIMARY KEY ( idmarque )
 );
 INSERT INTO "public".marque ( nommarque) VALUES
('Toyota'),
('Honda');

-- ------------------------------------------------------------
-- Modele voiture
CREATE SEQUENCE "public".seq_modele START WITH 1 INCREMENT BY 1;

CREATE  TABLE "public".modele ( 
	idmodele      varchar(70) DEFAULT ('MOD_'::text || nextval('seq_modele'::regclass)) NOT NULL  ,
	nommodele       varchar(70)    ,
	idmarque       varchar(70)    ,
	foreign key(idmarque) REFERENCES marque(idmarque),
	CONSTRAINT pk_modele PRIMARY KEY ( idmodele )
 );

 INSERT INTO "public".modele (idmodele, nommodele, idmarque)
VALUES 
('MOD_1', 'Camry', 'MRQ_1'),
('MOD_2', 'Civic', 'MRQ_2');

-- -----------------------------------------------------------------
-- Voiture

CREATE SEQUENCE "public".seq_voiture START WITH 1 INCREMENT BY 1;

CREATE  TABLE "public".voiture ( 
	idvoiture      varchar(70) DEFAULT ('VTR_'::text || nextval('seq_voiture'::regclass)) NOT NULL  ,
	code VARCHAR(100) DEFAULT (current_date::text || '-VOI-00' || currval('seq_voiture')::text),
	idmodele       varchar(70)  ,
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	consommation float ,
	kilometrage float ,
	matricule varchar(50),
	foreign key(idmodele) REFERENCES modele(idmodele),
	CONSTRAINT pk_voiture PRIMARY KEY ( idvoiture )
 );

 INSERT INTO "public".voiture (idvoiture, idmodele, consommation, kilometrage, matricule) values
 	('VOI_1', 'MOD_1', 12,1000, '1215 TBB'),
	('VOI_2', 'MOD_2', 17,1000, '1618 TBA');

-- -----------------------------------------------------------------
-- VIEW VOITURE

create or replace view v_voiture as
	SELECT 
		VOITURE.* , 
		modele.nommodele, 
		marque.nommarque 
	from modele 
	join voiture on  voiture.idmodele = modele.idmodele 
	join marque on marque.idmarque = modele.idmarque;

 -- ---------------------------------------------------------------
 -- Categorie

CREATE SEQUENCE "public".seq_categorie START WITH 1 INCREMENT BY 1;

CREATE  TABLE "public".categorie ( 
	idcategorie      varchar(70) DEFAULT ('CTG_'::text || nextval('seq_categorie'::regclass)) NOT NULL  ,
	nomcategorie       varchar(70)    ,
	CONSTRAINT pk_categorie PRIMARY KEY ( idcategorie )
);


INSERT INTO categorie(idcategorie, nomcategorie) values
	('CAT_V1', 'carosserie'),
	('CAT_V2', 'moteur'),
	('CAT_V3', 'train');

-- ------------------------------------------------------------------
-- Detail categories

CREATE SEQUENCE "public".seq_detail_categorie START WITH 1 INCREMENT BY 1;

CREATE  TABLE "public".detail_categorie ( 
	iddetail_categorie      varchar(70) DEFAULT ('DC_'::text || nextval('seq_detail_categorie'::regclass)) NOT NULL  ,
	nomdetail_categorie       varchar(70)    ,
	idcategorie varchar(70),
	foreign key(idcategorie) REFERENCES categorie(idcategorie),
	CONSTRAINT pk_detail_categorie PRIMARY KEY ( iddetail_categorie )
 );
insert into detail_categorie(iddetail_categorie, nomdetail_categorie, idcategorie) values
	('DET_CAT_1', 'Couleur','CAT_V1'),
	('DET_CAT_2', 'Phare','CAT_V1'),
	('DET_CAT_3', 'Join de culasse ','CAT_V2'),
	('DET_CAT_4', 'Bougie','CAT_V2'),
	('DET_CAT_5', 'Silent Bloc','CAT_V3'),
	('DET_CAT_6', 'Rotule','CAT_V3');

-- -------------------------------------------------------------------------
-- View pour detail categorie
create view v_detail_categorie as
 select 
 	categorie.* , 
 	detail_categorie.nomdetail_categorie, 
	detail_categorie.iddetail_categorie 
	from detail_categorie 
	join categorie on categorie.idcategorie = detail_categorie.idcategorie;

-- ---------------------------------------------------
-- Type d'entretien

CREATE table type_entretien(
	id_type_entretien varchar(70) primary key,
	nom_entretien varchar(70)
);

insert into type_entretien values ('ENTR_1', 'Reparation');
insert into type_entretien values ('ENTR_2', 'Controle');

-- -------------------------------------------------------------------
-- Nombre de km a effectuer pour controle (ex: Changement bougie tous les 500 km)

CREATE table controle_km(
	id_controle_km varchar(70) primary key,
	iddetail_categorie varchar(70),
	nombre_km float,
	foreign key(iddetail_categorie) REFERENCES detail_categorie(iddetail_categorie)
);

insert into controle_km values('CONTR_1', 'DET_CAT_1', 10000);
insert into controle_km values('CONTR_2', 'DET_CAT_2', 5000);
insert into controle_km values('CONTR_3', 'DET_CAT_3', 1000);
insert into controle_km values('CONTR_4', 'DET_CAT_4', 1200);
insert into controle_km values('CONTR_5', 'DET_CAT_5', 5000);
insert into controle_km values('CONTR_6', 'DET_CAT_6', 5000);

-- -------------------------------------------------------------------
create or replace view v_controle_kilometre as ( 
	select 
		v_detail_categorie.*,
		controle_km.id_controle_km,
		controle_km.nombre_km
	from controle_km
	join v_detail_categorie on v_detail_categorie.iddetail_categorie = controle_km.iddetail_categorie
);

-- -------------------------------------------------------------------
-- Etat de la voiture
CREATE SEQUENCE "public".seq_etat START WITH 1 INCREMENT BY 1;

CREATE  TABLE "public".etat ( 
	idetat      varchar(70) DEFAULT ('ET_'::text || nextval('seq_etat'::regclass)) NOT NULL  ,
	idvoiture       varchar(70)    ,
	iddetail_categorie varchar(70),
	valeur float ,
	date_etat date,
	foreign key(idvoiture) REFERENCES voiture(idvoiture),
	foreign key(iddetail_categorie) REFERENCES detail_categorie(iddetail_categorie),
	CONSTRAINT pk_etat PRIMARY KEY ( idetat )
 );
 insert into etat (idetat, idvoiture, iddetail_categorie,valeur, date_etat) values
 	('ET1', 'VOI_1','DET_CAT_1',3, '2024-02-06'),
	('ET2', 'VOI_2','DET_CAT_1',7, '2024-02-06');

	insert into etat values ('ET3', 'VOI_2','DET_CAT_1',7, '2024-02-06');
	insert into etat values ('ET4', 'VOI_2','DET_CAT_2',7, '2024-02-06');
	insert into etat values ('ET5', 'VOI_2','DET_CAT_3',7, '2024-02-06');
	insert into etat values ('ET6', 'VOI_2','DET_CAT_4',7, '2024-02-06');
	insert into etat values ('ET7', 'VOI_2','DET_CAT_5',7, '2024-02-06');
	insert into etat values ('ET8', 'VOI_2','DET_CAT_6',7, '2024-02-06');

	
	insert into etat values ('ET9', 'VOI_1','DET_CAT_6',3, '2024-02-06');
	insert into etat values ('ET10', 'VOI_1','DET_CAT_2',4, '2024-02-06');
	insert into etat values ('ET11', 'VOI_1','DET_CAT_3',5, '2024-02-06');
	insert into etat values ('ET12', 'VOI_1','DET_CAT_4',2, '2024-02-06');
	insert into etat values ('ET13', 'VOI_1','DET_CAT_5',2, '2024-02-06');


	

-- -------------------------------------------------------------------------

create or replace view v_etat_voiture as( 
	SELECT  
		v_voiture.* , 
		v_detail_categorie.* ,
		etat.valeur,
		etat.date_etat
	from etat 
	join v_detail_categorie on etat.iddetail_categorie = v_detail_categorie.iddetail_categorie
	join v_voiture on etat.idvoiture = v_voiture.idvoiture
);

 -- -----------------------------------------------------------
 -- UTILISATION

CREATE SEQUENCE "public".seq_utilisation START WITH 1 INCREMENT BY 1;

CREATE  TABLE "public".utilisation ( 
	idutilisation      varchar(70) DEFAULT ('MOD_'::text || nextval('seq_utilisation'::regclass)) NOT NULL  ,
	idvoiture       varchar(70)    ,
	idemployee varchar(70),
	debut_kilometrage float,
	fin_kilometrage float,
	motif text,
	debut TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	fin TIMESTAMP ,
	foreign key(idvoiture) REFERENCES voiture(idvoiture),
	foreign key(idemployee) REFERENCES employee(idemployee),
	CONSTRAINT pk_utilisation PRIMARY KEY ( idutilisation )
 );

-- --------------------------------------------------------------
-- STATION ESSENCE

CREATE SEQUENCE "public".seq_station START WITH 1 INCREMENT BY 1;

CREATE  TABLE "public".station ( 
	idstation      varchar(70) DEFAULT ('STN_'::text || nextval('seq_station'::regclass)) NOT NULL  ,
	nomstation       varchar(70)    ,
	CONSTRAINT pk_station PRIMARY KEY ( idstation )
 );
  INSERT INTO station (idstation, nomstation)values
  	('STATION_1', 'TOYOTA'),
	('STATION_2', 'GALANA'),
	('STATION_3', 'SHELL');

-- ---------------------------------------------------------
-- GESTION CARBURANT

CREATE SEQUENCE "public".seq_carburant START WITH 1 INCREMENT BY 1;

CREATE  TABLE "public".carburant ( 
	idcarburant      varchar(70) DEFAULT ('CTG_'::text || nextval('seq_carburant'::regclass)) NOT NULL  ,
	idvoiture       varchar(70)    ,
	litre float ,
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	idstation varchar(70),
	idemployee varchar(70),
	foreign key(idemployee) REFERENCES employee(idemployee),
	foreign key(idvoiture) REFERENCES voiture(idvoiture),
	foreign key(idstation) REFERENCES station(idstation),
	CONSTRAINT pk_carburant PRIMARY KEY ( idcarburant )
 );

-- ------------------------------------------------------------
-- PAPIER VOITURE

  CREATE SEQUENCE "public".seq_papier START WITH 1 INCREMENT BY 1;

CREATE  TABLE "public".papier ( 
	idpapier      varchar(70) DEFAULT ('PPR_'::text || nextval('seq_papier'::regclass)) NOT NULL  ,
	nompapier       varchar(70)    ,
	CONSTRAINT pk_papier PRIMARY KEY ( idpapier )
 );

 INSERT INTO papier (idpapier, nompapier) values
 	('PAP_1', 'assurance'),
	('PAP_2', 'carte grise'),
	('PAP_3', 'Controle technique');

-- -----------------------------------------------------------------
-- PAPIER VOITURE

CREATE SEQUENCE "public".seq_admin START WITH 1 INCREMENT BY 1;

CREATE  TABLE "public".admin ( 
	idadmin      varchar(70) DEFAULT ('PP_'::text || nextval('seq_admin'::regclass)) NOT NULL  ,
	idvoiture       varchar(70)    ,
	date_debut date default NOW(),
	date_fin date,
	idpapier varchar(70),
	idemployee varchar(70),
	foreign key(idvoiture) REFERENCES voiture(idvoiture),
	foreign key(idemployee) REFERENCES employee(idemployee),
	foreign key(idpapier) REFERENCES papier(idpapier),
	CONSTRAINT pk_admin PRIMARY KEY ( idadmin )
 );

-- -------------------------------------------------------------------
CREATE SEQUENCE "public".seq_entretien START WITH 1 INCREMENT BY 1;

CREATE TABLE entretien_voiture(
	id_entretien_voiture varchar(70) primary key,
	idvoiture varchar(70),
	iddetail_categorie varchar(70),
	date_entretien timestamp default CURRENT_TIMESTAMP,
	kilometrage float,
	next_controle float,
	id_type_entretien varchar(70),
	prix_entretien float,
	foreign key(iddetail_categorie) REFERENCES detail_categorie(iddetail_categorie),
	foreign key(id_type_entretien) REFERENCES type_entretien(id_type_entretien),
	foreign key(idvoiture) REFERENCES voiture(idvoiture)
);

insert into entretien_voiture values ('E1', 'VOI_2', 'DET_CAT_4', '2024-02-05 12:11:00', 1100, 1000, 'ENTR_1', 1000);
insert into entretien_voiture values ('E2', 'VOI_2', 'DET_CAT_5', '2024-02-06 12:11:00', 1100, 1000, 'ENTR_1', 1500);
insert into entretien_voiture values ('E3', 'VOI_2', 'DET_CAT_5', '2024-02-05 12:15:00', 1100, 1000, 'ENTR_1', 1600);
insert into entretien_voiture values ('E4', 'VOI_2', 'DET_CAT_5', '2024-02-07 12:50:00', 1100, 1000, 'ENTR_2', 1600);

-- -----------------------------------------------------------------------
-- GENERAL ENTRETIENS D'UNE VOITURE

create or replace view v_last_entretien as (
	SELECT ev.*
	FROM entretien_voiture ev
	JOIN (
		SELECT idvoiture, iddetail_categorie, MAX(date_entretien) AS latest_date_entretien
		FROM entretien_voiture
		GROUP BY idvoiture, iddetail_categorie
	) subquery ON ev.idvoiture = subquery.idvoiture
		AND ev.iddetail_categorie = subquery.iddetail_categorie
		AND ev.date_entretien = subquery.latest_date_entretien
);

-- -----------------------------------------------------------
-- DETAIL D'ENTRETIENS D'UNE VOITURE

create or replace view v_detail_last_entretien as (
	select
		v_last_entretien.*,
		v_detail_categorie.nomcategorie,
		v_detail_categorie.nomdetail_categorie,
		type_entretien.nom_entretien
	from v_last_entretien
	join v_detail_categorie on v_detail_categorie.iddetail_categorie = v_last_entretien.iddetail_categorie
	join type_entretien on type_entretien.id_type_entretien = v_last_entretien.id_type_entretien
);

-- -----------------------------------------------------------

create or replace view v_detail_entretien as (
	select 
		v_detail_categorie.nomcategorie,
		v_detail_categorie.nomdetail_categorie,
		type_entretien.nom_entretien,
		entretien_voiture.*
	from entretien_voiture
	join v_detail_categorie on v_detail_categorie.iddetail_categorie = entretien_voiture.iddetail_categorie
	join type_entretien on type_entretien.id_type_entretien = entretien_voiture.id_type_entretien 
);

-- ----------------------------------------------------------------
create view v_carburant as 
	select 
		carburant.* , 
		voiture.MATRICULE,
		station.nomstation, 
		employee.nom 
	from carburant
	join voiture on voiture.idvoiture = carburant.idvoiture
	join station on station.idstation = carburant.idstation
	join employee on employee.idemployee = carburant.idemployee;

create view v_papier as 
	select 
		admin.* , 
		voiture.MATRICULE,
		papier.nompapier, 
		employee.nom 
	from admin
	join voiture on voiture.idvoiture = admin.idvoiture
	join papier on papier.idpapier = admin.idpapier
	join employee on employee.idemployee = admin.idemployee;

CREATE SEQUENCE "public".seq_pk_prix_carburant START WITH 1 INCREMENT BY 1;

CREATE  TABLE "public".prix_carburant ( 
	idprix_carburant      varchar(70) DEFAULT ('PC_'::text || nextval('seq_pk_prix_carburant'::regclass)) NOT NULL  ,
	valeur float   ,
	date DATE DEFAULT NOW(),
	CONSTRAINT pk_pk_prix_carburant PRIMARY KEY ( idprix_carburant )
 );
 INSERT INTO prix_carburant(valeur) values(20000);

 create or replace view v_detail_categorie as
 select 
		categorie.* , 
		detail_categorie.nomdetail_categorie, 
		detail_categorie.iddetail_categorie 
	from detail_categorie 
	join categorie on categorie.idcategorie = detail_categorie.idcategorie;
	
alter table voiture add column prix float default 10000000;


DROP VIEW V_ETAT_VOITURE;
DROP VIEW V_VOITURE;

create or replace  view v_voiture as
	SELECT 
	VOITURE.* , 
	modele.nommodele, 
	marque.nommarque 
	from modele 
	join voiture on  voiture.idmodele = modele.idmodele 
	join marque on marque.idmarque = modele.idmarque;

create view v_etat_voiture as
 SELECT  
 	v_voiture.* , 
	v_detail_categorie.*,
	etat.valeur 
 from etat 
 join v_detail_categorie on etat.iddetail_categorie = v_detail_categorie.iddetail_categorie
 join v_voiture on etat.idvoiture = v_voiture.idvoiture;

 -- ------------------------------------------------------------------------------------
  alter table voiture add column taux int ;
  alter table voiture add column methode int default 0;


  -- ----------------------------------------------------------------------------------

create or replace view v_historique_activite as (
	select 
		v_employee_detail.prenom,
		v_employee_detail.nom,
		v_employee_detail.nomdepartement,
		utilisation.*,
		utilisation.fin_kilometrage - utilisation.debut_kilometrage as distance
	from utilisation
	join v_employee_detail on v_employee_detail.idemployee = utilisation.idemployee
	order by fin desc
);

-- ----------------------------------------------------------------------------

create or replace view v_depense_carburant as (
	select 
		voiture.idvoiture,
		sum(coalesce(carburant.litre, 0) * (select valeur from prix_carburant order by date desc limit 1)) as total_carburant
	from voiture
	LEFT JOIN carburant on carburant.idvoiture = voiture.idvoiture
	group by voiture.idvoiture
);



-- -------------------------------------------------------------------------------

create or replace view v_depense_entretien as (
	select 
		voiture.idvoiture,
		sum(coalesce(entretien_voiture.prix_entretien, 0)) as total_entretien
	from voiture
	LEFT JOIN  entretien_voiture on entretien_voiture.idvoiture = voiture.idvoiture
	group by voiture.idvoiture
);

-- ---------------------------------------------------------------------------

create or replace view v_depense_total as (
	select
		v_depense_entretien.idvoiture,
		v_depense_entretien.total_entretien,
		v_depense_carburant.total_carburant,
		(v_depense_entretien.total_entretien + v_depense_carburant.total_carburant) as total_depense
	from v_depense_entretien
	join v_depense_carburant on v_depense_carburant.idvoiture = v_depense_entretien.idvoiture
	order by total_depense desc
);

-- ---------------------------------------------------------------------------

create or replace view v_general_depense_total as (
	select
		v_voiture.*,
		v_depense_total.total_entretien,
		v_depense_total.total_carburant,
		v_depense_total.total_depense
	from v_depense_total
	join  v_voiture on v_voiture.idvoiture = v_depense_total.idvoiture
	order by v_depense_total.total_depense desc
);

-- ---------------------------------------------------------------------------

create or replace view v_general_depense_carburant as (
	select
		v_voiture.*,
		v_depense_total.total_entretien,
		v_depense_total.total_carburant,
		v_depense_total.total_depense
	from v_depense_total
	join  v_voiture on v_voiture.idvoiture = v_depense_total.idvoiture
	order by v_depense_total.total_carburant desc
);

-- ---------------------------------------------------------------------------

create or replace view v_general_depense_entretien as (
	select
		v_voiture.*,
		v_depense_total.total_entretien,
		v_depense_total.total_carburant,
		v_depense_total.total_depense
	from v_depense_total
	join  v_voiture on v_voiture.idvoiture = v_depense_total.idvoiture
	order by v_depense_total.total_entretien desc
);

-- ---------------------------------------------------------------------------

insert into entretien_voiture values('ENTRETIEN_0', 'VOI_2', 'DET_CAT_5', (select now()), 1200, 1300, 'ENTR_1', 1800);

