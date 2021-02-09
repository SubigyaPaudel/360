CREATE TABLE subs_account ( 
    email VARCHAR(50) NOT NULL UNIQUE,
    username VARCHAR(40),
    sub_pass VARCHAR(60),
    PRIMARY KEY (email)
);

CREATE TABLE premium_user ( 
    email VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY (email)
);

CREATE TABLE regular_user(  
    email VARCHAR(50) NOT NULL UNIQUE,
    number_of_general_accounts INTEGER
);

CREATE TABLE general_account (  
    email CHAR(50) NOT NULL,
    website CHAR(60) NOT NULL,
    service_description VARCHAR(1000),
    PRIMARY KEY(email,website)
);

CREATE TABLE details (
    detail_id INTEGER NOT NULL UNIQUE AUTO_INCREMENT,
    PRIMARY KEY (detail_id)
);

CREATE TABLE account_deletion(  
    detail_id INTEGER NOT NULL UNIQUE,
    deletion_link VARCHAR(3000),
    FOREIGN KEY (detail_id) REFERENCES details (detail_id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (detail_id)
);

CREATE TABLE data_usage (  
    detail_id INTEGER,
    terms_cond_last_updates DATE,
    link_relevant_page VARCHAR(3000),
    FOREIGN KEY (detail_id) REFERENCES details (detail_id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (detail_id)
);

CREATE TABLE general_account_payment_details( 
    updates_and_messages VARCHAR(5000),
    detail_id INTEGER,
    FOREIGN KEY (detail_id) REFERENCES details (detail_id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (detail_id)
);

CREATE TABLE music_streaming( 
    email CHAR(50) NOT NULL REFERENCES general_account (email) ON DELETE CASCADE,
    website CHAR(60) NOT NULL REFERENCES general_account (website) ON DELETE CASCADE,
    link_to_upcoming_content VARCHAR(3000),
    link_to_latest_releases VARCHAR(3000),
    PRIMARY KEY (email, website)
);

CREATE TABLE video_streaming( 
    email CHAR(50) NOT NULL REFERENCES general_account (email) ON DELETE CASCADE ON UPDATE CASCADE,
    website CHAR(60) NOT NULL REFERENCES general_account (website) ON DELETE CASCADE ON UPDATE CASCADE,
    link_to_upcoming VARCHAR(3000),
    link_to_latest_release VARCHAR(3000),
    max_devices INTEGER,
    No_of_videos INTEGER,
    PRIMARY KEY (email, website)
);

CREATE TABLE magazine(
    email CHAR(50) NOT NULL REFERENCES general_account (email) ON DELETE CASCADE ON UPDATE CASCADE,
    website CHAR(60) NOT NULL REFERENCES general_account (website) ON DELETE CASCADE ON UPDATE CASCADE,
    sub_type TINYINT,
    link_to_latest_release VARCHAR(3000),
    PRIMARY KEY (email, website)
);

CREATE TABLE software_suite(
    email CHAR(50) NOT NULL REFERENCES general_account (email) ON DELETE CASCADE ON UPDATE CASCADE,
    website CHAR(60) NOT NULL REFERENCES general_account (website) ON DELETE CASCADE ON UPDATE CASCADE,
    expire_date DATE,
    PRIMARY KEY (email, website)
);

CREATE TABLE VPN( 
    email CHAR(50) NOT NULL REFERENCES general_account (email) ON DELETE CASCADE ON UPDATE CASCADE,
    website CHAR(60) NOT NULL REFERENCES general_account (website) ON DELETE CASCADE ON UPDATE CASCADE,
    No_of_devices INTEGER,
    locations VARCHAR(3000),
    PRIMARY KEY (email, website)
);

CREATE TABLE related_account (
    email_s CHAR(50) NOT NULL REFERENCES subs_account (email) ON DELETE CASCADE ON UPDATE CASCADE,
    email_g CHAR(50) NOT NULL REFERENCES general_account (email) ON DELETE CASCADE ON UPDATE CASCADE,
    website CHAR(60) REFERENCES general_account (website) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (email_s, email_g, website)
);

CREATE TABLE account_details ( 
    detail_id INTEGER NOT NULL REFERENCES details (detail_id) ON DELETE CASCADE ON UPDATE CASCADE,
    email CHAR(50) NOT NULL REFERENCES general_account (email) ON DELETE CASCADE ON UPDATE CASCADE,
    website CHAR(20) REFERENCES general_account (website) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (detail_id, email, website)
);

CREATE TABLE bank_transfer(  
    IBAN VARCHAR(40),
    bank_name VARCHAR(100),
    BIC VARCHAR(11),
    PRIMARY KEY (IBAN)
);

CREATE TABLE credit_card( 
    account_owner_name VARCHAR(100),
    credit_card_no VARCHAR(25),
    PRIMARY KEY (credit_card_no)
);

CREATE TABLE paypal(  
    email VARCHAR(150),
    PRIMARY KEY (email)
);

CREATE TABLE payment_details(  
    entrynumber INTEGER AUTO_INCREMENT,
    next_payment_date DATE,
    payment_amount float(15),
    PRIMARY KEY (entrynumber)
);

CREATE TABLE payment_means (
    entrynumber INTEGER NOT NULL,
    paypal_email VARCHAR(150) ,
    IBAN CHAR(40),
    email VARCHAR(150),
    credit_card_no VARCHAR(25),
    FOREIGN KEY (entrynumber) REFERENCES payment_details (entrynumber) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IBAN) REFERENCES bank_transfer (IBAN) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (credit_card_no) REFERENCES credit_card (credit_card_no) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (entrynumber)
);

CREATE TABLE subs_payment_method( 
    email VARCHAR(50) NOT NULL UNIQUE,
    payment_details INTEGER UNIQUE,
    FOREIGN KEY (email) REFERENCES subs_account (email) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (payment_details) REFERENCES payment_details (entrynumber) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (email)
);

CREATE TABLE payment_links(
    detail_id INTEGER,
    FOREIGN KEY (detail_id) REFERENCES general_account_payment_details (detail_id) ON DELETE CASCADE ON UPDATE CASCADE,
    payment_details_entry INTEGER,
    FOREIGN KEY (payment_details_entry) REFERENCES payment_details (entrynumber) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (detail_id, payment_details_entry)
);

CREATE TABLE admin_users(
    username VARCHAR(40),
    password VARCHAR(60),
    PRIMARY KEY (username)
);
