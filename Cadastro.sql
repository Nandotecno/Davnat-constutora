-- Criar a tabela cadastro
CREATE TABLE cadastro (
    CustomerID INT PRIMARY KEY,
    Nome VARCHAR(100),
    Birthdate DATE,
    Genero CHAR(1),
    ValorServico DECIMAL(10, 2),
    EnderecoEmail VARCHAR(100)
);

-- Inserir os valores na tabela
INSERT INTO cadastro (CustomerID, Nome, Birthdate, Genero, ValorServico, EnderecoEmail)
VALUES (1, 'Alice Santos', '2024-08-16', 'F', R$ 3.500.00, 'alice.santos@gmail.com');


