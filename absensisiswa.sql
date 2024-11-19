-- Tabel `sekolah`
CREATE TABLE `sekolah` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `kode` VARCHAR(50) NOT NULL,
  `nama_sekolah` VARCHAR(100) NOT NULL,
  `alamat` TEXT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel `kelas`
CREATE TABLE `kelas` (
  `idk` INT(10) NOT NULL AUTO_INCREMENT,
  `id_sekolah` INT(10) NOT NULL,
  `nama_kelas` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`idk`),
  FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel `hari`
CREATE TABLE `hari` (
  `idh` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_hari` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`idh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel `guru`
CREATE TABLE `guru` (
  `idg` INT(10) NOT NULL AUTO_INCREMENT,
  `nip` VARCHAR(50) NOT NULL,
  `nama` VARCHAR(100) NOT NULL,
  `jk` ENUM('L', 'P') NOT NULL,
  `alamat` TEXT,
  `pass` CHAR(32) NOT NULL,
  PRIMARY KEY (`idg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel `mata_pelajaran`
CREATE TABLE `mata_pelajaran` (
  `idm` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_mata_pelajaran` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel `jadwal`
CREATE TABLE `jadwal` (
  `idj` INT(11) NOT NULL AUTO_INCREMENT,
  `idh` INT(11) NOT NULL,
  `idg` INT(10) NOT NULL,
  `idk` INT(10) NOT NULL,
  `idm` INT(11) NOT NULL,
  `jam_mulai` TIME NOT NULL,
  `jam_selesai` TIME NOT NULL,
  `aktif` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idj`),
  FOREIGN KEY (`idh`) REFERENCES `hari`(`idh`),
  FOREIGN KEY (`idg`) REFERENCES `guru`(`idg`),
  FOREIGN KEY (`idk`) REFERENCES `kelas`(`idk`),
  FOREIGN KEY (`idm`) REFERENCES `mata_pelajaran`(`idm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel `siswa`
CREATE TABLE `siswa` (
  `ids` INT(10) NOT NULL AUTO_INCREMENT,
  `nis` VARCHAR(50) NOT NULL,
  `nama_siswa` VARCHAR(100) NOT NULL,
  `jk` ENUM('L', 'P') NOT NULL,
  `alamat` TEXT,
  `idk` INT(10) NOT NULL,
  `telepon` VARCHAR(20),
  `nama_bapak` VARCHAR(50),
  `pekerjaan_bapak` VARCHAR(50),
  `nama_ibu` VARCHAR(50),
  `pekerjaan_ibu` VARCHAR(50),
  `pass` CHAR(32) NOT NULL,
  PRIMARY KEY (`ids`),
  FOREIGN KEY (`idk`) REFERENCES `kelas`(`idk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel `user`
CREATE TABLE `user` (
  `idu` INT(10) NOT NULL AUTO_INCREMENT,
  `nama_user` VARCHAR(100) NOT NULL,
  `pass` CHAR(32) NOT NULL,
  `level` ENUM('admin', 'guru', 'siswa') NOT NULL,
  `id_sekolah` INT(10) NOT NULL,
  PRIMARY KEY (`idu`),
  FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel `absen`
CREATE TABLE `absen` (
  `ida` INT(10) NOT NULL AUTO_INCREMENT,
  `ids` INT(10) NOT NULL,
  `idj` INT(11) NOT NULL,
  `tgl` DATE NOT NULL,
  `ket` VARCHAR(3) NOT NULL,
  PRIMARY KEY (`ida`),
  FOREIGN KEY (`ids`) REFERENCES `siswa`(`ids`),
  FOREIGN KEY (`idj`) REFERENCES `jadwal`(`idj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Insert Data ke Tabel

-- Data untuk tabel `sekolah`
INSERT INTO `sekolah` (`kode`, `nama_sekolah`, `alamat`) VALUES
('2010902872872', 'SMP Negeri 46 Depok', 'Jl. FX Sejahtera No. 46 Depok Timur, Depok 16446');

-- Data untuk tabel `kelas`
INSERT INTO `kelas` (`id_sekolah`, `nama_kelas`) VALUES
(1, 'VII'), (1, 'VIII'), (1, 'IX');

-- Data untuk tabel `hari`
INSERT INTO `hari` (`nama_hari`) VALUES
('Senin'), ('Selasa'), ('Rabu'), ('Kamis'), ('Jum\'at');

-- Data untuk tabel `guru`
INSERT INTO `guru` (`nip`, `nama`, `jk`, `alamat`, `pass`) VALUES
('19610506199', 'Utami, M. Pd.', 'P', '-', '77e69c137812518e359196bb2f5e9bb9'),
('19540914972', 'Dra. Hj. Latifah', 'P', '-', '77e69c137812518e359196bb2f5e9bb9'),
('19661025191', 'Yasin, S.Pd', 'L', '-', '77e69c137812518e359196bb2f5e9bb9'),
('34547566583', 'Ibnu, S.Pd', 'L', '-', '77e69c137812518e359196bb2f5e9bb9'),
('34627426463', 'Drs. Masrur', 'L', '-', '77e69c137812518e359196bb2f5e9bb9');

-- Data untuk tabel `mata_pelajaran`
INSERT INTO `mata_pelajaran` (`nama_mata_pelajaran`) VALUES
('Matematika'), ('Bahasa Indonesia'), ('Ilmu Pengetahuan Alam');

-- Data untuk tabel `jadwal`
INSERT INTO `jadwal` (`idh`, `idg`, `idk`, `idm`, `jam_mulai`, `jam_selesai`, `aktif`) VALUES
(1, 1, 1, 1, '07:00:00', '09:00:00', 1),
(2, 2, 2, 2, '07:00:00', '09:00:00', 1),
(3, 3, 3, 3, '13:00:00', '15:00:00', 1);

-- Data untuk tabel `siswa`
INSERT INTO `siswa` (`nis`, `nama_siswa`, `jk`, `alamat`, `idk`, `telepon`, `nama_bapak`, `pekerjaan_bapak`, `nama_ibu`, `pekerjaan_ibu`, `pass`) VALUES
('9965340897', 'Zildjian', 'L', '-', 1, '85733743907', '-', '-', '-', '-', 'bcd724d15cde8c47650fda962968f102'),
('9974601836', 'Mitra', 'P', '-', 1, '85733743907', '-', '-', '-', '-', 'bcd724d15cde8c47650fda962968f102');

-- Data untuk tabel `user`
INSERT INTO `user` (`nama_user`, `pass`, `level`, `id_sekolah`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 1);

-- Data untuk tabel `absen`
INSERT INTO `absen` (`ids`, `idj`, `tgl`, `ket`) VALUES
(1, 1, '2018-05-01', 'M'),
(2, 2, '2018-05-01', 'S'),
(1, 3, '2018-05-08', 'I');