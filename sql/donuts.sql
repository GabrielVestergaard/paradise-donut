-- Paradise Donut: table + starter data
-- Safe to run more than once.

CREATE TABLE IF NOT EXISTS donuts (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL UNIQUE,
    category   VARCHAR(50)  NOT NULL,
    image      VARCHAR(255) NOT NULL,
    available  BOOLEAN      NOT NULL DEFAULT TRUE
);

INSERT IGNORE INTO donuts (name, category, image) VALUES
    ('Paradise Glazed',         'Glazed',    'paradise-glazed.jpg'),
    ('Honey Hibiscus Glazed',   'Glazed',    'honey-hibiscus.jpg'),
    ('Maple Sunset',            'Glazed',    'maple-sunset.jpg'),
    ('Mango Sunrise',           'Filled',    'mango-sunrise.jpg'),
    ('Passionfruit Cream',      'Filled',    'passionfruit-cream.jpg'),
    ('Strawberry Lagoon',       'Filled',    'strawberry-lagoon.jpg'),
    ('Toasted Coconut',         'Cake',      'toasted-coconut.jpg'),
    ('Banana Bread Cake',       'Cake',      'banana-bread.jpg'),
    ('Pineapple Upside-Down',   'Cake',      'pineapple-upside-down.jpg'),
    ('Volcano Chocolate',       'Chocolate', 'volcano-chocolate.jpg'),
    ('Chocolate Palm Sprinkle', 'Chocolate', 'chocolate-sprinkle.jpg'),
    ('Midnight Cocoa Kreme',    'Chocolate', 'midnight-cocoa.jpg');