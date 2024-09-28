/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2019/7/22 20:39:20                           */
/*==============================================================*/


drop index Index_3 on c2_production_item_consumption;

drop index Index_2 on c2_production_item_consumption;

drop index Index_1 on c2_production_item_consumption;

drop table if exists c2_production_item_consumption;

drop index Index_4 on c2_production_schedule;

drop index Index_3 on c2_production_schedule;

drop index Index_2 on c2_production_schedule;

drop index Index_1 on c2_production_schedule;

drop table if exists c2_production_schedule;

drop index Index_8 on c2_production_schedule_item;

drop index Index_7 on c2_production_schedule_item;

drop index Index_6 on c2_production_schedule_item;

drop index Index_5 on c2_production_schedule_item;

drop index Index_4 on c2_production_schedule_item;

drop index Index_3 on c2_production_schedule_item;

drop index Index_2 on c2_production_schedule_item;

drop index Index_1 on c2_production_schedule_item;

drop table if exists c2_production_schedule_item;

/*==============================================================*/
/* Table: c2_production_item_consumption                        */
/*==============================================================*/
create table c2_production_item_consumption
(
   id                   bigint unsigned not null auto_increment,
   schedule_id          bigint,
   schedule_item_id     bigint,
   need_product_id      bigint,
   need_product_sku     varchar(255),
   need_product_name    varchar(255),
   need_product_label   varchar(255),
   need_product_value   varchar(255),
   need_number          float(6) default 0,
   need_sum             float(6) default 0,
   memo                 varchar(255),
   state                tinyint,
   status               tinyint default 1,
   position             int(11) default 0,
   created_at           datetime,
   updated_at           datetime,
   primary key (id)
);

/*==============================================================*/
/* Index: Index_1                                               */
/*==============================================================*/
create index Index_1 on c2_production_item_consumption
(
   schedule_id
);

/*==============================================================*/
/* Index: Index_2                                               */
/*==============================================================*/
create index Index_2 on c2_production_item_consumption
(
   schedule_item_id
);

/*==============================================================*/
/* Index: Index_3                                               */
/*==============================================================*/
create index Index_3 on c2_production_item_consumption
(
   need_product_id
);

/*==============================================================*/
/* Table: c2_production_schedule                                */
/*==============================================================*/
create table c2_production_schedule
(
   id                   bigint unsigned not null auto_increment,
   type                 tinyint,
   code                 varchar(255) default NULL,
   label              varchar(255),
   dept_manager_name    varchar(255),
   financial_name       varchar(255),
   occurrence_date      datetime,
   occomplish_date      datetime,
   memo                 varchar(255),
   updated_by           bigint,
   created_by           bigint,
   state                tinyint(4) default 1,
   status               tinyint default 1,
   position             int(11) default 0,
   updated_at           datetime,
   created_at           datetime,
   primary key (id)
);

/*==============================================================*/
/* Index: Index_1                                               */
/*==============================================================*/
create index Index_1 on c2_production_schedule
(
   code
);

/*==============================================================*/
/* Index: Index_2                                               */
/*==============================================================*/
create index Index_2 on c2_production_schedule
(
   occurrence_date
);

/*==============================================================*/
/* Index: Index_3                                               */
/*==============================================================*/
create index Index_3 on c2_production_schedule
(
   occomplish_date
);

/*==============================================================*/
/* Index: Index_4                                               */
/*==============================================================*/
create index Index_4 on c2_production_schedule
(
   state
);

/*==============================================================*/
/* Table: c2_production_schedule_item                           */
/*==============================================================*/
create table c2_production_schedule_item
(
   id                   bigint unsigned not null auto_increment,
   schedule_id          bigint,
   product_id           bigint,
   product_name         varchar(255),
   product_sku          varchar(255),
   product_label        varchar(255),
   product_value        varchar(255),
   combination_id       bigint,
   combination_name     varchar(255),
   package_id           bigint,
   package_name         varchar(255),
   measure_id           bigint,
   production_sum       mediumint(9) default 0,
   bad_number           mediumint(9),
   memo                 varchar(255),
   status               tinyint default 1,
   position             int(11) default 0,
   created_at           datetime,
   updated_at           datetime,
   primary key (id)
);

/*==============================================================*/
/* Index: Index_1                                               */
/*==============================================================*/
create index Index_1 on c2_production_schedule_item
(
   schedule_id
);

/*==============================================================*/
/* Index: Index_2                                               */
/*==============================================================*/
create index Index_2 on c2_production_schedule_item
(
   product_id
);

/*==============================================================*/
/* Index: Index_3                                               */
/*==============================================================*/
create index Index_3 on c2_production_schedule_item
(
   product_name
);

/*==============================================================*/
/* Index: Index_4                                               */
/*==============================================================*/
create index Index_4 on c2_production_schedule_item
(
   product_sku
);

/*==============================================================*/
/* Index: Index_5                                               */
/*==============================================================*/
create index Index_5 on c2_production_schedule_item
(
   product_label
);

/*==============================================================*/
/* Index: Index_6                                               */
/*==============================================================*/
create index Index_6 on c2_production_schedule_item
(
   product_value
);

/*==============================================================*/
/* Index: Index_7                                               */
/*==============================================================*/
create index Index_7 on c2_production_schedule_item
(
   combination_id
);

/*==============================================================*/
/* Index: Index_8                                               */
/*==============================================================*/
create index Index_8 on c2_production_schedule_item
(
   package_id
);

