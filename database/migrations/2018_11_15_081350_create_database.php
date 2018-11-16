<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('
        CREATE TABLE `budget` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
          `starting_balance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
          `current_balance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
          `from` date NOT NULL,
          `to` date NOT NULL,
          `user_id` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');
        \DB::statement('
        CREATE TABLE `budget_category` (
          `budget_id` int(11) NOT NULL,
          `category_id` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');
        \DB::statement('CREATE TABLE `category` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `user_id` int(11) NOT NULL,
          `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
          `type` smallint(5) unsigned NOT NULL DEFAULT 1,
          `icon` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `is_deleted` tinyint(3) unsigned NOT NULL DEFAULT 0,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');
        \DB::statement('CREATE TABLE `transaction` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `user_id` int(11) NOT NULL,
          `wallet_id` int(11) NOT NULL,
          `category_id` int(11) NOT NULL,
          `amount` int(11) NOT NULL,
          `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `tag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `created_at` timestamp NULL DEFAULT NULL,
          `updated_at` timestamp NULL DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');
        \DB::statement('CREATE TABLE `users` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
          `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
          `email_verified_at` timestamp NULL DEFAULT NULL,
          `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
          `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `created_at` timestamp NULL DEFAULT NULL,
          `updated_at` timestamp NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `users_email_unique` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');
        \DB::statement('CREATE TABLE `wallet` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `user_id` int(11) NOT NULL,
          `balance` int(11) NOT NULL,
          `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP TABLE IF EXISTS budget');
        DB::statement('DROP TABLE IF EXISTS budget_category');
        DB::statement('DROP TABLE IF EXISTS category');
        DB::statement('DROP TABLE IF EXISTS `transactions`');
        DB::statement('DROP TABLE IF EXISTS users');
        DB::statement('DROP TABLE IF EXISTS wallet');
    }
}
