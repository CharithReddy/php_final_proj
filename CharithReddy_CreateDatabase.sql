drop database if exists final_proj;

create database final_proj;

use final_proj;

create table cars(
	carID int primary key auto_increment,
    carName VARCHAR(20),
    carDescription VARCHAR(300),
    quantityAvailable int,
    price decimal(8, 2),
    fuelType VARCHAR(10),
    driveType VARCHAR(5),
    discount decimal(7, 2),
    constraint fuel_ck check (fuelType in ('Gas', 'Electric', 'Hybrid')),
    constraint drive_ck check (driveType in ('AWD', 'FWD', 'RWD'))
);

create table customer(
    first_name VARCHAR(50),
    last_name  VARCHAR(50),
    username	varchar(20) primary key,
    password 	varchar(20),
    phone_no   decimal(10, 0)
);

create table roles(
    username varchar(20) primary key,
    role varchar(10) check (role in ("admin", "customer")),
    foreign key (username) references customer(username)
);

create table orders(
	username varchar(20),
    carID  int,
    sale_date date,
    total_price	decimal(8, 2),
    discount decimal(7, 2),
    price_paid decimal(8, 2),
    foreign key (username) references customer(username),
    foreign key (carID) references cars(carID)
);

INSERT INTO cars (carName, carDescription, quantityAvailable, price, fuelType, driveType, discount)
VALUES 
('Tesla Model S', 
'The Tesla Model S is a fast electric sedan with modern features and long range.',
10, 79999.99, 'Electric', 'AWD', 5000.00),
('Ford Mustang', 
'The Ford Mustang is a classic muscle car with a powerful engine and sleek design.',
5, 55999.50, 'Gas', 'RWD', 1000.00),
('Toyota Prius', 
'The Toyota Prius is a hybrid vehicle known for its exceptional fuel efficiency and eco-friendliness.',
12, 25999.99, 'Hybrid', 'FWD', 200.00),
('Chevrolet Bolt EV', 
'The Chevrolet Bolt EV is a compact, fully electric vehicle with excellent range and efficiency.',
7, 36999.99, 'Electric', 'FWD', 1200.00),
('BMW X5', 
'The BMW X5 is a luxurious midsize SUV offering powerful performance and advanced features.',
6, 75999.00, 'Gas', 'AWD', 5670.00),
('Honda Civic', 
'The Honda Civic is a practical, fuel-efficient compact car ideal for daily commuting.',
15, 23999.95, 'Gas', 'FWD', 50.00),
('Subaru Outback', 
'The Subaru Outback is an all-terrain wagon with AWD and excellent off-road capabilities.',
8, 34999.50, 'Gas', 'AWD', 530.50),
('Nissan Leaf', 
'The Nissan Leaf is an affordable electric car with modern features and solid range.',
9, 31999.99, 'Electric', 'FWD', 1000.99);

INSERT INTO customer (first_name, last_name, username, password, phone_no) 
VALUES
('Admin', 'Admin', 'admin', 'admin', '1234567890'),
('John', 'Doe', 'johndoe', 'password123', 9876543210),
('Jane', 'Smith', 'janesmith', 'securepass', 9123456789),
('Alice', 'Brown', 'aliceb', 'alicepass', 9234567890),
('Bob', 'Johnson', 'bobj', 'bobsecure', 9345678901),
('Charlie', 'Davis', 'charlied', 'charliepwd', 9456789012),
('Diana', 'Wilson', 'dianaw', 'diana123', 9567890123),
('Evan', 'Miller', 'evanm', 'evansecure', 9678901234),
('Fiona', 'Taylor', 'fionat', 'fiona456', 9789012345),
('George', 'Anderson', 'georgea', 'georgepwd', 9890123456),
('Hannah', 'Moore', 'hannahm', 'hannahpass', 9901234567);

INSERT INTO roles 
select username, "customer" 
from customer 
where username != 'admin';

insert into roles values ('admin', 'admin');

INSERT INTO orders (username, carID, sale_date, total_price, discount, price_paid) 
VALUES
('johndoe', 1, '2024-11-01', 79999.99, 500.00, 74999.99),
('janesmith', 2, '2024-11-02', 55999.50, 2000.00, 53999.50),
('aliceb', 3, '2024-11-03', 25999.99, 1000.00, 24999.99),
('bobj', 4, '2024-11-04', 36999.99, 1500.00, 35499.99),
('charlied', 5, '2024-11-05', 75999.00, 3000.00, 72999.00),
('dianaw', 6, '2024-11-06', 23999.95, 500.00, 23499.95),
('evanm', 7, '2024-11-07', 34999.50, 1000.00, 33999.50),
('fionat', 8, '2024-11-08', 31999.99, 1200.00, 30799.99),
('georgea', 1, '2024-11-09', 79999.99, 8000.00, 71999.99),
('johndoe', 3, '2024-11-10', 25999.99, 1500.00, 24499.99),
('aliceb', 5, '2024-11-11', 75999.00, 2500.00, 73499.00),
('janesmith', 7, '2024-11-12', 34999.50, 500.00, 34499.50),
('charlied', 6, '2024-11-13', 23999.95, 1000.00, 22999.95),
('dianaw', 4, '2024-11-14', 36999.99, 700.00, 36299.99),
('evanm', 2, '2024-11-15', 55999.50, 1500.00, 54499.50);

select * from cars;

select * from roles;

select * from customer;

