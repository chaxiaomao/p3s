/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2019/8/30 11:05:01                           */
/*==============================================================*/


drop index Index_2 on c2_warehouse_note;

drop index Index_1 on c2_warehouse_note;

drop table if exists c2_warehouse_note;

drop index Index_6 on c2_warehouse_note_item;

drop index Index_5 on c2_warehouse_note_item;

drop index Index_4 on c2_warehouse_note_item;

drop index Index_3 on c2_warehouse_note_item;

drop index Index_2 on c2_warehouse_note_item;

drop index Index_1 on c2_warehouse_note_item;

drop table if exists c2_warehouse_note_item;

/*==============================================================*/
/* Table: c2_warehouse_note                                     */
/*==============================================================*/
create table c2_warehouse_note
(
   id                   bigint unsigned not null auto_increment  comment '',
   type                 tinyint(9) default 1  comment '',
   ref_note_id          bigint  comment '',
   ref_note_code        varchar(255)  comment '',
   label              varchar(255)  comment '',
   warehouse_id         bigint  comment '',
   receiver_name        varchar(255)  comment '',
   updated_by           bigint  comment '',
   created_by           bigint  comment '',
   memo                 text  comment '',
   state                tinyint default 1  comment '',
   status               tinyint default 1  comment '',
   position             int(11) default 0  comment '',
   created_at           datetime  comment '',
   updated_at           datetime  comment '',
   primary key (id)
);

/*==============================================================*/
/* Index: Index_1                                               */
/*==============================================================*/
create index Index_1 on c2_warehouse_note
(
   ref_note_code
);

/*==============================================================*/
/* Index: Index_2                                               */
/*==============================================================*/
create index Index_2 on c2_warehouse_note
(
   created_at
);

/*==============================================================*/
/* Table: c2_warehouse_note_item                                */
/*==============================================================*/
create table c2_warehouse_note_item
(
   id                   bigint unsigned not null auto_increment  comment '',
   note_id              bigint  comment '',
   ref_note_id          bigint  comment '',
   product_id           bigint  comment '',
   product_name         varchar(255)  comment '',
   product_sku          varchar(255)  comment '',
   product_label        varchar(255)  comment '',
   product_value        varchar(255)  comment '',
   combination_id       bigint  comment '',
   combination_name     varchar(255)  comment '',
   measure_id           bigint  comment '',
   package_id           bigint  comment '',
   package_name         varchar(255)  comment '',
   pieces               mediumint(9)  comment '',
   number               mediumint(9) default 0  comment '',
   memo                 varchar(255)  comment '',
   status               tinyint default 1  comment '',
   position             int(11) default 0  comment '',
   created_at           datetime  comment '',
   updated_at           datetime  comment '',
   primary key (id)
);

/*==============================================================*/
/* Index: Index_1                                               */
/*==============================================================*/
create index Index_1 on c2_warehouse_note_item
(
   note_id
);

/*==============================================================*/
/* Index: Index_2                                               */
/*==============================================================*/
create index Index_2 on c2_warehouse_note_item
(
   product_id
);

/*==============================================================*/
/* Index: Index_3                                               */
/*==============================================================*/
create index Index_3 on c2_warehouse_note_item
(
   combination_id
);

/*==============================================================*/
/* Index: Index_4                                               */
/*==============================================================*/
create index Index_4 on c2_warehouse_note_item
(
   id
);

/*==============================================================*/
/* Index: Index_5                                               */
/*==============================================================*/
create index Index_5 on c2_warehouse_note_item
(
   package_id
);

/*==============================================================*/
/* Index: Index_6                                               */
/*==============================================================*/
create index Index_6 on c2_warehouse_note_item
(
   ref_note_id
);

