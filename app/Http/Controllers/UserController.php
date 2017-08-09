<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    public function index(){
        return view('users.index');
    }

    public function getUserData(){
        $users = new Collection;
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            $users->push([
                'id'         => $i + 1,
                'name'       => $faker->name,
                'email'      => $faker->email,
                'created_at' => Carbon::now()->format('m-d-Y'),
                'updated_at' => Carbon::now()->format('m-d-Y'),

            ]);
        }

        return Datatables::of($users)
            ->addColumn('action', function ($users) {
                return '<a href="#edit-'.$users['id'].'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })
            ->make(true);

    }
}
