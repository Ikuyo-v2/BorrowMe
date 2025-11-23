-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 23, 2025 at 03:17 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `borrowme`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(225) NOT NULL,
  `category_id` int DEFAULT NULL,
  `description` text,
  `release_date` date DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `category_id`, `description`, `release_date`, `image_path`) VALUES
(1, 'ERIN HUNTER WARRIORS', 'Natalie & Sara', 1, 'Warrios adalah kisah penuh semangat tentang persahabatan, keberanian, dan perjuangan menghadapi tantangan hidup. Ditulis oleh Natalie dan Sara, buku ini mengajak pembaca menyelami perjalanan tokoh-tokohnya yang berani melawan rasa takut, mempertahankan harapan, dan menemukan arti sejati dari kekuatan diri. Sebuah bacaan inspiratif untuk siapa saja yang mencari motivasi dan petualangan dalam satu cerita.', '2003-01-23', 'imgs/books/ERIN.png'),
(2, 'Spy x Family', 'Tatsuya Endo', 1, 'Manga populer tentang keluarga palsu yang terdiri dari mata-mata, pembunuh, dan anak dengan kekuatan telepati. Mereka menyembunyikan identitas masing-masing demi menjalankan misi rahasia, namun justru tumbuh menjadi keluarga yang saling pedu', '2019-04-06', 'imgs/books/Spy x Family.png'),
(3, 'Bocchi The Book', 'Aki Hamaji', 1, 'Kisah Hitori “Bocchi” Goto, gadis pemalu yang ingin bersinar lewat musik. Ia bergabung dengan band sekolah dan berjuang melawan rasa canggung sosialnya sambil membangun persahabatan', '2024-03-20', 'imgs/books/Bocchi The Rock.png'),
(4, 'Seni Berdamai dengan Diri Sendiri', 'Claudia Sabrina', 8, 'Buku reflektif yang mengajak pembaca untuk menerima ketidaksempurnaan diri, menemukan potensi pribadi, dan hidup lebih damai tanpa harus menjadi orang lain', '2020-09-24', 'imgs/books/Berdamai dengan Rasa Cemas.png'),
(5, 'Untuk Kamu yang Mau Menyerah', 'Haidar Musyafa', 2, 'Ditulis untuk mereka yang merasa lelah dan ingin menyerah, buku ini menawarkan semangat baru melalui kisah-kisah inspiratif dan refleksi spiritual tentang makna perjuangan hidup', '2021-01-01', 'imgs/books/Untuk Kamu Yang Mau Menyerah.png'),
(6, 'Petualangan Alan dan Profesor Apta', 'rhayati Harun & Uda Agus\n', 2, 'Halo adik-adik, kalian suka berpetualang? Kalau iya, berarti kalian sudah mengambil buku yang tepat. Dalam buku ini kalian akan berpetualang seru mengikuti Alan dan Profesor Apta berkeliling ke beberapa benua yang ada di dunia: Asia, Afrika, Eropa, Australia, dan Amerika. Seru bukan? Dalam buku ini, mereka akan menjelajah ke beberapa benua, menemukan hewan-hewan unik yang ada di benua tersebut. Pasti banyak di antara hewan-hewan itu yang belum kalian kenal. Ada meerkat, aye-aye, beruang grizzly, armadillo, flamingo, yak, burung kolibri, platipus, dingo, dan masih ada puluhan hewan lain yang berhasil ditemui Alan dan Profesor Apta. Penasaran kan? Silakan dibaca hingga tuntas, ya? Selamat berpetualang!', '2017-03-05', 'imgs/books/petualangan.png'),
(7, 'The Principles of Power', 'Dian Yulianto', 8, 'Buku ini bukanlah sekadar bacaan biasa, melainkan sebuah panduan praktis untuk \"menguasai dan memanipulasi\" orang lain dengan cara yang positif. Terdapat 33 kiat brilian di dalamnya yang akan membantu pembaca untuk membangun rasa hormat dari bawahan, mendapat perhatian dari atasan tanpa harus menjilat, dan bahkan bertahan dan meraih kesuksesan dalam persaingan yang ketat. Tidak hanya itu, buku ini juga mengajarkan bagaimana memanfaatkan musuh atau saingan agar menjadi sekutu yang mendukung kesuksesan kita.\nSetelah membaca buku ini, pembaca akan memiliki kemampuan untuk menguasai situasi dan menjadi sosok pribadi yang tak terkalahkan oleh orang lain maupun keadaan. Jangan lewatkan kesempatan untuk membaca buku ini dan mengubah hidupmu menjadi lebih baik! Siapkan dirimu untuk menjadi yang terbaik dengan mempelajari buku ini!\n\n', '2023-05-17', 'imgs/books/the principles.png'),
(8, 'Menasihati Tanpa Menggurui', 'MHD.Rois Almaududy', 8, 'Agama menuntun pengikutnya untuk hidup lebih baik. Panduannya bukan saja berlaku untuk orang dewasa yang kehidupannya cenderung lebih berwarna dengan persoalan. Anak-anak yang lazimnya masih ceria dalam dunia bermain pun selalu membutuhkan tuntunan yang tepat agar keharmonisan dengan lingkungan sosialnya terjaga. Bagi anda yang sedang mencari buku nuansa islami, maka buku ini merupakan salah satu pilihan yang tepat.', '2019-10-10', 'imgs/books/menasihati.png'),
(9, 'Semua ada waktu', 'Muyassaroh', 2, 'Buku Semua Ada Waktunya berisi kisah – kisah inspiratif untuk menguatkan hati orang – orang yang sedang diuji dan merasa sudah tidak mampu lagi.', '2022-04-05', 'imgs/books/semua ada.png'),
(10, 'Kereta Malam Menuju Harlok', 'Maya Lestari GF', 1, 'Tepat pada malam takbiran, pengasuh terakhir Kulila, sebuah panti khusus anak cacat, kabur. Di tengah kesedihan, Tamir, salah satu anak yang tinggal di Kulila, mengalami kejadian aneh. Pada pukul sembilan malam, ketika mendung bergulung di langit, sebuah kereta datang dari balik awan dan membawa Tamir ke Harlok, satu dari sekian banyak kota di langit. Di situ ia dipaksa bekerja sebagai penggali tambang batu seruni, bersama anak-anak lainnya. Ia mengalami banyak sekali penderitaan, hingga suatu malam datang keajaiban dari dalam hutan kabut Harlok.\n', '2021-01-01', 'imgs/books/kereta.png'),
(11, 'The Diary of a Young Girl', 'Anne Frank\n', 5, 'Jurnal harian Anne Frank, seorang gadis Yahudi remaja, yang mencatat kehidupan dan pengalamannya bersembunyi bersama keluarganya selama pendudukan Nazi di Belanda pada Perang Dunia II. Sebuah kisah kemanusiaan dan harapan di tengah kekejaman.', '1947-06-25', 'imgs/books/young girl.png'),
(12, 'Sang Pemimpi', 'Andrea Hirata', 2, 'Kisah persahabatan, pendidikan, dan mimpi besar tiga pemuda dari Belitung yang berjuang mengubah hidup mereka.', '2006-01-01', 'imgs/books/sang pemimpi.png'),
(13, 'Prince Of Thorns', 'Mark Lawrence', 2, 'Petualangan gelap seorang pangeran yang kejam namun jenius dalam membangun kekuasaannya.', '2011-08-02', 'imgs/books/prince.png'),
(14, 'Melihat Api Bekerja', 'Maan Mansyur', 2, 'Kumpulan kisah reflektif tentang kehidupan manusia, keresahan batin, dan proses pendewasaan.', '2015-05-21', 'imgs/books/melihat.png'),
(15, 'Cinta Yang Mekar', 'Soo Jin Ae', 2, 'Kisah romantis yang lembut tentang cinta yang tumbuh perlahan di tengah kesibukan hidup modern.', '2018-03-19', 'imgs/books/cinta yang.png'),
(16, 'Dreamland', 'Nicholas Sparks', 2, 'Kisah emosional mengenai cinta, kehilangan, dan harapan baru yang muncul secara tak terduga.', '2022-09-20', 'imgs/books/dreamland.png'),
(17, 'Ababil & Tiga Kilatan', 'Bean Wilyana', 14, 'Kisah penuh aksi dan kekuatan supranatural ketika dunia manusia mulai diserang makhluk gelap.', '2014-04-14', 'imgs/books/ababil.png'),
(18, 'Blood in Shadow', 'Laura Casey', 14, 'Seorang agen rahasia memburu pembunuh berantai dalam dunia yang dipenuhi bayangan misterius.', '2019-12-11', 'imgs/books/blood.png'),
(19, 'Ambush', 'James Patterson', 14, 'Cerita detektif penuh ketegangan ketika sebuah operasi rahasia berubah menjadi jebakan mematikan.', '2018-09-05', 'imgs/books/ambush.png'),
(20, 'After Death', 'Dean Koontz', 14, 'Perjalanan seorang pria yang kembali dari kematian dan membawa kemampuan aneh yang mengubah hidupnya.', '2023-01-10', 'imgs/books/after death.png'),
(21, 'Geometry for Ocelots', 'Exurb1a', 14, 'It is the end of history and all is known, or will be soon. Humanity long ago transitioned to the era of holy technology. Now humans present as saintly animals, spending their days in meditation and drug-induced euphoria, far from the dark secrets their paradise is founded upon. But when an ancient prophet allegedly returns in the form of a troubled young girl, galactic peace can only last so long.\n\nGeometry for Ocelots is the story of two monarch siblings gone to war at the end of time—a holy empress, and an alcoholic university dean. With galactic resources dwindling, both believe they hold the answer to the crisis; be it spiritual salvation or technological nirvana. Both will be gravely mistaken.', '2016-05-10', 'imgs/books/geometry.png'),
(22, 'Doraemon Petualangan 1', 'Fujiko F. Fujio', 1, 'Petualangan seru Nobita dan Doraemon menjelajahi dunia misterius dengan alat-alat ajaib.', '2000-01-10', 'imgs/books/d1.png'),
(23, 'Doraemon Petualangan 2', 'Fujiko F. Fujio', 1, 'Petualangan lanjutan dengan ancaman baru yang harus dihadapi oleh tim kecil mereka.', '2001-02-15', 'imgs/books/d2.png'),
(24, 'Doraemon Petualangan 3', 'Fujiko F. Fujio', 1, 'Nobita dan teman-teman menjelajahi planet asing dalam misi penyelamatan.', '2002-06-20', 'imgs/books/d3.png'),
(25, 'Doraemon Petualangan 4', 'Fujiko F. Fujio', 1, 'Kisah lucu penuh aksi ketika muncul makhluk misterius yang mengacaukan kota.', '2003-08-11', 'imgs/books/d4.png'),
(26, 'Doraemon Petualangan 5', 'Fujiko F. Fujio', 1, 'Petualangan epik dengan portal waktu yang menghubungkan masa depan dan masa lalu.', '2004-04-05', 'imgs/books/d5.png'),
(27, 'Becoming', 'Michelle Obama', 5, 'Memoar pribadi yang mendalam dari mantan Ibu Negara Amerika Serikat, Michelle Obama. Ia berbagi kisah hidupnya mulai dari masa kecil di South Side Chicago, perjuangannya sebagai eksekutif, hingga perannya sebagai Ibu Negara dan seorang ibu.', '2018-11-13', 'imgs/books/becoming.png'),
(28, 'Long Walk to Freedom', 'Nelson Mandela', 5, ' Autobiografi Nelson Mandela yang menceritakan perjalanannya dari masa kecil di desa Mvezo, perjuangannya melawan apartheid di Afrika Selatan, 27 tahun masa penjaranya, hingga menjadi presiden pertama Afrika Selatan yang dipilih secara demokratis.', '1994-12-15', 'imgs/books/long walk.png'),
(29, 'Shoe Dog', 'Phil Knight\n', 5, 'Memoar pendiri Nike, Phil Knight, yang mengisahkan perjalanan mendebarkan dan penuh risiko dalam membangun salah satu merek olahraga paling ikonik di dunia dari awal yang sederhana.', '2016-04-26', 'imgs/books/shoe dog.png'),
(30, 'I Am Malala: The Story of the Girl Who Stood Up for Education and Was Shot by the Taliban', 'Malala Yousafzai\n', 5, 'Kisah inspiratif Malala, yang mulai mengadvokasi hak anak perempuan atas pendidikan di Pakistan ketika ia masih sangat muda, hingga ia ditembak oleh Taliban dan menjadi penerima Nobel Perdamaian termuda.', '2013-10-08', 'imgs/books/malala.png'),
(31, 'A Brief History of Humankind', 'Yuval Noah Harari', 21, 'Mengulas sejarah spesies manusia, Homo Sapiens, dari awal mula sebagai kera hingga menjadi penguasa dunia, dengan fokus pada Revolusi Kognitif, Pertanian, dan Ilmiah.', '1988-04-01', 'imgs/books/brief human.png'),
(32, 'A Brief History of Time\n', 'Stephen Hawking', 21, 'Menyajikan konsep-konsep kompleks fisika kosmik—seperti ruang, waktu, lubang hitam, dan alam semesta—kepada pembaca umum.', '1988-04-01', 'imgs/books/brief time.png'),
(33, 'Cosmos', ' Carl Sagan', 21, 'Buku yang memadukan ilmu pengetahuan, sejarah, dan filosofi untuk menjelajahi asal-usul alam semesta dan tempat manusia di dalamnya.\n', '1980-01-01', 'imgs/books/cosmos.png'),
(34, 'The Selfish Gene', 'Richard Dawkins', 21, 'Memperkenalkan pandangan evolusioner dari sudut pandang gen. Buku ini berargumen bahwa gen adalah unit dasar dari seleksi, dan perilaku organisme bertujuan untuk melestarikan gen mereka sendiri.', '1976-09-21', 'imgs/books/gene.png'),
(35, 'The Future of Humanity\n', 'Michio Kaku', 21, 'Menjelajahi kemungkinan masa depan peradaban manusia, termasuk kolonisasi planet lain seperti Mars dan kebangkitan kecerdasan buatan.', '2018-02-20', 'imgs/books/future.png'),
(36, 'The Fifth Science', 'Exurb1a', 14, 'The Galactic Human Empire was built atop four logic, physics, psychology, and sociology. Standing on those pillars, humans spent 100,000 years spreading out into the warring, exploring, partying — the usual. Then there was the fifth science. And that killed the empire stone dead. The Fifth Science is a collection of 12 stories, beginning at the start of the Galactic Human Empire and following right through to its final days. We’ll see some untypical things along the way, meet some untypical galactic lighthouses from the distant future, alien tombs from the distant past, murderers, emperors, archaeologists and drunks; mad mathematicians attempting to wake the universe itself up. And when humans have fallen back into savagery, when the secrets of space folding and perfect wisdom are forgotten, we’ll attend the empire’s deathbed, hold its hand as it goes. Unfortunately that may well only be the beginning.', '2018-08-24', 'imgs/books/the fifth.png'),
(37, 'Logic Beach: Part I', 'Exurb1a', 14, 'Mathematician Polly Hare is missing. She leaves behind: one cat, one scarf, and a hypergeometric theory of everything with the potential to end physics. Her husband Benjamin is determined to bring her home.\nPapers will be read. Cults will be infiltrated. Cats will be petted. Benjamin Hare cannot tie his shoes, but he may well steer the course of human history.\n\nThousands of years later and humans have migrated into a great digital playground called Arcadia. Light is smelled. Music is eaten. Physics is near completion. These new humans have their own trials, however; an experiment in mind-blending has gone horribly wrong, giving birth to a rampant colossus. It is the end of history, but long-dead mathematician (and mediocre ukulele player) Polly Hare might have something to say on the matter.\n\nWhat is the origin of space and time?\nWhy is logic built into nature?\nAnd how, exactly, does God take his tea?', '2017-11-27', 'imgs/books/logic.png'),
(38, 'Poems for the Lost Because Im Lost Too', 'Exurb1a', 15, 'exurb1a presents his all-new collection of self-indulgent poetry. An unlikely bestseller, so unlikely that it isnt a bestseller at all, Poems for the Lost seeks to answer age-old questions such as: Why do bad things happen to good people? How did the universe come from nothing? And whats the deal with shrimp? Pull up your least comfortable chair, pour a shot of hand sanitizer, its time for self-pity.', '2022-11-26', 'imgs/books/poem because.png'),
(39, 'Sejarah Dunia yang Disembunyikan', 'Jonathan Black', 17, 'Menghadirkan sudut pandang alternatif terhadap sejarah yang umum diketahui, mengeksplorasi mitos, misteri, dan teori konspirasi yang mungkin memengaruhi perjalanan peradaban manusia.', '2007-09-01', 'imgs/books/sejarah.png'),
(40, 'Guns, Germs, and Lita', 'Jared Diamond', 17, 'Berusaha menjawab pertanyaan mengapa peradaban manusia berkembang secara berbeda di berbagai benua berdasarkan faktor geografis dan lingkungan.', '1997-03-01', 'imgs/books/guns.png'),
(41, 'Homo Deus: A Brief History of Tomorrow', 'Yuval Noah Harari', 17, 'Lanjutan dari Sapiens. Harari memprediksi apa yang mungkin menjadi agenda berikutnya bagi umat manusia di abad ke-21, yaitu pencarian keabadian, kebahagiaan, dan kedewanan.\n', '2017-02-21', 'imgs/books/homodeus.png'),
(42, 'The Story of Civilization: Our Oriental Heritage\n', 'Will Durant', 17, 'Volume pertama dari seri monumental ini. Memberikan tinjauan komprehensif tentang sejarah peradaban di Timur, mencakup Mesir, Mesopotamia, India, Tiongkok, dan Jepang.', '1935-05-20', 'imgs/books/story.png'),
(43, 'The Rise and Fall of the Great Powers\n', 'Paul Kennedy', 17, 'Analisis sejarah ekonomi dan strategi militer, berpendapat bahwa ada korelasi antara kapasitas ekonomi suatu negara dan kekuatan militer jangka panjangnya.', '1989-02-16', 'imgs/books/rise and fall.png'),
(44, 'lita lita', '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(1, 'Comic'),
(2, 'Novel'),
(3, 'Arts'),
(4, 'Photography'),
(5, 'Biography'),
(6, 'Memoirs'),
(7, 'Business'),
(8, 'Self-Help'),
(9, 'Children Book'),
(10, 'Computer'),
(11, 'Cooking'),
(12, 'Design'),
(13, 'Entertainment'),
(14, 'Fiction'),
(15, 'Literature'),
(16, 'Health'),
(17, 'History'),
(18, 'Politics'),
(19, 'Parenting'),
(20, 'Relationship'),
(21, 'Science & Technology');

-- --------------------------------------------------------

--
-- Table structure for table `dapid`
--

CREATE TABLE `dapid` (
  `id` int NOT NULL,
  `book_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `use`
--

CREATE TABLE `use` (
  `id` int NOT NULL,
  `book_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Aricks', 'Aricks@gmail.com', 'testpassword'),
(2, 'aaaa', 'aaaa@gmail.com', '$2y$10$CwvkptkmfphHvHkCib3i3u04ApcSPY5lFqm0f8CANmdABAZHsaVIS'),
(3, 'admin', 'admin@admin', '$2y$10$lqod5i3qfF3hvZkw88qNsOywhWTV3qOcj5pjFZnMJTqil3y0cv33G'),
(4, 'Ricks', 'Ricks@gmail.com', '$2y$10$STnujb8Ss/Y7rOUS/ydk6uHfKk2vndrCu6MlyZW9auyla46juCTpS'),
(5, 'dapid', 'dapid@dapid', '$2y$10$0I6XRO9zgq0gjQh5fFI8gOBn6Npf6E3tQmmbXgz8z4pJtzAe6.a.2'),
(6, 'use', 'use@use', '$2y$10$4Ar9b7rtkXV16XrHY.9/9uPYpHdenR2LDqvkjPmEBkfYp8t15vfr2'),
(7, 'ww', 'ww@ww', '$2y$10$5aaQMXunUcdXRxVXW/IfBuxkMHxiTGM7vy40KeWUyx.XDQvp/jgUO');

-- --------------------------------------------------------

--
-- Table structure for table `ww`
--

CREATE TABLE `ww` (
  `id` int NOT NULL,
  `book_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ww`
--

INSERT INTO `ww` (`id`, `book_id`, `quantity`, `date_added`) VALUES
(1, 15, 11, '2025-11-23 13:47:13'),
(2, 34, 1, '2025-11-23 14:14:47'),
(3, 40, 1, '2025-11-23 14:14:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dapid`
--
ALTER TABLE `dapid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `use`
--
ALTER TABLE `use`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ww`
--
ALTER TABLE `ww`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `dapid`
--
ALTER TABLE `dapid`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `use`
--
ALTER TABLE `use`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ww`
--
ALTER TABLE `ww`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
