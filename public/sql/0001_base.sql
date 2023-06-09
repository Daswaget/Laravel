CREATE TABLE books (
    id INT NOT NULL AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    text TEXT NOT NULL,
    name VARCHAR(30) NOT NULL,
    link_access TINYINT(1) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE comments (
    id INT NOT NULL AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    place VARCHAR(255) NOT NULL,
    header VARCHAR(35) NOT NULL,
    text TEXT NOT NULL,
    removed TINYINT(1) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE libraries (
    id INT NOT NULL AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE library_access (
    id INT NOT NULL AUTO_INCREMENT,
    library_id INT NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (library_id) REFERENCES libraries(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE responses (
    id INT NOT NULL AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    comment_id INT NOT NULL,
    header VARCHAR(35) NOT NULL,
    text TEXT NOT NULL,
    removed TINYINT(1) NOT NULL,
    FOREIGN KEY (comment_id) REFERENCES comments(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

create table if not exists `versions` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;