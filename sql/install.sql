CREATE DATABASE mabagnole;
USE mabagnole;

CREATE TABLE users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(200) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(100) DEFAULT 'client',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT 1  
);

CREATE TABLE category(
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(255) NOT NULL,
    category_description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE vehicle(
    vehicle_id INT PRIMARY KEY AUTO_INCREMENT,
    brand VARCHAR(255) NOT NULL,
    model VARCHAR(255) NOT NULL,
    price_per_day DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    is_available BOOLEAN DEFAULT 1, 
    category_id INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (category_id) REFERENCES category(category_id) ON DELETE SET NULL
);

CREATE TABLE reservation(
    reservation_id INT PRIMARY KEY AUTO_INCREMENT,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    pickup_location VARCHAR(255) NOT NULL,
    return_location VARCHAR(255) NOT NULL,
    reservation_status VARCHAR(50) DEFAULT 'pending',
    user_id INT,
    vehicle_id INT,
    reservation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (vehicle_id) REFERENCES vehicle(vehicle_id) ON DELETE CASCADE
);

CREATE TABLE review(
    review_id INT PRIMARY KEY AUTO_INCREMENT,
    rating INT NOT NULL,
    comment TEXT,
    user_id INT,
    vehicle_id INT,
    review_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    deleted_at DATETIME,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (vehicle_id) REFERENCES vehicle(vehicle_id) ON DELETE CASCADE
);



INSERT INTO category (category_name, category_description) VALUES 
('SUV', 'Spacious vehicles suitable for families and off-road trips'),
('Sedan', 'Comfortable cars for city driving and long distances'),
('Luxury', 'High-end vehicles for special occasions'),
('Economy', 'Fuel-efficient and affordable small cars');



INSERT INTO vehicle (brand, model, price_per_day, image, is_available, category_id) VALUES
('Toyota', 'RAV4', 95.00, 'https://pressroom.toyota.com/wp-content/uploads/2025/05/2026-Toyota-RAV4-PHEV_GRSport_Studio_002-1500x1005.jpg', 1, 1),
('Honda', 'CR-V', 90.00, 'https://di-uploads-pod14.dealerinspire.com/hondaeastcincy/uploads/2025/06/Honda-CR-V-LX.jpg', 1, 1),
('Ford', 'Explorer', 110.00, 'https://vehi.b-cdn.net/models/2025/Ford/Explorer/2025-explorer-st-line.png', 1, 1),
('Nissan', 'Rogue', 85.00, 'https://di-uploads-pod18.dealerinspire.com/walserautomotivegroup/uploads/2023/10/DSC06130.jpg', 1, 1);


INSERT INTO vehicle (brand, model, price_per_day, image, is_available, category_id) VALUES
('Honda', 'Civic', 70.00, 'https://www.bellevuehonda.com/blogs/5487/wp-content/uploads/2024/07/2024-Honda-Civic.png', 1, 2),
('Toyota', 'Camry', 80.00, 'https://hips.hearstapps.com/mtg-prod/65a4c41dadb8a4000836453c/2025-toyota-camry-hybrid-sedan-13.png', 1, 2),
('BMW', '3 Series', 95.00, 'https://images.prestigeonline.com/content/uploads/2018/10/08083509/P90323664_highRes_the-all-new-bmw-3-se.jpg', 1, 2),
('Volkswagen', 'Jetta', 65.00, 'https://di-uploads-pod25.dealerinspire.com/saffordvolkswagen/uploads/2024/05/image-1500x1000-3.png', 1, 2);

INSERT INTO vehicle (brand, model, price_per_day, image, is_available, category_id) VALUES
('Mercedes-Benz', 'S-Class', 250.00, 'https://cdn.motor1.com/images/mgl/LZYyW/s1/2021-mercedes-benz-s-class-feature.webp', 1, 3),
('Audi', 'A8', 220.00, 'https://images.hgmsites.net/med/2025-audi-a8-l-55-tfsi-quattro-angular-front-exterior-view_100962236_m.webp', 1, 3),
('BMW', '7 Series', 280.00, 'https://www.topgear.com/sites/default/files/2023/08/P90492179_highRes_bmw-i7-xdrive60-m-sp%20%281%29.jpg', 1, 3);

INSERT INTO vehicle (brand, model, price_per_day, image, is_available, category_id) VALUES
('Toyota', 'Corolla', 50.00, 'https://toyota-cms-media.s3.amazonaws.com/wp-content/uploads/2020/07/2021-Toyota-Corolla-Apex_008.jpg', 1, 4),
('Hyundai', 'Accent', 45.00, 'https://m.psecn.photoshelter.com/img-get2/I0000ZWSA8CHNZok/fit=700', 1, 4),
('Kia', 'Rio', 48.00, 'https://cimg2.ibsrv.net/ibimg/hgm/1920x1080-1/100/562/new-kia-rio_100562958.jpg', 1, 4),
('Ford', 'Fiesta', 52.00, 'https://cdn.motor1.com/images/mgl/28rKM/s1/ford-fiesta-st-2022.jpg', 1, 4);


-- adding admin account

INSERT INTO users(full_name,email,password,role) VALUES('ilyas','admin@gmail.com','$2y$10$V/w4Kt75wQuzokW9HqsRR.8oDRFZCRR7Rzv1AOlLwEBb2KdJyuF5u','admin');



--- V2 mabagnole

CREATE TABLE themes(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    image VARCHAR(255),
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE articles(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    media VARCHAR(255),
    description TEXT,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    isApproved BOOLEAN DEFAULT 0,
    theme_id INT,

    FOREIGN KEY (theme_id) REFERENCES themes(id)
);


CREATE TABLE tag(
    tagId INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE article_tag(
    articleTagId INT PRIMARY KEY AUTO_INCREMENT,
    tagId INT,
    articleId INT,

    FOREIGN KEY (tagId) REFERENCES tag(tagId),
    FOREIGN KEY (articleId) REFERENCES articles(id)
);

CREATE TABLE favorites(
    favorites INT PRIMARY KEY AUTO_INCREMENT,
    article_id INT,
    user_id INT,

    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (article_id) REFERENCES articles(id)
);

CREATE TABLE comments(
    commentId INT PRIMARY KEY AUTO_INCREMENT,
    content TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    update_at DATETIME DEFAULT NULL,
    user_id INT,
    article_id INT,

    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (article_id) REFERENCES articles(id)
)


ALTER TABLE articles ADD COLUMN author_id INT , ADD FOREIGN KEY (author_id) REFERENCES users(id);