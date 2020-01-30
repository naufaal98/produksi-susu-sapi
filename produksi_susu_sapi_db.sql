create table penyetoran
(
	kode_setoran varchar(10) not null
		primary key,
	tgl_setoran date null,
	waktu_setoran varchar(5) null,
	petugas varchar(30) null,
	pembeli varchar(30) null,
	created_at timestamp null,
	updated_at timestamp null
);

create table sapi
(
	kode_sapi varchar(4) not null
		primary key,
	tgl_lahir_sapi date null,
	no_kandang int(3) null,
	created_at timestamp null,
	updated_at timestamp null
);

insert into sapi (kode_sapi, tgl_lahir_sapi, no_kandang, created_at, updated_at) values (1006, '2010-02-01', 2, '2020-01-29 07:39:25', '2020-01-29 07:39:25');
insert into sapi (kode_sapi, tgl_lahir_sapi, no_kandang, created_at, updated_at) values (1403, '2014-01-31', 2, '2020-01-27 20:15:52', '2020-01-28 04:02:20');
insert into sapi (kode_sapi, tgl_lahir_sapi, no_kandang, created_at, updated_at) values (1804, '2018-01-18', 1, '2020-01-28 03:45:28', '2020-01-28 04:02:04');
insert into sapi (kode_sapi, tgl_lahir_sapi, no_kandang, created_at, updated_at) values (1805, '2018-01-29', 1, '2020-01-28 07:06:54', '2020-01-28 07:06:54');
insert into sapi (kode_sapi, tgl_lahir_sapi, no_kandang, created_at, updated_at) values (2007, '2020-01-22', 3, '2020-01-29 15:41:27', '2020-01-29 15:41:27');
insert into sapi (kode_sapi, tgl_lahir_sapi, no_kandang, created_at, updated_at) values (2008, '2020-01-29', 3, '2020-01-29 15:41:49', '2020-01-29 15:41:49');
insert into sapi (kode_sapi, tgl_lahir_sapi, no_kandang, created_at, updated_at) values (209, '2020-01-30', 3, '2020-01-29 18:23:42', '2020-01-29 18:23:42');


create table hasil_perahan
(
	id_pemerahan int(6) auto_increment
		primary key,
	jumlah_susu int(4) null,
	tgl_pemerahan date null,
	kode_sapi varchar(4) null,
	kode_setoran varchar(10) null,
	constraint hasil_perahan_sapi_kode_sapi_fk
		foreign key (kode_sapi) references sapi (kode_sapi)
);

create index hasil_perahan_penyetoran_kode_setoran_fk
	on hasil_perahan (kode_setoran);

create table pemberian_pakan
(
	jumlah_mako float(5,2) null,
	jumlah_rumput float(5,2) null,
	tgl_pemberian date null,
	kode_sapi varchar(4) null,
	id_penyetokan int(6) null,
	constraint pemberian_pakan_sapi_kode_sapi_fk
		foreign key (kode_sapi) references sapi (kode_sapi)
);

create table stok_pakan
(
	id_penyetokan int(6) auto_increment
		primary key,
	tgl_penyetokan date null,
	stok_rumput int(4) null,
	stok_mako int(4) null,
	created_at timestamp null,
	updated_at timestamp null
);

create table users
(
	id bigint unsigned auto_increment
		primary key,
	name varchar(255) not null,
	username varchar(255) not null,
	password varchar(255) not null,
	remember_token varchar(100) null,
	created_at timestamp null,
	updated_at timestamp null
)
collate=utf8mb4_unicode_ci;

insert into users (id, name, username, password, remember_token, created_at, updated_at) values (1, 'admin', 'admin', '$2y$10$oRLnAnRp7HmH2znSr43LU.z1YnP1V74UuzjrMyNZps3P2mXwISaEC', null, '2020-01-30 02:22:34', '2020-01-30 02:22:37');