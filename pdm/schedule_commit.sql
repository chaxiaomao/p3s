/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2019/7/28 23:31:39                           */
/*==============================================================*/


drop index Index_1 on c2_production_commit_note;

drop table if exists c2_production_commit_note;

drop index Index_4 on c2_production_commit_note_item;

drop index Index_3 on c2_production_commit_note_item;

drop index Index_2 on c2_production_commit_note_item;

drop index Index_1 on c2_production_commit_note_item;

drop table if exists c2_production_commit_note_item;

/*==============================================================*/
/* Table: c2_production_commit_note                             */
/*==============================================================*/
create table c2_production_commit_note
(
   id                   bigint unsigned not null auto_increment  comment '',
   type                 tinyint  comment '',
   schedule_id          char(10)  comment '',
   label              varchar(255)  comment '',
   memo                 text  comment '',
   commit_at            datetime  comment '',
   updated_by           bigint  comment '',
   created_by           bigint  comment '',
   state                tinyint(4) default 1  comment '',
   status               tinyint default 1  comment '',
   position             int(11) default 0  comment '',
   updated_at           datetime  comment '',
   created_at           datetime  comment '',
   primary key (id)
);

/*==============================================================*/
/* Index: Index_1                                               */
/*==============================================================*/
create index Index_1 on c2_production_commit_note
(
   schedule_id
);

/*==============================================================*/
/* Table: c2_production_commit_note_item                        */
/*==============================================================*/
create table c2_production_commit_note_item
(
   id                   bigint unsigned not null auto_increment  comment '',
   note_id              char(10)  comment '',
   schedule_id          bigint  comment '',
   product_id           bigint  comment '',
   product_name         varchar(255)  comment '',
   product_sku          varchar(255)  comment '',
   product_label        varchar(255)  comment '',
   product_value        varchar(255)  comment '',
   combination_id       bigint  comment '',
   combination_name     varchar(255)  comment '',
   measure_id           bigint  comment '',
   commit_sum           mediumint(9) default 0  comment '',
   memo                 varchar(255)  comment '',
   state                tinyint  comment '',
   status               tinyint default 1  comment '',
   position             int(11) default 0  comment '',
   created_at           datetime  comment '',
   updated_at           datetime  comment '',
   primary key (id)
);

/*==============================================================*/
/* Index: Index_1                                               */
/*==============================================================*/
create index Index_1 on c2_production_commit_note_item
(
   note_id
);

/*==============================================================*/
/* Index: Index_2                                               */
/*==============================================================*/
create index Index_2 on c2_production_commit_note_item
(
   schedule_id
);

/*==============================================================*/
/* Index: Index_3                                               */
/*==============================================================*/
create index Index_3 on c2_production_commit_note_item
(
   product_id
);

/*==============================================================*/
/* Index: Index_4                                               */
/*==============================================================*/
create index Index_4 on c2_production_commit_note_item
(
   combination_id
);

