
CREATE TABLE users (
        ID       SERIAL PRIMARY KEY,
        nom VARCHAR NOT NULL,
        prenom VARCHAR NOT NULL,
        pseudo VARCHAR NOT NULL UNIQUE,
        email VARCHAR NOT NULL CHECK (email SIMILAR TO '[a-zA-Z0-9_\-]+@([a-zA-Z0-9_\-]+\.[a-z]{2,4})') UNIQUE,
        password VARCHAR NOT NULL,
        inscriptionDate TIMESTAMP NOT NULL,
        permission INT NOT NULL
);

CREATE TABLE categories(
    ID       SERIAL PRIMARY KEY,
    Nom VARCHAR NOT NULL
);

CREATE TABLE articles(
    ID       SERIAL PRIMARY KEY,
    writer_id INT NOT NULL REFERENCES users(ID),
    text TEXT NOT NULL,
    title VARCHAR NOT NULL,
    publish_date TIMESTAMP NOT NULL,
    image VARCHAR NOT NULL
);

CREATE TABLE comments(
    ID       SERIAL PRIMARY KEY,
    writer_id INT NOT NULL REFERENCES users(ID),
    text TEXT NOT NULL,
    publish_date TIMESTAMP NOT NULL,
    article_id INT REFERENCES articles(ID)
);

CREATE TABLE category (
    article_id INT NOT NULL REFERENCES articles(ID),
    categories INT NOT NULL REFERENCES categories(ID)
)