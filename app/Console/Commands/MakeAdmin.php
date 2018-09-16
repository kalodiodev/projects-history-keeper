<?php

namespace App\Console\Commands;

use App\Role;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add admin user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Adding a new Admin User');

        $data = $this->askData();

        $validator = Validator::make($data, $this->validationRules());

        if($validator->fails()) {
            $this->info('Admin User not created. See error messages below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return 1;
        }

        $this->createAdmin($data);

        $this->info('Admin account has been created created.');

        return 0;
    }

    /**
     * Ask Admin data
     *
     * @return array
     */
    protected function askData()
    {
        return [
            'name' => $this->ask('What name the admin should have?'),
            'email' => $this->ask('And the email address?'),
            'password' => $this->secret('And the password?'),
            'password_confirmation' => $this->secret('Confirm the password?')
        ];
    }

    /**
     * Create Admin User
     *
     * @param $data
     * @return mixed
     */
    protected function createAdmin($data)
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        $user->giveRole($this->adminRole());

        return $user;
    }

    /**
     * Get admin role
     *
     * @return mixed
     */
    protected function adminRole()
    {
        return Role::whereName('admin')->firstOrFail();
    }

    /**
     * User create validation rules
     *
     * @return array
     */
    protected function validationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
