CREATE DATABASE db_tar3;

USE db_tar3;

CREATE TABLE usuarios(
    id INT NOT NULL AUTO_INCREMENT,
    usuario VARCHAR (255) NOT NULL,
    pass VARCHAR (255),
    rol INT (1) NOT NULL,
    correo VARCHAR (255),
    PRIMARY KEY (id)
);

CREATE TABLE pizzas (
 id INT NOT NULL AUTO_INCREMENT,
 pizza VARCHAR (255) NOT NULL,
 precio DECIMAL (5,2) NOT NULL,
 coste DECIMAL (5,2) NOT NULL,
 ingredientes VARCHAR (255),
 PRIMARY KEY (id)   
);

INSERT INTO usuarios (usuario,pass,rol,correo) values 
('usuario', '1234', 1, 'usuario@gmail.com'),
('admin','1234',0,'admin@gmail.com');

INSERT INTO pizzas (pizza, precio, coste, ingredientes) VALUES 
('Margherita', 8.99, 3.50, 'Tomato sauce, mozzarella, basil'),
('Pepperoni', 10.99, 4.50, 'Tomato sauce, mozzarella, pepperoni'),
('Vegetarian', 9.99, 4.00, 'Tomato sauce, mozzarella, mushrooms, peppers, onions'),
('Hawaiian', 11.99, 5.00, 'Tomato sauce, mozzarella, ham, pineapple'),
('Meat Lover', 12.99, 6.00, 'Tomato sauce, mozzarella, pepperoni, sausage, bacon'),
('Margarita', 8.49, 3.25, 'Tomato sauce, mozzarella, fresh tomatoes'),
('BBQ Chicken', 13.49, 6.50, 'BBQ sauce, mozzarella, chicken, red onions'),
('Supreme', 14.99, 7.50, 'Tomato sauce, mozzarella, pepperoni, sausage, mushrooms, olives, peppers'),
('Four Cheese', 11.49, 5.50, 'Tomato sauce, mozzarella, parmesan, feta, gorgonzola'),
('Vegan Delight', 10.99, 4.75, 'Tomato sauce, vegan cheese, mushrooms, peppers, olives');

 -- TODO: Finish DB


