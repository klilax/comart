create table product
(
    productId   int auto_increment
        primary key,
    productName varchar(30) not null,
    category    varchar(30) not null,
    constraint product_productName_uindex
        unique (productName)
);

create table user
(
    id       int auto_increment
        primary key,
    username varchar(30)          null,
    email    varchar(65)          null,
    password varchar(65)          not null,
    role     varchar(10)          not null,
    status   tinyint(1) default 1 not null,
    constraint user_username_uindex
        unique (username)
);

create table admin
(
    userId           int                                 null,
    registrationDate timestamp default CURRENT_TIMESTAMP null,
    firstName        varchar(30)                         not null,
    lastName         varchar(30)                         null,
    constraint admin_userId_uindex
        unique (userId),
    constraint admin_user_id_fk
        foreign key (userId) references user (id)
            on delete cascade
);

create table buyer
(
    userId           int                                 null,
    firstname        varchar(30)                         not null,
    lastname         varchar(30)                         null,
    tinNumber        mediumtext                          null,
    registrationDate timestamp default CURRENT_TIMESTAMP null,
    location         varchar(30)                         null,
    constraint buyer_userId_uindex
        unique (userId),
    constraint buyer_user_id_fk
        foreign key (userId) references user (id)
);

create table message
(
    messageId    int                                 not null
        primary key,
    senderId     int                                 not null,
    receiverId   int                                 not null,
    messageBody  varchar(300)                        not null,
    messageTitle int                                 null,
    timeSent     timestamp default CURRENT_TIMESTAMP null,
    constraint message_user_id_fk
        foreign key (senderId) references user (id),
    constraint message_user_id_fk_2
        foreign key (receiverId) references user (id)
);

create table `order`
(
    orderId       int                                  not null
        primary key,
    buyerId       int                                  not null,
    requestDate   timestamp  default CURRENT_TIMESTAMP null,
    totalPayment  float      default 0                 null,
    paymentStatus tinyint(1) default 0                 null,
    constraint order_orderId_uindex
        unique (orderId),
    constraint order_buyer_userId_fk
        foreign key (buyerId) references buyer (userId)
);

create table vendor
(
    userId           int                                 null,
    vendorName       varchar(30)                         not null,
    tinNumber        int                                 not null,
    registrationDate timestamp default CURRENT_TIMESTAMP null,
    paymentInfo      mediumtext                          null,
    location         varchar(30)                         null,
    constraint vendor_userId_uindex
        unique (userId),
    constraint vendor_user_id_fk
        foreign key (userId) references user (id)
            on delete cascade
);

create table inventory
(
    inventoryId int           not null
        primary key,
    vendorId    int           not null,
    productId   int           not null,
    quantity    int default 0 null,
    price       float         not null,
    constraint inventory_product_productId_fk
        foreign key (productId) references product (productId),
    constraint inventory_vendor_userId_fk
        foreign key (vendorId) references vendor (userId)
);

create index inventory_productId_inventoryId_index
    on inventory (productId, inventoryId);

create table orderdetail
(
    orderId       int                  not null,
    orderDetailId int                  not null
        primary key,
    inventoryId   int                  null,
    quantity      int                  not null,
    status        tinyint(1) default 1 null,
    constraint orderDetail_inventory_inventoryId_fk
        foreign key (inventoryId) references inventory (inventoryId),
    constraint orderDetail_order_orderId_fk
        foreign key (orderId) references `order` (orderId)
);

create table review
(
    inventoryId int                                 not null,
    buyerId     int                                 not null,
    rating      smallint                            null,
    review      varchar(250)                        null,
    date        timestamp default CURRENT_TIMESTAMP null,
    constraint review_pk
        unique (inventoryId, buyerId),
    constraint review_buyer_userId_fk
        foreign key (buyerId) references buyer (userId),
    constraint review_inventory_inventoryId_fk
        foreign key (inventoryId) references inventory (inventoryId)
);

