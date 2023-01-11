<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;

class UserService
{

    /**
     * UserService constructor.
     */
    public function __construct()
    {
    }

    /**
     * Create a user
     *
     * @param array $data
     * @return Hotel
     */
    public function create(array $data): User
    {
        $user = new User();

        $data['password'] = $this->get_password();

        if (Auth::user()->role === User::$ROLE_EMPLOYEE) {
            throw new Exception('Employees can not create users.');
        }

        if ($data['role'] === User::$ROLE_OWNER && Auth::user()->role !== User::$ROLE_OWNER) {
            throw new Exception('Only owners can create owners.');
        }

        // Grab the hotel id from the request and remove it from the data array
        $hotel_id = $data['hotel_id'];
        unset($data['hotel_id']);

        $user->fill($data);

        if (!$user->save()) {
            throw new Exception('User could not be saved.');
        }

        $user->hotels()->attach($hotel_id);

        return $user;
    }


    /**
     * Follow user
     *
     * @param User $user
     * @return array
     */
    public function follow(User $user)
    {
        if ($user->followers->contains(Auth::user())) {
            $this->unfollow($user);
            return;
        }

        $user->followers()->attach(Auth::user());
    }

    /**
     * Follow user
     *
     * @param User $user
     * @return array
     */
    public function unfollow(User $user)
    {
        $user->followers()->detach(Auth::user());
    }

    public function completeOnboarding(User $user)
    {
        $user->onboarded = true;
        $user->save();
    }

    // Function to generate password from 
    // given string
    function get_password($len = 10) {
        
        // Variable $pass to store password
        $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
        $pass = "";
        
        // Variable $str_length to store 
        // length of the given string
        $str_length = strlen($str);
    
        // Check if the $len is not provided
        // or $len is greater than $str_length
        // then assign $str_length to $len
        if($len == 0 || $len > $str_length){
            $len = $str_length;
        }
    
        // Iterate $len times so that the 
        // resulting string's length is 
        // equal to $len
        for($i = 0;  $i < $len; $i++){
            
            // Concatenate random character 
            // from $str with $pass
            $pass .=  $str[rand(0, $str_length - 1)];
        }
        return $pass;
    }
}
