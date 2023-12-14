CREATE DATABASE IF NOT EXISTS db_tar3 ;

USE db_tar3;

CREATE TABLE usuarios(
    id_usuario INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR (255) NOT NULL,
    pass VARCHAR (255),
    rol INT NOT NULL,
    correo VARCHAR (255),
    PRIMARY KEY (id_usuario)
);

CREATE TABLE pizzas (
 id_pizza INT NOT NULL AUTO_INCREMENT,
 nombre VARCHAR (255) NOT NULL,
 precio DECIMAL (10,2) NOT NULL,
 coste DECIMAL (10,2) NOT NULL,
 ingredientes VARCHAR (255),
 PRIMARY KEY (id_pizza)   
);

CREATE TABLE pedidos(
id_pedido INT NOT NULL AUTO_INCREMENT,
id_pizza INT NOT NULL,
id_cliente INT NOT NULL,
cantidad INT (2) NOT NULL,
coste DECIMAL (10,2) NOT NULL,
fecha_pedido DATETIME NOT NULL,
PRIMARY KEY (id_pedido),
CONSTRAINT FK_idUser_PeU FOREIGN KEY (id_cliente) REFERENCES usuarios(id_usuario),
CONSTRAINT FK_idPizzaPeP FOREIGN KEY (id_pizza) REFERENCES pizzas(id_pizza)
);

INSERT INTO usuarios (nombre,pass,rol,correo) values 
('usuario', '1234', 1, 'usuario@gmail.com'),
('admin','1234',0,'admin@gmail.com');

INSERT INTO pizzas (nombre, precio, coste, ingredientes) VALUES 
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

INSERT INTO pedidos (id_pizza, id_cliente, cantidad, coste, fecha_pedido)
VALUES (1, 1, 2, 17.98, '2023-11-29 12:30:00');
