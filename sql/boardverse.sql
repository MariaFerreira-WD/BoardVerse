-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15-Fev-2026 às 16:53
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `boardverse`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `conteudo`
--

CREATE TABLE `conteudo` (
  `id` int(11) NOT NULL,
  `sobre_nos` varchar(800) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `conteudo`
--

INSERT INTO `conteudo` (`id`, `sobre_nos`) VALUES
(1, 'Os jogos de tabuleiro são uma das melhores desculpas para juntar pessoas, rir um pouco, puxar pela cabeça e criar histórias que ficam para a memória! \r\nNa <b>BoardVerse</b> celebramos tudo isso: o prazer de jogar, de partilhar bons momentos e de passar tempo de qualidade com quem gostamos.\r\nConnosco podes explorar o mundo dos jogos de tabuleiro, desde os clássicos de sempre até às novidades mais entusiasmantes, também vais encontrar sugestões e dicas para escolher o jogo ideal para cada ocasião e ficar a par de todas as novidades do mundo dos jogos de tabuleiro na aba \"Eventos\" para que não te escape nada! Junta-te a nós e descobre o próximo jogo que vai animar as tuas noites com família e amigos!');

-- --------------------------------------------------------

--
-- Estrutura da tabela `encomendas`
--

CREATE TABLE `encomendas` (
  `id_encomenda` int(11) NOT NULL,
  `id_utilizador` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `morada_entrega` varchar(255) NOT NULL,
  `codigo_postal_entrega` varchar(255) NOT NULL,
  `data_encomenda` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `estado` enum('Em processamento','Centro de Distribuicao','Em transito','Entregue') DEFAULT 'Em processamento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `encomendas`
--

INSERT INTO `encomendas` (`id_encomenda`, `id_utilizador`, `nome`, `morada_entrega`, `codigo_postal_entrega`, `data_encomenda`, `total`, `estado`) VALUES
(1, 3, 'teste', 'Figueira da Foz', '', '2026-01-22 17:33:09', 119.97, 'Em processamento'),
(2, 3, 'teste', 'Figueira da Foz', '', '2026-01-22 17:33:25', 119.97, 'Em processamento'),
(3, 3, 'teste', 'Figueira da Foz', '', '2026-02-09 23:19:06', 69.98, 'Em processamento'),
(4, 3, 'teste', 'Rua nao sei o que', '', '2026-02-14 16:48:33', 29.99, 'Em processamento'),
(5, 3, 'teste', 'Rua nao sei o que', '', '2026-02-14 23:20:25', 79.98, 'Em processamento');

-- --------------------------------------------------------

--
-- Estrutura da tabela `encomendas_produtos`
--

CREATE TABLE `encomendas_produtos` (
  `id_encomenda` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `encomendas_produtos`
--

INSERT INTO `encomendas_produtos` (`id_encomenda`, `id_produto`, `quantidade`, `preco`) VALUES
(2, 2, 1, 49.99),
(2, 3, 1, 29.99),
(2, 4, 1, 39.99),
(3, 3, 1, 29.99),
(3, 4, 1, 39.99),
(4, 3, 1, 29.99),
(5, 2, 1, 49.99),
(5, 3, 1, 29.99);

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventos`
--

CREATE TABLE `eventos` (
  `id_evento` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `corpo` text NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `eventos`
--

INSERT INTO `eventos` (`id_evento`, `titulo`, `corpo`, `imagem`, `url`) VALUES
(1, 'SGF - Santarém Game Festival', 'O Santarém Game Festival (SGF) é um festival de videojogos e cultura digital em Santarém, com jogos retro, realidade virtual, torneios, concursos de cosplay e experiências imersivas para escolas, famílias e jovens. Foi organizado pela GAMEscola Portugal e decorre ao longo de vários dias na Casa do Campino.', 'imagens/eventos/sgf.jpg', 'https://www.gamescola.pt/sgf'),
(2, 'LeiriaCon', 'A LeiriaCon é uma convenção anual de jogos de tabuleiro em Leiria, Portugal, que desde 2007 reúne jogadores, famílias e entusiastas para jogar, experimentar protótipos, participar em torneios, workshops e seminários, com convidados nacionais e internacionais.', 'imagens/eventos/leiria_con.jpg', 'https://leiriacon.pt'),
(3, 'TGF - Tomar Game Festival', 'O Tomar Game Festival (TGF) é um evento gratuito de gaming e cultura digital em Tomar (Portugal), com mais de 1.000 m² de atividades como torneios, board games, retro gaming, realidade virtual, concursos de cosplay, meet & greets e workshops, organizado pela GAMEscola Portugal.', 'imagens/eventos/tgf.png', 'https://www.gamescola.pt/tgf'),
(4, 'LGW - Lisboa Games Week', 'A Lisboa Games Week é o maior evento de videojogos e entretenimento em Portugal, reunindo gaming, e‑sports, cosplay, cultura pop e tecnologia, com lançamentos, competições, experiências imersivas e áreas educativas para todos os públicos.', 'imagens/eventos/lgw.png', 'https://lisboagamesweek.pt/');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id_produto` int(11) NOT NULL,
  `nome_produto` varchar(150) NOT NULL,
  `editora` varchar(100) DEFAULT NULL,
  `descricao` varchar(255) NOT NULL,
  `duracao` int(11) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `imagem_2` varchar(255) DEFAULT NULL,
  `quantidade` int(11) DEFAULT 0,
  `preco` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `nome_produto`, `editora`, `descricao`, `duracao`, `imagem`, `imagem_2`, `quantidade`, `preco`) VALUES
(1, 'Azul', 'Next Move Games', 'Azul é um jogo de tabuleiro estratégico onde os jogadores decoram paredes com azulejos coloridos. É preciso escolher peças com cuidado, planear jogadas e evitar desperdícios para marcar mais pontos que os adversários.', 30, 'imagens/produtos/azul.jpg', 'imagens/produtos/azul_1.png', 0, 39.99),
(2, 'Catan', 'KOSMOS', 'Catan é um jogo de tabuleiro estratégico onde os jogadores colonizam uma ilha, trocam recursos e constroem estradas, aldeias e cidades. Cada partida é diferente e incentiva negociação e planeamento.', 60, 'imagens/produtos/catan.png', 'imagens/produtos/catan_1.png', 15, 49.99),
(3, 'Cluedo', 'Hasbro', 'Cluedo é um jogo de tabuleiro de mistério e dedução em que os jogadores investigam um crime, descobrindo quem foi o culpado, com que arma e em que divisão. Ideal para quem gosta de suspense e lógica.', 30, 'imagens/produtos/cluedo.png', 'imagens/produtos/cluedo_1.png', 13, 29.99),
(4, 'Monopólio', 'Parker Brothers', 'Monopólio é um jogo de tabuleiro clássico de estratégia financeira onde os jogadores compram, vendem e negociam propriedades para construir um império imobiliário e levar os adversários à falência.', 60, 'imagens/produtos/monopolio.png', 'imagens/produtos/monopolio_1.png', 9, 39.99),
(5, 'Party & Co', 'Diset S.A', 'Party & Co é um jogo de tabuleiro de festa, rápido e divertido, com desafios de mímica, desenho, perguntas e criatividade. Ideal para grupos e anima qualquer reunião com muitas gargalhadas.', 45, 'imagens/produtos/party.png', 'imagens/produtos/party_1.png', 7, 34.99),
(6, 'Risk', 'Parker Brothers', 'Risk é um jogo de tabuleiro de estratégia e conquista mundial, onde os jogadores comandam exércitos, planeiam ataques e formam alianças para dominar territórios e alcançar a vitória global.', 120, 'imagens/produtos/risk.png', 'imagens/produtos/risk.png.png', 19, 49.99),
(7, 'Taco Gato', 'Dave Campbell II', 'Taco Gato é um jogo de cartas rápido e hilariante, baseado em reflexos e atenção. Os jogadores repetem palavras e batem nas cartas certas no momento exato. Ideal para todas as idades.', 15, 'imagens/produtos/taco_gato.png', 'imagens/produtos/taco_gato_1.png', 16, 15.99),
(8, 'Trivial Pursuit Familia', 'Hasbro', 'Trivial Pursuit Família é um jogo de perguntas e respostas que desafia o conhecimento de todas as idades. Com categorias variadas, combina diversão e aprendizado em partidas rápidas e envolventes para toda a família.', 90, 'imagens/produtos/trivial_pursuit_familia.png', 'imagens/produtos/trivial_pursuit_familia_1.png', 10, 49.99),
(9, 'Uno - No Mercy', 'Next Move Games', 'UNO No Mercy é uma versão intensa do clássico UNO, com regras mais agressivas e cartas especiais que aumentam a emoção. Ideal para quem gosta de desafios rápidos e partidas cheias de reviravoltas.', 30, 'imagens/produtos/uno_no_mercy.png', 'imagens/produtos/uno_no_mercy_1.png', 1, 11.99);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tickets`
--

CREATE TABLE `tickets` (
  `id_ticket` int(11) NOT NULL,
  `id_utilizador` int(11) DEFAULT NULL,
  `nome_utilizador` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `id_encomenda` int(11) DEFAULT NULL,
  `titulo` varchar(150) NOT NULL,
  `assunto` enum('devolução','troca','encomenda','outros') NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `data` datetime DEFAULT current_timestamp(),
  `file` varchar(255) DEFAULT NULL,
  `estado` enum('Em análise','Resolvido') DEFAULT 'Em análise'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `tickets`
--

INSERT INTO `tickets` (`id_ticket`, `id_utilizador`, `nome_utilizador`, `email`, `id_encomenda`, `titulo`, `assunto`, `descricao`, `data`, `file`, `estado`) VALUES
(4, 3, NULL, NULL, 1, 'Titulo do pedido', 'encomenda', 'descrição do pedido', '2026-01-23 17:04:35', '1769187875_7561_awkward_monke.png', 'Em análise'),
(11, 3, NULL, NULL, 4, 'Teste recente', 'troca', 'Testando depois dos contactos feito', '2026-02-14 16:40:47', '1771087247_server-icon.png', 'Em análise'),
(12, 3, NULL, NULL, 4, 'Teste recente', 'troca', 'asdasdas', '2026-02-14 16:40:58', '1771087258_server-icon.png', 'Em análise');

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `id_utilizador` int(11) NOT NULL,
  `nome_utilizador` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','cliente') NOT NULL DEFAULT 'cliente',
  `email` varchar(150) NOT NULL,
  `foto_utilizador` varchar(255) DEFAULT 'imagens/utilizador/default.png',
  `data_nascimento` date DEFAULT NULL,
  `morada` varchar(255) DEFAULT NULL,
  `codigo_postal` varchar(20) DEFAULT NULL,
  `telemovel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`id_utilizador`, `nome_utilizador`, `password`, `role`, `email`, `foto_utilizador`, `data_nascimento`, `morada`, `codigo_postal`, `telemovel`) VALUES
(1, 'admin', '$2a$12$J/xGbQZHZm6yMEREQ0yUR.KHvCPU9XmHWX1BMLShqkoL2ufhPook.', 'admin', '', 'imagens/utilizador/default.png', NULL, NULL, NULL, NULL),
(3, 'teste alt', '$2y$10$acYYRPWjdZ8it5fzqFicK.oLqOa4d/g7R4YeE4h5u7TgXq6zfoHHa', 'cliente', 'testealt@teste.com', 'imagens/utilizador/profile_6990b24e785aa9.32162463.png', '0000-00-00', 'Rua nao sei quantos', '4321-123', '931234556'),
(4, 'teste 2', '$2y$10$9Lu/iCpjxFJ9JzyN0FBEuO2XPepE0FVt1Q9Dy2WaFEBB0c6sUEXNS', 'cliente', 'teset123@teste.com', 'imagens/utilizador/default.png', NULL, NULL, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `conteudo`
--
ALTER TABLE `conteudo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `encomendas`
--
ALTER TABLE `encomendas`
  ADD PRIMARY KEY (`id_encomenda`),
  ADD KEY `fk_utilizador` (`id_utilizador`);

--
-- Índices para tabela `encomendas_produtos`
--
ALTER TABLE `encomendas_produtos`
  ADD PRIMARY KEY (`id_encomenda`,`id_produto`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices para tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id_evento`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`);

--
-- Índices para tabela `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id_ticket`),
  ADD KEY `id_utilizador` (`id_utilizador`),
  ADD KEY `fk_tickets_encomendas` (`id_encomenda`);

--
-- Índices para tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`id_utilizador`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `conteudo`
--
ALTER TABLE `conteudo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `encomendas`
--
ALTER TABLE `encomendas`
  MODIFY `id_encomenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id_utilizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `encomendas`
--
ALTER TABLE `encomendas`
  ADD CONSTRAINT `fk_utilizador` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id_utilizador`);

--
-- Limitadores para a tabela `encomendas_produtos`
--
ALTER TABLE `encomendas_produtos`
  ADD CONSTRAINT `encomendas_produtos_ibfk_1` FOREIGN KEY (`id_encomenda`) REFERENCES `encomendas` (`id_encomenda`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `encomendas_produtos_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id_utilizador`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
