CREATE TABLE `users`
(
    `id`         INT(11) NOT NULL AUTO_INCREMENT,
    `username`   VARCHAR(32) NOT NULL,
    `password`   TEXT        NOT NULL,
    `created_at` DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `posts`
(
    `id`         INT(11) NOT NULL AUTO_INCREMENT,
    `title`      VARCHAR(255) NOT NULL,
    `perex`      VARCHAR(255) NOT NULL,
    `content`    TEXT         NOT NULL,
    `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `ratings`
(
    `id`         INT         NOT NULL AUTO_INCREMENT,
    `kind`       VARCHAR(32) NOT NULL,
    `post_id`    INT         NOT NULL,
    `user_id`    INT         NOT NULL,
    `created_at` DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE = InnoDB;