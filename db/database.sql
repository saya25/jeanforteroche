create database if not exists jeanforteroche character set utf8 collate utf8_unicode_ci;
use jeanforteroche;

grant all privileges on jeanforteroche.* to 'microcms_user'@'localhost' identified by 'secret';