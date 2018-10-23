<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert('insert into users (id, name, email, password) values (?, ?, ?, ?)', [1, 'Test Elek', 'test@gmail.com', Hash::make('test')]);
        DB::insert('insert into users (id, name, email, password) values (?, ?, ?, ?)', [2, 'Dayle', 'daylee@gmail.com', Hash::make('pA22W0Rd')]);
        DB::insert('insert into users (id, name, email, password) values (?, ?, ?, ?)', [3, 'Test Name', 'test.name@gmail.com', Hash::make('p@22w0rd')]);
    }
}
