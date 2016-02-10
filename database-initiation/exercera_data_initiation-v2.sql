TRUNCATE `exercera`.`report`;
TRUNCATE `exercera`.`comment`;
TRUNCATE `exercera`.`solution`;
TRUNCATE `exercera`.`exercise_tag`;
TRUNCATE `exercera`.`exercise_detail`;
DELETE FROM `exercera`.`tag`;
ALTER TABLE `exercera`.`tag` AUTO_INCREMENT = 1;
DELETE FROM `exercera`.`exercise`;
ALTER TABLE `exercera`.`exercise` AUTO_INCREMENT = 1;
DELETE FROM `exercera`.`category`;
ALTER TABLE `exercera`.`category` AUTO_INCREMENT = 1;

INSERT INTO `category` (`name`) VALUES
('Maths'),
('Physic'),
('Logic'),
('Algorithm'),
('Linguistic'),
('Database');

INSERT INTO `exercise` (`title`, `content`, `cat_id`, `user_create`) VALUES
('What is the first number?', 'Is it 1?0?Negative Number?', 1, 'ducva'),
('What to multiply 60 by to get 20?', 'What to multiply 60 by to get 20?', 1, 'ducva'),
('What is smaller than a quark?', 'Is there any known thing that is smaller than a quark?', 2, 'ducva'),
('What is Logic?', 'What is Logic?', 3, 1),
('What are algorithms?', 'I think I know that an algorithm is a series of instructions for a processor to handle binary code, but than isn''t an algorithm by definition binary code that takes up space on a hard drive? Where are all of my algorithms for my computer stored?', 4, 'ducva'),
('What is linguistics?', 'Do you know what is linguistics?', 5, 5),
('What is database design?', 'And what if I want to make a small working data base project ? would I need to do any front end for it?', 6, 'ducva');

INSERT INTO `exercise_detail`(`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7);

INSERT INTO `tag` (`name`) VALUES
('maths'),
('numeric'),
('multiply'),
('physic'),
('universal'),
('quark'),
('logic'),
('definition'),
('algorithm'),
('linguistic'),
('database'),
('design'),
('theory'),
('concept'),
('database design');

INSERT INTO `exercise_tag` (`ex_id`, `tag_id`) VALUES
(1, 1),
(2, 2),
(2, 3),
(3, 4),
(3, 5),
(3, 6),
(4, 7),
(4, 8),
(5, 8),
(5, 9),
(6, 8),
(6, 10),
(7, 8),
(7, 11),
(7, 12),
(7, 13),
(7, 14),
(7, 15);

INSERT INTO `solution` (`content`, `ex_id`, `user_create`) VALUES
('The first number to be named was very likely the number two actually, since you could easily imply that there was only one object by using the singular form of the word associated with it. When you have multiple objects specifically a pair of objects then it''s helpful to have a word that describes that amount. So two is the first number.
If you want a serious answer though then zero or one are equal candidates for being first, it just depends on what context you are using, when used to count you''ll start with one, if you are using indices then zero is often used for the initial object in question. So at that point its purely up to preference and the application.', 1, 'ducva'),
(' The first natural number is 1 and the first whole number is 0.
As for the first integer, it''s unknown except for the fact that it''s negative (because there are infinite negative numbers)', 1, 'ducva'),
('60 x 1/3 = 20', 2, 'ducva'),
('1/3', 2, 'ducva'),
('Thomas Ryttov and his colleagues believe that the so-called techni-quarks can be the yet unseen particles, smaller than the Higgs particle. If techni-quarks exist they will form a natural exention of the Standard Model which includes three generations of quarks and leptons', 3, 'ducva'),
('You are assuming that a quark is known and that it has a size. Does an electron have a size given that it can overlap other electrons? Size is meaningless at this scale.', 3, 'ducva'),
('The definition term is the use of valid reasoning. However labels/definitions are man-made, hence logic is man-made and not a truth. Logic is part of the human psyche governed by experience. It is not necessary for one''s existence or existence itself.', 4, 'ducva'),
('Logic is not a matter of opinion: when it comes to evaluating arguments, there are specific principles and criteria which should be used. If we use those principles and criteria, then we are using logic; if we aren’t using those principles and criteria, then we are not justified in claiming to use logic or be logical. This is important because sometimes people don’t realize that what sounds reasonable isn’t necessarily logical in the strict sense of the word.', 4, 'ducva'),
('Logic is the way how you think correctly and fairly:)', 4, 'ducva'),
('Algorithm is a term used to define the steps needed to create a standard solution to a standard problem. For example,

Problem: Given a list of numbers, determine the average

Algorithm:
count the number of entries in the list,
assign the count to variable n.
Find the sum of all entries in the list,
assign this value to variable vTotal.
Average = vTotal/n

An algorithm is a generic solution sometimes used to block out psuedo code for programming.', 5, 'ducva'),
('Algorithm is a logical steps to solve problem. Algorithms can be in any languags.', 5, 'ducva'),
('It''s the scientific study of language and its structure.
The part of linguistics that is concerned with the structure of language is divided into a number of subfields:

    Phonetics - the study of speech sounds in their physical aspects
    Phonology - the study of speech sounds in their cognitive aspects
    Morphology - the study of the formation of words
    Syntax - the study of the formation of sentences
    Semantics - the study of meaning
    Pragmatics - the study of language use

Aside from language structure, other perspectives on language are represented in specialized or interdisciplinary branches:

    Historical Linguistics
    Sociolinguistics
    Psycholinguistics
    Ethnolinguistics (or Anthropological Linguistics)
    Dialectology
    Computational Linguistics
    Psycholinguistics and neurolinguistics', 6, 'ducva'),
('Database design is the methodolgy for developing the various objects that make up a database (tables, indexes, views, contraints, procedures, functions, etc.) as well as the relationships between tables and the business rules for maintaining the data within them.
The front end is basically the interface between the end user and the database. Whether you need one is really up to you and your knowledge of who your end users are, their technical ability and so on. What it could consist of is anything from nonexistent (all interactions done on an ad-hoc basis typed into a DBMS prompt) to a full-fledged application (with all user entry done via forms and GUI components.)', 7, 'ducva'),
('Database design is more art than science, as you have to make many decisions. Databases are usually customized to suit a particular application. No two customized applications are alike, and hence, no two database are alike. Guidelines (usually in terms of what not to do instead of what to do) are provided in making these design decision, but the choices ultimately rest on the you - the designer.', 7, 'ducva'),
('Database design is the process of producing a detailed data model of a database. This data model contains all the needed logical and physical design choices and physical storage parameters needed to generate a design in a data definition language, which can then be used to create a database.', 7, 'ducva');

INSERT INTO `comment`(`content`, `ex_id`, `user_create`) VALUES
('comment 1', 1, 'ducva'),
('comment 2', 2, 'ducva'),
('comment 3', 3, 'ducva'),
('comment 4', 4, 'ducva'),
('comment 5', 5, 'ducva'),
('comment 6', 6, 'ducva'),
('comment 71', 7, 'ducva'),
('comment 72', 7, 'ducva');

INSERT INTO `report`(`content`, `ex_id`, `user_create`) VALUES
('Report 1', 1, 'ducva'),
('Report 2', 2, 'ducva'),
('Report 3', 3, 'ducva'),
('Report 4', 4, 'ducva'),
('Report 5', 5, 'ducva'),
('Report 6', 6, 'ducva'),
('Report 71', 7, 'ducva'),
('Report 72', 7, 'ducva');