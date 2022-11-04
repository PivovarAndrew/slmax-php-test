CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) CHECK (name RLIKE'^[[:alpha:]]+$'),
    surname VARCHAR(30) CHECK (surname RLIKE'^[[:alpha:]]+$'),
    date_of_birthday DATE,
    sex BOOLEAN,
    city_of_birth VARCHAR(30)
);
