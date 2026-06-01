CREATE SCHEMA IF NOT EXISTS `sistema_treinos` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sistema_treinos`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- =========================
-- TABELA ADMINISTRADOR
-- =========================
CREATE TABLE IF NOT EXISTS `administrador` (
  `idAdministrador` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,

  PRIMARY KEY (`idAdministrador`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

-- =========================
-- TABELA USUÁRIOS
-- =========================

CREATE TABLE IF NOT EXISTS `usuarios` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `idade` INT DEFAULT NULL,
  `sexo` VARCHAR(20) DEFAULT NULL,
  `peso` DOUBLE(5,2) DEFAULT NULL,
  `altura` DECIMAL(4,2) DEFAULT NULL,
  `nivelExperiencia` VARCHAR(30) DEFAULT NULL,
  `objetivo` VARCHAR(50) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `cintura` DOUBLE(5,2) NOT NULL,
  `peito` DOUBLE(5,2) NOT NULL,
  `braco` DOUBLE(5,2) NOT NULL,
  `perna` DOUBLE(5,2) NOT NULL,

  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_medidas_usuario_idx` (`idUsuario`)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

-- =========================
-- TABELA EXERCÍCIOS
-- =========================

CREATE TABLE IF NOT EXISTS `exercicios` (
  `idExercicio` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `grupoMuscular` VARCHAR(50) NOT NULL,
  `series` INT NOT NULL,
  `repeticoes` INT NOT NULL,
  `descricao` VARCHAR(255) DEFAULT NULL,

  PRIMARY KEY (`idExercicio`)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

-- =========================
-- TABELA PLANO TREINO
-- =========================

CREATE TABLE IF NOT EXISTS `plano_treino` (
  `idPlano` INT NOT NULL AUTO_INCREMENT,
  `idUsuario` INT NOT NULL,
  `dataInicio` DATE NOT NULL,
  `dataFim` DATE NOT NULL,
  `tipoTreino` VARCHAR(50) NOT NULL,
  `intensidade` VARCHAR(30) NOT NULL,

  PRIMARY KEY (`idPlano`),

  KEY `fk_plano_usuario_idx` (`idUsuario`),

  CONSTRAINT `fk_plano_usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `usuarios` (`idUsuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

-- =========================
-- TABELA PLANO EXERCÍCIOS
-- =========================

CREATE TABLE IF NOT EXISTS `plano_exercicios` (
  `idPlanoExercicio` INT NOT NULL AUTO_INCREMENT,
  `idPlano` INT NOT NULL,
  `idExercicio` INT NOT NULL,
  `diaSemana` VARCHAR(20) NOT NULL,
  `observacoes` VARCHAR(255) DEFAULT NULL,

  PRIMARY KEY (`idPlanoExercicio`),

  KEY `fk_planoex_plano_idx` (`idPlano`),
  KEY `fk_planoex_exercicio_idx` (`idExercicio`),

  CONSTRAINT `fk_planoex_plano`
    FOREIGN KEY (`idPlano`)
    REFERENCES `plano_treino` (`idPlano`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

  CONSTRAINT `fk_planoex_exercicio`
    FOREIGN KEY (`idExercicio`)
    REFERENCES `exercicios` (`idExercicio`)
    ON DELETE CASCADE
    ON UPDATE CASCADE

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

-- ========================
-- TABELA HISTÓRICO TREINO
-- ========================

CREATE TABLE IF NOT EXISTS `historico_treino` (
  `idHistorico` INT NOT NULL AUTO_INCREMENT,
  `idUsuario` INT NOT NULL,
  `idPlano` INT NOT NULL,
  `dataRealizacao` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `observacoes` VARCHAR(255) DEFAULT NULL,

  PRIMARY KEY (`idHistorico`),

  KEY `fk_hist_usuario_idx` (`idUsuario`),
  KEY `fk_hist_plano_idx` (`idPlano`),

  CONSTRAINT `fk_hist_usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `usuarios` (`idUsuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

  CONSTRAINT `fk_hist_plano`
    FOREIGN KEY (`idPlano`)
    REFERENCES `plano_treino` (`idPlano`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

-- =========================
-- TABELA NOTIFICAÇÕES
-- =========================

CREATE TABLE IF NOT EXISTS `notificacoes` (
  `idNotificacao` INT NOT NULL AUTO_INCREMENT,
  `idUsuario` INT NOT NULL,
  `titulo` VARCHAR(100) NOT NULL,
  `mensagem` VARCHAR(255) NOT NULL,
  `dataEnvio` DATETIME NOT NULL,
  `tipo` VARCHAR(50) NOT NULL,

  PRIMARY KEY (`idNotificacao`),

  KEY `fk_notificacao_usuario_idx` (`idUsuario`),

  CONSTRAINT `fk_notificacao_usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `usuarios` (`idUsuario`)
    ON DELETE CASCADE
    ON UPDATE CASCADE

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

-- =========================
-- DADOS DE TESTE
-- =========================

INSERT INTO `usuarios`
(`nome`, `email`, `senha`, `idade`, `sexo`, `peso`, `altura`, `nivelExperiencia`, `objetivo`)
VALUES
(
'Miguel',
'miguel@gmail.com',
'$2y$10$j2G/kg2S1tIzytaCGw8mAOJfojPzqBjopR4dZ5a/tFkg9zk0pwZiy',
18,
'Masculino',
75.00,
1.78,
'Intermediário',
'Hipertrofia'
),

(
'Miguel 2',
'miguel2@gmail.com',
'$2y$10$Mqg0fLqlYUPUUdomeIbR/.NKi1ewa0eh03xS1tQKkhN/8SS/mva6.',
20,
'Masculino',
80.00,
1.82,
'Avançado',
'Emagrecimento'
);

INSERT INTO `administrador`
(`nome`, `email`, `senha`)
VALUES
(
'Administrador',
'admin@sistema.com',
'$2y$10$j2G/kg2S1tIzytaCGw8mAOJfojPzqBjopR4dZ5a/tFkg9zk0pwZiy'
);

INSERT INTO `exercicios`
(`nome`, `grupoMuscular`, `series`, `repeticoes`, `descricao`)
VALUES
(
'Supino Reto',
'Peito',
4,
12,
'Exercício para desenvolvimento do peitoral'
),

(
'Agachamento Livre',
'Perna',
4,
10,
'Exercício composto para pernas'
),

(
'Rosca Direta',
'Bíceps',
3,
12,
'Exercício para bícep'
);

COMMIT;

-- Dumping routines for database 'sistema_treinos'
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-20 12:34:24