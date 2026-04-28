-- Hidayah DeenHub - Seed data
USE `hidayah_deenhub`;

-- Default admin account (username: admin, password: Admin@123)
-- Hash generated with PHP password_hash(..., PASSWORD_DEFAULT).
INSERT IGNORE INTO `users` (`username`, `email`, `password_hash`, `is_admin`, `city`, `country`)
VALUES
    ('admin', 'admin@hidayah.local',
     '$2y$10$6qgDqz3Y0H8V8YtM8iJcNeK1l3Xk/bkK3vH0dq1YbL.8yJ/cMCy3e',
     1, 'Dhaka', 'Bangladesh');

-- ---------------------------------------------------------------------------
-- Islamic tips
-- ---------------------------------------------------------------------------
INSERT INTO `tips` (`title`, `body`, `reference`, `category`) VALUES
('Begin with Bismillah',
 'Starting every action with "Bismillah ir-Rahman ir-Raheem" invites blessings and keeps your intention pure. Say it before eating, studying, driving, or beginning any task.',
 'Sunnah of the Prophet ﷺ', 'daily'),

('The Best of You',
 'The Prophet ﷺ said: "The best of you are those who are best to their families, and I am the best of you to my family."',
 'Sunan al-Tirmidhi 3895', 'family'),

('Smile is Charity',
 'Your smile for your brother is a charity (sadaqah). Small acts of kindness carry great weight on the Day of Judgement.',
 'Sunan al-Tirmidhi 1956', 'character'),

('Protect Your Tongue',
 'Whoever believes in Allah and the Last Day should speak good or remain silent. Guard your tongue from backbiting, lying and vain talk.',
 'Sahih al-Bukhari 6018', 'character'),

('Consistency Over Quantity',
 'The most beloved deeds to Allah are those that are consistent, even if they are small. Start with one sunnah rakah, one page of Quran, or one hadith a day.',
 'Sahih al-Bukhari 6464', 'worship'),

('The Power of Dua',
 'Dua is the weapon of the believer. Call upon Allah in times of ease and hardship — He is closer to you than your jugular vein.',
 'Quran 50:16', 'worship'),

('Honour Your Parents',
 'Paradise lies beneath the feet of the mother. Speak softly, serve them, and never raise your voice to them.',
 'Quran 17:23-24', 'family'),

('Wudu Refreshes the Soul',
 'Perfect wudu erases sins. When a believer washes their face, every sin seen by the eyes leaves with the water.',
 'Sahih Muslim 244', 'worship'),

('Seek Knowledge',
 'Seeking knowledge is an obligation upon every Muslim. Allah raises in rank those who are given knowledge.',
 'Quran 58:11', 'knowledge'),

('Trust in Allah',
 'And whoever relies upon Allah — then He is sufficient for him. Let go of anxiety and trust the One who controls every atom.',
 'Quran 65:3', 'iman'),

('Kindness to Neighbours',
 'Jibreel kept advising the Prophet ﷺ about neighbours until he thought they would inherit from each other. Check on them, share food, and be a source of peace.',
 'Sahih al-Bukhari 6014', 'community'),

('Gratitude Increases Blessings',
 'If you are grateful, I will surely increase you in favor. Say Alhamdulillah for the seen and unseen blessings in your life.',
 'Quran 14:7', 'iman'),

('Forgive and Move On',
 'Pardon and overlook. Do you not wish that Allah should forgive you? Allah is Forgiving and Merciful.',
 'Quran 24:22', 'character'),

('Early Morning Barakah',
 'O Allah, bless my ummah in the early hours of the morning. Wake up for Fajr and tackle the most important task of your day before breakfast.',
 'Sunan al-Tirmidhi 1212', 'daily'),

('Say Alhamdulillah',
 'After every meal, say "Alhamdulillah-illadhi at\u2019amana wa saqaana wa ja\u2019alana muslimeen" \u2014 All praise is for Allah who fed us and made us Muslims.',
 'Sunan Abu Dawud 3850', 'daily');

-- ---------------------------------------------------------------------------
-- Quiz questions
-- ---------------------------------------------------------------------------
INSERT INTO `quiz_questions` (`question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explanation`, `difficulty`) VALUES
('How many pillars of Islam are there?',
 'Three', 'Four', 'Five', 'Six', 'C',
 'The five pillars are Shahada, Salah, Zakat, Sawm (fasting Ramadan), and Hajj.', 'easy'),

('How many times a day does a Muslim pray the obligatory prayers?',
 'Three', 'Five', 'Seven', 'Four', 'B',
 'Fajr, Dhuhr, Asr, Maghrib, and Isha \u2014 five daily prayers.', 'easy'),

('In which month do Muslims fast from dawn to sunset?',
 'Rajab', 'Shaban', 'Ramadan', 'Muharram', 'C',
 'Ramadan is the ninth month of the Islamic calendar and the month of fasting.', 'easy'),

('Which is the first Surah in the Quran?',
 'Al-Baqarah', 'Al-Fatiha', 'Al-Ikhlas', 'Yaseen', 'B',
 'Al-Fatiha ("The Opening") is the first chapter and is recited in every rakah of salah.', 'easy'),

('How many chapters (Surahs) are there in the Quran?',
 '99', '110', '114', '120', 'C',
 'The Quran has 114 Surahs, beginning with Al-Fatiha and ending with An-Nas.', 'easy'),

('Which prophet is known as Khalilullah (Friend of Allah)?',
 'Musa (a.s.)', 'Isa (a.s.)', 'Ibrahim (a.s.)', 'Nuh (a.s.)', 'C',
 'Ibrahim (a.s.) is titled Khalilullah in the Quran.', 'medium'),

('What was the first revelation of the Quran to the Prophet Muhammad \u2102?',
 'Iqra bismi rabbika', 'Bismillah ir-Rahman ir-Raheem', 'Qul huwallahu ahad', 'Al-hamdu lillahi rabbil-alameen', 'A',
 'The first verses revealed were from Surah Al-Alaq: "Iqra bismi rabbika alladhee khalaq".', 'medium'),

('In which cave did the Prophet \u2102 receive the first revelation?',
 'Thawr', 'Hira', 'Uhud', 'Safa', 'B',
 'The first revelation came while he was in Cave Hira on the mountain of Jabal an-Nur.', 'medium'),

('How many verses are in Surah Al-Fatiha?',
 '6', '7', '8', '10', 'B',
 'Al-Fatiha consists of seven verses and is known as "Sab\u2019 al-Mathani" (the seven oft-repeated).', 'easy'),

('Which prayer has 4 Fard rakahs?',
 'Fajr', 'Maghrib', 'Asr', 'Witr', 'C',
 'Asr has 4 fard rakahs. Fajr has 2, Maghrib has 3, and Witr is part of wajib/sunnah.', 'medium'),

('What is the name of the holy city where the Kaaba is located?',
 'Madinah', 'Jerusalem', 'Makkah', 'Cairo', 'C',
 'The Kaaba is located in Masjid al-Haram in Makkah.', 'easy'),

('Who built the Kaaba originally?',
 'Adam (a.s.) and Hawa', 'Ibrahim (a.s.) and Ismail (a.s.)', 'Nuh (a.s.)', 'Muhammad \u2102', 'B',
 'The Kaaba was rebuilt by Ibrahim and his son Ismail (peace be upon them) by command of Allah.', 'medium'),

('What is Zakat?',
 'A recommended prayer', 'Obligatory charity (2.5% of wealth)', 'A voluntary fast', 'Hajj pilgrimage', 'B',
 'Zakat is the third pillar \u2014 purifying wealth by giving 2.5% of qualifying savings yearly.', 'easy'),

('Which angel is responsible for delivering revelation?',
 'Mikail', 'Israfil', 'Malik', 'Jibreel', 'D',
 'Jibreel (Gabriel) conveyed revelation from Allah to all the prophets.', 'easy'),

('How many prophets are mentioned by name in the Quran?',
 '12', '25', '40', '124,000', 'B',
 '25 prophets are mentioned by name in the Quran, though Islamic tradition says there were many more.', 'hard'),

('Which Surah is known as "the heart of the Quran"?',
 'Yaseen', 'Al-Kahf', 'Al-Mulk', 'Ar-Rahman', 'A',
 'Surah Yaseen is often called "Qalb al-Quran" \u2014 the heart of the Quran.', 'medium'),

('Which prayer is shortened on Friday and replaced by Jumuah?',
 'Fajr', 'Dhuhr', 'Asr', 'Isha', 'B',
 'The Friday Jumuah prayer replaces Dhuhr for those who attend it.', 'easy'),

('What does "Alhamdulillah" mean?',
 'Glory be to Allah', 'All praise is due to Allah', 'Allah is the Greatest', 'There is no god but Allah', 'B',
 'Alhamdulillah is said in gratitude; it literally means "all praise belongs to Allah".', 'easy'),

('Which night is "better than a thousand months"?',
 'Laylat al-Miraj', 'Laylat al-Qadr', 'Laylat al-Baraah', 'The first of Muharram', 'B',
 'Laylat al-Qadr (Night of Decree) is in the last ten nights of Ramadan. (Quran 97:3)', 'medium'),

('Which of these is NOT one of the Five Pillars of Islam?',
 'Shahada', 'Salah', 'Jihad', 'Hajj', 'C',
 'The five pillars are Shahada, Salah, Zakat, Sawm, and Hajj. Jihad is important but not a pillar.', 'medium');

-- ---------------------------------------------------------------------------
-- 99 Names of Allah (condensed canonical list)
-- ---------------------------------------------------------------------------
INSERT INTO `names_of_allah` (`position`, `arabic`, `transliteration`, `meaning`) VALUES
(1,'الرَّحْمَنُ','Ar-Rahman','The Most Gracious'),
(2,'الرَّحِيمُ','Ar-Raheem','The Most Merciful'),
(3,'الْمَلِكُ','Al-Malik','The King / Sovereign'),
(4,'الْقُدُّوسُ','Al-Quddus','The Most Holy'),
(5,'السَّلَامُ','As-Salam','The Source of Peace'),
(6,'الْمُؤْمِنُ','Al-Mu\u2019min','The Granter of Security'),
(7,'الْمُهَيْمِنُ','Al-Muhaymin','The Protector'),
(8,'الْعَزِيزُ','Al-Aziz','The Almighty'),
(9,'الْجَبَّارُ','Al-Jabbar','The Compeller'),
(10,'الْمُتَكَبِّرُ','Al-Mutakabbir','The Supreme in Greatness'),
(11,'الْخَالِقُ','Al-Khaliq','The Creator'),
(12,'الْبَارِئُ','Al-Bari','The Evolver'),
(13,'الْمُصَوِّرُ','Al-Musawwir','The Fashioner of Forms'),
(14,'الْغَفَّارُ','Al-Ghaffar','The Oft-Forgiving'),
(15,'الْقَهَّارُ','Al-Qahhar','The Subduer'),
(16,'الْوَهَّابُ','Al-Wahhab','The Bestower'),
(17,'الرَّزَّاقُ','Ar-Razzaq','The Provider'),
(18,'الْفَتَّاحُ','Al-Fattah','The Opener'),
(19,'اَلْعَلِيْمُ','Al-Alim','The All-Knowing'),
(20,'الْقَابِضُ','Al-Qabid','The Withholder'),
(21,'الْبَاسِطُ','Al-Basit','The Expander'),
(22,'الْخَافِضُ','Al-Khafidh','The Abaser'),
(23,'الرَّافِعُ','Ar-Rafi','The Exalter'),
(24,'الْمُعِزُّ','Al-Mu\u2019izz','The Bestower of Honor'),
(25,'ٱلْمُذِلُّ','Al-Mudhill','The Humiliator'),
(26,'السَّمِيعُ','As-Sami','The All-Hearing'),
(27,'الْبَصِيرُ','Al-Basir','The All-Seeing'),
(28,'الْحَكَمُ','Al-Hakam','The Judge'),
(29,'الْعَدْلُ','Al-Adl','The Utterly Just'),
(30,'اللَّطِيفُ','Al-Latif','The Subtly Kind'),
(31,'الْخَبِيرُ','Al-Khabir','The All-Aware'),
(32,'الْحَلِيمُ','Al-Halim','The Forbearing'),
(33,'الْعَظِيمُ','Al-Adheem','The Magnificent'),
(34,'الْغَفُورُ','Al-Ghafur','The Most Forgiving'),
(35,'الشَّكُورُ','Ash-Shakur','The Most Appreciative'),
(36,'الْعَلِيُّ','Al-Ali','The Most High'),
(37,'الْكَبِيرُ','Al-Kabir','The Greatest'),
(38,'الْحَفِيظُ','Al-Hafidh','The Preserver'),
(39,'الْمُقِيتُ','Al-Muqit','The Nourisher'),
(40,'الْحسِيبُ','Al-Hasib','The Reckoner'),
(41,'الْجَلِيلُ','Al-Jaleel','The Majestic'),
(42,'الْكَرِيمُ','Al-Kareem','The Most Generous'),
(43,'الرَّقِيبُ','Ar-Raqib','The Watchful'),
(44,'الْمُجِيبُ','Al-Mujib','The Responsive'),
(45,'الْوَاسِعُ','Al-Wasi','The All-Encompassing'),
(46,'الْحَكِيمُ','Al-Hakeem','The All-Wise'),
(47,'الْوَدُودُ','Al-Wadud','The Most Loving'),
(48,'الْمَجِيدُ','Al-Majid','The Glorious'),
(49,'الْبَاعِثُ','Al-Ba\u2019ith','The Resurrector'),
(50,'الشَّهِيدُ','Ash-Shaheed','The Witness'),
(51,'الْحَقُّ','Al-Haqq','The Truth'),
(52,'الْوَكِيلُ','Al-Wakeel','The Trustee'),
(53,'الْقَوِيُّ','Al-Qawi','The Most Strong'),
(54,'الْمَتِينُ','Al-Mateen','The Firm'),
(55,'الْوَلِيُّ','Al-Wali','The Protecting Friend'),
(56,'الْحَمِيدُ','Al-Hameed','The Praiseworthy'),
(57,'الْمُحْصِي','Al-Muhsi','The All-Enumerating'),
(58,'الْمُبْدِئُ','Al-Mubdi','The Originator'),
(59,'الْمُعِيدُ','Al-Mu\u2019id','The Restorer'),
(60,'الْمُحْيِي','Al-Muhyi','The Giver of Life'),
(61,'اَلْمُمِيتُ','Al-Mumit','The Bringer of Death'),
(62,'الْحَيُّ','Al-Hayy','The Ever-Living'),
(63,'الْقَيُّومُ','Al-Qayyum','The Self-Sustaining'),
(64,'الْوَاجِدُ','Al-Wajid','The Perceiver'),
(65,'الْمَاجِدُ','Al-Majid','The Illustrious'),
(66,'الْواحِدُ','Al-Wahid','The One'),
(67,'اَلاَحَدُ','Al-Ahad','The Unique'),
(68,'الصَّمَدُ','As-Samad','The Eternal / Absolute'),
(69,'الْقَادِرُ','Al-Qadir','The All-Capable'),
(70,'الْمُقْتَدِرُ','Al-Muqtadir','The Omnipotent'),
(71,'الْمُقَدِّمُ','Al-Muqaddim','The Expediter'),
(72,'الْمُؤَخِّرُ','Al-Mu\u2019akhkhir','The Delayer'),
(73,'الأوَّلُ','Al-Awwal','The First'),
(74,'الآخِرُ','Al-Akhir','The Last'),
(75,'الظَّاهِرُ','Az-Zahir','The Manifest'),
(76,'الْبَاطِنُ','Al-Batin','The Hidden'),
(77,'الْوَالِي','Al-Wali','The Governor'),
(78,'الْمُتَعَالِي','Al-Muta\u2019ali','The Most Exalted'),
(79,'الْبَرُّ','Al-Barr','The Source of All Goodness'),
(80,'التَّوَابُ','At-Tawwab','The Acceptor of Repentance'),
(81,'الْمُنْتَقِمُ','Al-Muntaqim','The Avenger'),
(82,'العَفُوُّ','Al-Afuww','The Pardoner'),
(83,'الرَّؤُوفُ','Ar-Ra\u2019uf','The Most Kind'),
(84,'مَالِكُ الْمُلْكِ','Malik-ul-Mulk','Master of the Kingdom'),
(85,'ذُو الْجَلَالِ وَالإكْرَامِ','Dhul-Jalali wal-Ikram','Lord of Majesty and Honor'),
(86,'الْمُقْسِطُ','Al-Muqsit','The Equitable'),
(87,'الْجَامِعُ','Al-Jami','The Gatherer'),
(88,'الْغَنِيُّ','Al-Ghani','The Self-Sufficient'),
(89,'الْمُغْنِي','Al-Mughni','The Enricher'),
(90,'اَلْمَانِعُ','Al-Mani','The Preventer'),
(91,'الضَّارَّ','Ad-Darr','The Distresser'),
(92,'النَّافِعُ','An-Nafi','The Benefactor'),
(93,'النُّورُ','An-Nur','The Light'),
(94,'الْهَادِي','Al-Hadi','The Guide'),
(95,'الْبَدِيعُ','Al-Badi','The Incomparable Originator'),
(96,'اَلْبَاقِي','Al-Baqi','The Ever-Enduring'),
(97,'الْوَارِثُ','Al-Warith','The Inheritor'),
(98,'الرَّشِيدُ','Ar-Rashid','The Guide to the Right Path'),
(99,'الصَّبُورُ','As-Sabur','The Patient');
