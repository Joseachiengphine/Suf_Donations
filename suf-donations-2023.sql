create table allowed_currencies
(
    currency_code char(3)          not null
        primary key,
    exchange_rate double default 1 not null
)
    engine = InnoDB
    charset = latin1;

create table campaign_participations
(
    id               bigint unsigned auto_increment
        primary key,
    participation_id bigint unsigned not null,
    merchant_id      varchar(255)    not null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table campaigns
(
    campaign_name        varchar(100)         not null
        primary key,
    display_narative_box tinyint(1)           not null,
    default_option       tinyint(1) default 0 not null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table cellulant_responses
(
    cellulantResponseID      bigint auto_increment
        primary key,
    checkOutRequestID        varchar(50)      not null,
    merchantTransactionID    varchar(50)      not null,
    requestStatusCode        varchar(4)       not null,
    requestStatusDescription text             not null,
    MSISDN                   varchar(16)      not null,
    serviceCode              varchar(64)      not null,
    accountNumber            varchar(64)      not null,
    currencyCode             varchar(3)       not null,
    amountPaid               double default 0 not null,
    requestCurrencyCode      varchar(3)       not null,
    requestAmount            double default 0 not null,
    requestDate              varchar(50)      not null,
    payments                 text             not null,
    creation_date            datetime         not null,
    last_update              datetime         not null
)
    engine = InnoDB
    charset = latin1;

create table donation_requests
(
    merchantID         varchar(50)  not null
        primary key,
    firstName          varchar(50)  not null,
    lastName           varchar(50)  not null,
    country            varchar(50)  not null,
    city               varchar(50)  not null,
    email              varchar(50)  not null,
    zipCode            varchar(50)  not null,
    currency           varchar(3)   not null,
    company            varchar(70)  null,
    salutation         char(6)      not null,
    phoneNumber        varchar(15)  not null,
    requestDescription text         not null,
    creation_date      datetime     not null,
    last_update        datetime     not null,
    job_title          varchar(150) null,
    graduation_class   varchar(60)  null,
    campaign           varchar(255) null,
    relation           varchar(255) null,
    student_number     varchar(191) null,
    shirt_size         varchar(191) null
)
    engine = InnoDB
    charset = latin1;

create table donations
(
    donation_code              varchar(50)   not null
        primary key,
    donation_description       text          not null,
    service_code               varchar(64)   not null,
    country_code               char(2)       not null,
    lang                       char(2)       not null,
    success_redirect_url       text          not null,
    fail_redirect_url          text          not null,
    payment_web_hook           text          not null,
    due_date_duration_in_hours int default 1 not null,
    page_title                 varchar(50)   not null,
    access_key                 varchar(64)   not null,
    account_nbr                varchar(64)   not null,
    secret_key                 varchar(64)   not null,
    init_vector                varchar(64)   not null,
    checkout_url               text          not null,
    default_campaign           varchar(255)  not null,
    default_relation           varchar(255)  not null
)
    engine = InnoDB
    charset = latin1;

create table failed_jobs
(
    id         bigint unsigned auto_increment
        primary key,
    uuid       varchar(255)                        not null,
    connection text                                not null,
    queue      text                                not null,
    payload    longtext                            not null,
    exception  longtext                            not null,
    failed_at  timestamp default CURRENT_TIMESTAMP not null,
    constraint failed_jobs_uuid_unique
        unique (uuid)
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table graduation_classes
(
    graduation_key         varchar(60) not null
        primary key,
    graduation_description text        not null
)
    engine = InnoDB
    charset = latin1;

create table matching_donors
(
    id         bigint unsigned auto_increment
        primary key,
    name       varchar(255)         not null,
    details    varchar(255)         null,
    amount     double               null,
    active     tinyint(1) default 1 not null,
    created_at timestamp            null,
    updated_at timestamp            null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table migrations
(
    id        int unsigned auto_increment
        primary key,
    migration varchar(255) not null,
    batch     int          not null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table participation_options
(
    id          bigint unsigned auto_increment
        primary key,
    name        varchar(255) not null,
    description varchar(255) not null,
    created_at  timestamp    null,
    updated_at  timestamp    null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table password_reset_tokens
(
    email      varchar(255) not null
        primary key,
    token      varchar(255) not null,
    created_at timestamp    null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table permissions
(
    id         bigint unsigned auto_increment
        primary key,
    name       varchar(255) not null,
    guard_name varchar(255) not null,
    created_at timestamp    null,
    updated_at timestamp    null,
    constraint permissions_name_guard_name_unique
        unique (name, guard_name)
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table model_has_permissions
(
    permission_id bigint unsigned not null,
    model_type    varchar(255)    not null,
    model_id      bigint unsigned not null,
    primary key (permission_id, model_id, model_type),
    constraint model_has_permissions_permission_id_foreign
        foreign key (permission_id) references permissions (id)
            on delete cascade
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create index model_has_permissions_model_id_model_type_index
    on model_has_permissions (model_id, model_type);

create table personal_access_tokens
(
    id             bigint unsigned auto_increment
        primary key,
    tokenable_type varchar(255)    not null,
    tokenable_id   bigint unsigned not null,
    name           varchar(255)    not null,
    token          varchar(64)     not null,
    abilities      text            null,
    last_used_at   timestamp       null,
    expires_at     timestamp       null,
    created_at     timestamp       null,
    updated_at     timestamp       null,
    constraint personal_access_tokens_token_unique
        unique (token)
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create index personal_access_tokens_tokenable_type_tokenable_id_index
    on personal_access_tokens (tokenable_type, tokenable_id);

create table relations
(
    relation_name         varchar(100) not null
        primary key,
    display_graduation_yr tinyint(1)   not null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table roles
(
    id         bigint unsigned auto_increment
        primary key,
    name       varchar(255) not null,
    guard_name varchar(255) not null,
    created_at timestamp    null,
    updated_at timestamp    null,
    constraint roles_name_guard_name_unique
        unique (name, guard_name)
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table model_has_roles
(
    role_id    bigint unsigned not null,
    model_type varchar(255)    not null,
    model_id   bigint unsigned not null,
    primary key (role_id, model_id, model_type),
    constraint model_has_roles_role_id_foreign
        foreign key (role_id) references roles (id)
            on delete cascade
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create index model_has_roles_model_id_model_type_index
    on model_has_roles (model_id, model_type);

create table role_has_permissions
(
    permission_id bigint unsigned not null,
    role_id       bigint unsigned not null,
    primary key (permission_id, role_id),
    constraint role_has_permissions_permission_id_foreign
        foreign key (permission_id) references permissions (id)
            on delete cascade,
    constraint role_has_permissions_role_id_foreign
        foreign key (role_id) references roles (id)
            on delete cascade
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table salutations
(
    title varchar(5) not null
        primary key
)
    engine = InnoDB
    charset = latin1;

create table settings
(
    id         bigint unsigned auto_increment
        primary key,
    slug       varchar(191) not null,
    name       varchar(191) not null,
    payload    text         null,
    created_at timestamp    null,
    updated_at timestamp    null,
    constraint settings_name_unique
        unique (name),
    constraint settings_slug_unique
        unique (slug)
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table vcrun_registrations
(
    id                  bigint unsigned auto_increment
        primary key,
    request_merchant_id varchar(50)                           not null comment 'references merchantID on donation_requests',
    participation_type  enum ('PHYSICAL', 'VIRTUAL')          not null,
    race_kms            double                                not null,
    registration_amount double default 1000                   null,
    status              enum ('PENDING', 'PAID', 'CANCELLED') not null,
    matching_donor_id   bigint unsigned                       null,
    matched_amount      double                                null,
    created_at          timestamp                             null,
    updated_at          timestamp                             null,
    paid_amount         double default 0                      not null,
    constraint vcrun_registrations_matching_donor_id_foreign
        foreign key (matching_donor_id) references matching_donors (id)
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table vcrun_supporters
(
    id                      bigint unsigned auto_increment
        primary key,
    supported_registrant_id bigint unsigned                       null,
    request_merchant_id     varchar(50)                           not null comment 'references the donation_requests table',
    support_amount          double                                not null,
    status                  enum ('PENDING', 'PAID', 'CANCELLED') not null,
    created_at              timestamp                             null,
    updated_at              timestamp                             null,
    paid_amount             double default 0                      not null,
    constraint vcrun_supporters_supported_registrant_id_foreign
        foreign key (supported_registrant_id) references vcrun_registrations (id)
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;


