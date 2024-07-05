/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2019/7/13 18:32:26                           */
/*==============================================================*/


drop index Index_6 on c2_product_category;

drop index Index_5 on c2_product_category;

drop index Index_4 on c2_product_category;

drop index Index_3 on c2_product_category;

drop index Index_2 on c2_product_category;

drop index Index_1 on c2_product_category;

drop table if exists c2_product_category;

drop index Index_2 on c2_product_category_rs;

drop index Index_1 on c2_product_category_rs;

drop table if exists c2_product_category_rs;

/*==============================================================*/
/* Table: c2_product_category                                   */
/*==============================================================*/
create table c2_product_category
(
   id                   bigint not null auto_increment,
   eshop_id             bigint default 1,
   type                 tinyint default 0,
   root                 bigint default 0,
   lft                  bigint default 0,
   rgt                  bigint default 0,
   lvl                  int default 0,
   selected             tinyint default 0,
   readonly             tinyint default 0,
   visible              tinyint default 0,
   collapsed            tinyint default 0,
   movable_u            tinyint default 1,
   movable_d            tinyint default 1,
   movable_l            tinyint default 1,
   movable_r            tinyint default 1,
   removable            tinyint default 1,
   removable_all        tinyint default 1,
   disabled             tinyint default 0,
   active               tinyint default 1,
   code                 varchar(255),
   name                 varchar(255),
   label              varchar(255),
   description          text,
   icon                 varchar(255),
   icon_type            tinyint default 1,
   created_by           bigint default 0,
   updated_by           bigint default 0,
   status               tinyint default 1,
   position             int default 0,
   created_at           datetime,
   updated_at           datetime,
   primary key (id)
);

/*==============================================================*/
/* Index: Index_1                                               */
/*==============================================================*/
create index Index_1 on c2_product_category
(
   lft,
   rgt
);

/*==============================================================*/
/* Index: Index_2                                               */
/*==============================================================*/
create index Index_2 on c2_product_category
(
   eshop_id
);

/*==============================================================*/
/* Index: Index_3                                               */
/*==============================================================*/
create index Index_3 on c2_product_category
(
   lvl
);

/*==============================================================*/
/* Index: Index_4                                               */
/*==============================================================*/
create index Index_4 on c2_product_category
(
   type
);

/*==============================================================*/
/* Index: Index_5                                               */
/*==============================================================*/
create index Index_5 on c2_product_category
(
   code
);

/*==============================================================*/
/* Index: Index_6                                               */
/*==============================================================*/
create index Index_6 on c2_product_category
(
   root
);

/*==============================================================*/
/* Table: c2_product_category_rs                                */
/*==============================================================*/
create table c2_product_category_rs
(
   id                   bigint not null auto_increment,
   product_id           bigint not null default 0,
   category_id          bigint not null default 0,
   status               tinyint default 1,
   position             int default 0,
   created_at           datetime,
   updated_at           datetime,
   primary key (id)
);

/*==============================================================*/
/* Index: Index_1                                               */
/*==============================================================*/
create index Index_1 on c2_product_category_rs
(
   product_id
);

/*==============================================================*/
/* Index: Index_2                                               */
/*==============================================================*/
create index Index_2 on c2_product_category_rs
(
   category_id
);

