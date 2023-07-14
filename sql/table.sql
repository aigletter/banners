CREATE TABLE `banner_views` (
    `ip_address` varchar(255) NOT NULL,
    `user_agent` varchar(255) NOT NULL,
    `view_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `page_url` varchar(255) NOT NULL,
    `views_count` int NOT NULL DEFAULT '1',
    PRIMARY KEY (`ip_address`,`user_agent`,`page_url`)
)