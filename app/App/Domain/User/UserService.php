<?php

namespace App\Domain\User;

use Exception;
use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\Password;
use App\Domain\User\UserMapper;
use App\Domain\BaseService as BaseService;

/**
 * UserService class handles user registration, login, logout,
 * update details, update password
 */
class UserService extends BaseService
{

    private $userMapper;
    private $password;

    public function __construct()
    {
        parent::__construct();
        $this->userMapper = new UserMapper($this->database);
        $this->password = new Password;
    }

    /**
     * Register a new user
     * @param  array    $userDetails user details
     * @return boolean               on success return true
     */
    public function register(array $userDetails)
    {
        try {
            // sanitize input
            $filterRules = ['firstname' => 'trim,sanitize',
                            'username' => 'trim,sanitize',
                            'email' => 'trim,email,sanitize'];
            $filteredData = $this->sanitizationService
                                 ->filter($userDetails, $filterRules)
                                 ->getFilteredData();

            // check first is username or email are unique
            if (
                $this->userMapper->findByUsername($filteredData['username'])
                ||
                $this->userMapper->findByEmail($filteredData['email'])
            ) {
                $this->session->add(
                        'message/failure', $this->message
                                                ->get('MESSAGE_EMAIL_OR_USERNAME_EXISTS')
                );
                return false;
            }

            // validate sanitized data
            $validated = $this->validationService->validate($filteredData,
                [   'firstname' => 'required,max_length=20,min_length=4,alpha',
                    'username' => 'required,max_length=10,min_length=4,alpha_num',
                    'email' => 'required,max_length=30,min_length=4,email',
                    'password' => 'required,max_length=10,min_length=4',
                    'password-retype' => 'required,match=' . $userDetails['password']])
                                                 ->getValidatedData();
            // create User
            $user = User::fromState(
                new UserId, $validated['firstname'], $validated['username'],
                $validated['email'], $this->password->hash($validated['password']), '1'
            );

            // add to user repository
            $this->userMapper->add($user);

            // add successful message to session
            $this->session->add(
                'message/success',
                $this->message->get('MESSAGE_REGISTRATION_SUCCESSFUL')
            );

            return true;
        } catch (Exception $e) {
            $this->session->add('message/failure', $e->getMessage());
            return false;
        }
    }

    /**
     * Log a registered user in
     * @param  array  $userDetails login credentials
     * @return mixed
     */
    public function login(array $userDetails)
    {
        try {
            // filter / sanitize results
            $filterRules = ['username' => 'trim'];
            $filteredData = $this->sanitizationService
                                 ->filter($userDetails, $filterRules)
                                 ->getFilteredData();

            // validate filtered results
            $validated = $this->validationService->validate($filteredData,
                [   'username' => 'required',
                    'password' => 'required'])->getValidatedData();

            // check if user exists
            if (!$user = $this->userMapper->findByUsername($validated['username'])
            ) {
                $this->session->add('message/failure', $this->message->get('MESSAGE_USER_NOT_FOUND'));
                return false;
            }

            // compare passwords
            if (!$this->password->compare($validated['password'], $user->getPassword())) {
                $this->session->add(
                    'message/failure', $this->message
                                            ->get('MESSAGE_USERNAME_OR_PASSWORD_INCORRECT')
                );
                return false;
            }
            return $user;
        } catch (Exception $e) {
            $this->session->add('message/failure', $e->getMessage());
        }
    }

    /**
     * Log a user out and destroy all session data
     * @return void
     */
    public function logout()
    {
        $this->session->destroy();
    }

    /**
     * Update user details
     * @param  string $id          user id
     * @param  array  $userDetails updated details
     * @return object              user object
     */
    public function update($id, array $userDetails)
    {
        // sanitize
        $filterRules = ['firstname' => 'trim,sanitize',
                        'email' => 'trim,sanitize,email'];
        $filteredData = $this->sanitizationService
                             ->filter($userDetails, $filterRules)
                             ->getFilteredData();
        // validate
        $validated = $this->validationService->validate($filteredData,
            [   'firstname' => 'required',
                'email' => 'required'])->getValidatedData();
        // update
        $this->userMapper->updateById($id, $validated);
        // return user
        return $this->getUser($id);
    }

    /**
     * Update current logged in user password
     * @param  string $id        user id
     * @param  array  $passwords old password to compare and new password to replace old one
     * @return boolean           return true on success, false on failure
     */
    public function updatePassword($id, array $passwords)
    {
        $validated = $this->validationService->validate($passwords,
            [   'current-password' => 'required',
                'new-password' => 'required'])->getValidatedData();

        // retrieve user
        $user = $this->getUser($id);

        // compare passwords if equal then update
        if ($this->password->compare($validated['current-password'], $user->getPassword())) {
            // update password
            $this->userMapper->updateById($id,
                ['password' => $this->password->hash($validated['new-password'])]
            );
            return true;
        }

        return false;
    }

    /**
     * Find user by id
     * @param  string $id id
     * @return object     user object
     */
    public function getUser($id)
    {
        return $this->userMapper->findById($id);
    }
}
