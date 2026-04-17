<?php
/**
 * UserModel - Handles all database operations for users
 * 
 * This model communicates with the "users" table in the database.
 * It provides methods for user authentication and profile management.
 */

namespace App\Models;

class UserModel
{
    // Database connection (PDO object)
    private $pdo;

    /**
     * Constructor - Gets the database connection
     */
    public function __construct()
    {
        $this->pdo = \Database::getInstance()->getConnection();
    }

    /**
     * Find a user by their username or email
     * 
     * @param string $identifier Username or email to search for
     * @return array|false User data if found, false if not
     */
    public function findByUsernameOrEmail($identifier)
    {
        $sql = "SELECT * FROM users 
                WHERE username = ? OR email = ? 
                LIMIT 1";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$identifier, $identifier]);
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Find a user by their ID
     * 
     * @param int $user_id The user's ID
     * @return array|false User data if found, false if not
     */
    public function findById($user_id)
    {
        $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Find a user by their phone number
     * 
     * @param string $phone The phone number
     * @return array|false User data if found, false if not
     */
    public function findByPhone($phone)
    {
        $sql = "SELECT * FROM users WHERE phone = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$phone]);
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Verify a user's password
     * 
     * @param string $plain_password The password to check (plain text)
     * @param string $hashed_password The hashed password from database
     * @return bool True if password matches
     */
    public function verifyPassword($plain_password, $hashed_password)
    {
        // password_verify compares plain text against bcrypt hash
        return password_verify($plain_password, $hashed_password);
    }

    /**
     * Create a new user (register)
     * 
     * @param array $data User data (username, email, password, role, phone)
     * @return bool True if user was created successfully
     */
    public function create($data)
    {
        $sql = "INSERT INTO users (username, email, password, role, phone, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        
        $stmt = $this->pdo->prepare($sql);
        
        // Hash the password before storing (bcrypt)
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        
        return $stmt->execute([
            $data['username'],
            $data['email'],
            $hashedPassword,
            $data['role'] ?? 'client',
            $data['phone'] ?? null
        ]);
    }

    /**
     * Update a user's password
     * 
     * @param int    $user_id The user's ID
     * @param string $new_password The new plain text password
     * @return bool True if update succeeded
     */
    public function updatePassword($user_id, $new_password)
    {
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        
        $hashedPassword = password_hash($new_password, PASSWORD_BCRYPT);
        
        return $stmt->execute([$hashedPassword, $user_id]);
    }

    /**
     * Update the last login timestamp for a user
     * 
     * @param int $user_id The user's ID
     * @return bool True if update succeeded
     */
    public function updateLastLogin($user_id)
    {
        $sql = "UPDATE users SET last_login = NOW() WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$user_id]);
    }

    /**
     * Check if a username or email already exists
     * 
     * @param string $username The username to check
     * @param string $email    The email to check
     * @return bool True if user exists
     */
    public function exists($username, $email)
    {
        $sql = "SELECT COUNT(*) FROM users 
                WHERE username = ? OR email = ?";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username, $email]);
        
        return (int) $stmt->fetchColumn() > 0;
    }

    /**
     * Get all users (admin function)
     * 
     * @return array All users
     */
    public function getAllUsers()
    {
        $sql = "SELECT id, username, email, role, created_at, last_login 
                FROM users 
                ORDER BY created_at DESC";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Delete a user (admin function)
     * 
     * @param int $user_id The user ID to delete
     * @return bool True if deletion succeeded
     */
    public function delete($user_id)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$user_id]);
    }
}
