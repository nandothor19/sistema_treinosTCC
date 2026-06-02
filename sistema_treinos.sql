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
-- TABELA PROGRESSO
-- =========================

CREATE TABLE progresso_treino (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idUsuario INT NOT NULL,
    dia VARCHAR(20),
    exercicio VARCHAR(100),
    data_conclusao DATE,
    FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario)
);

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
  `titulo` VARCHAR(100) NOT NULL,
  `mensagem` VARCHAR(255) NOT NULL,
  `dataEnvio` DATETIME NOT NULL,
  `tipo` VARCHAR(50) NOT NULL,

  PRIMARY KEY (`idNotificacao`)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

-- =========================
-- TABELA NOTIFICAÇÕES Usuários
-- =========================

CREATE TABLE IF NOT EXISTS `notificacoes_usuarios` (
   `id` INT NOT NULL AUTO_INCREMENT,
   `idUsuario` INT NOT NULL,
   `idNotificacao` INT NOT NULL,
   `DataEnvio` DATETIME NOT NULL,
   `lida` BOOLEAN NOT NULL DEFAULT FALSE,
   
   PRIMARY KEY (`id`),
   
     CONSTRAINT fk_notif_usuario
         FOREIGN KEY (idUsuario)
         REFERENCES usuarios(idUsuario),
 
     CONSTRAINT fk_notif_notificacao
         FOREIGN KEY (idNotificacao)
         REFERENCES notificacoes(idNotificacao)
 
 )  ENGINE=InnoDB
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
'Usuario',
'usuario@gmail.com',
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
INSERT INTO Notificacao (titulo, mensagem, dataEnvio, tipo)
VALUES
( 'Hora do Treino', 'Seu treino de hoje está esperando por você. Vamos manter a consistência!', NOW(), 'Lembrete'),
( 'Meta da Semana', 'Você já completou 3 de 5 treinos desta semana. Continue assim!', NOW(), 'Progresso'),
( 'Novo Treino Disponível', 'Seu treinador atualizou sua ficha. Confira as novidades.', NOW(), 'Atualização'),
( 'Recorde Pessoal', 'Parabéns! Você atingiu um novo recorde em um exercício.', NOW(), 'Conquista'),
( 'Não Pare Agora', 'Você está há 2 dias sem registrar treinos. Volte a ativa!', NOW(), 'Reengajamento'),
( 'Treino Concluído', 'Excelente trabalho! Seu treino foi registrado com sucesso.', NOW(), 'Confirmação'),
( 'Desafio Semanal', 'Participe do desafio desta semana e acumule pontos extras.', NOW(), 'Campanha'),
( 'Série de Treinos', 'Você completou 7 dias consecutivos de treino. Continue firme!', NOW(), 'Conquista'),
( 'Hora de se Hidratar', 'Não esqueça de beber água antes, durante e após o treino.', NOW(), 'Saúde'),
( 'Avaliação Física', 'Está na hora de atualizar suas medidas e acompanhar sua evolução.', NOW(), 'Lembrete'),
( 'Treino de Hoje', 'Seu plano para hoje já está disponível. Confira os exercícios.', NOW(), 'Lembrete'),
( 'Objetivo Próximo', 'Você está a apenas 10% de atingir sua meta mensal.', NOW(), 'Progresso'),
( 'Evolução Detectada', 'Sua carga média aumentou nas últimas semanas. Parabéns pela evolução!', NOW(), 'Progresso'),
( 'Descanso Também Conta', 'Hoje é dia de recuperação. Aproveite para descansar e se recuperar.', NOW(), 'Saúde'),
( 'Treino Perdido', 'Sentimos sua falta ontem. Que tal retomar hoje?', NOW(), 'Reengajamento'),
( 'Nova Funcionalidade', 'Acabamos de lançar uma novidade para melhorar seus treinos. Confira!', NOW(), 'Sistema'),
( 'Meta Atingida', 'Você alcançou sua meta de treinos do mês. Parabéns!', NOW(), 'Conquista'),
( 'Atualize seu Peso', 'Registre seu peso atual para manter seu progresso atualizado.', NOW(), 'Lembrete'),
( 'Academia Lotada?', 'Treine em horários alternativos para uma melhor experiência.', NOW(), 'Informativo'),
( 'Treino Rápido Disponível', 'Sem tempo hoje? Experimente nosso treino expresso de 20 minutos.', NOW(), 'Sugestão'),
( 'Aniversário Fitness', 'Você completou mais um mês de jornada fitness. Parabéns pela dedicação!', NOW(), 'Conquista'),
( 'Faltam Poucos Exercícios', 'Você está quase terminando o treino de hoje. Continue!', NOW(), 'Motivacional'),
( 'Sua Frequência Melhorou', 'Sua frequência aumentou em relação ao mês passado. Excelente trabalho!', NOW(), 'Progresso'),
( 'Convite para Desafio', 'Convide amigos para participar do desafio e ganhem recompensas.', NOW(), 'Social'),
( 'Hora de Alongar', 'Reserve alguns minutos para alongamento e prevenção de lesões.', NOW(), 'Saúde'),
( 'Check-in Realizado', 'Seu check-in na academia foi registrado com sucesso.', NOW(), 'Confirmação'),
( 'Semana Perfeita', 'Você completou todos os treinos planejados para esta semana.', NOW(), 'Conquista'),
( 'Foco no Objetivo', 'Cada treino te aproxima da sua meta. Continue avançando!', NOW(), 'Motivacional'),
( 'Feedback do Treino', 'Como foi o treino de hoje? Avalie sua experiência.', NOW(), 'Engajamento'),
( 'Bem-vindo de Volta', 'Que bom ter você de volta! Vamos continuar sua evolução.', NOW(), 'Reengajamento');


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