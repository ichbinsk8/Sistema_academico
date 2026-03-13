<?php
class UserModel
{
    private $db;

    public function __construct()
    {
        try {
            $this->db = Database::connect();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function findByUsername($username)
    {
        try {
            $sql = "SELECT id, username, password FROM users WHERE username = :u";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['u' => $username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            if (Env::isDebug()) {
                Logger::info("Error en BD");
                throw new Exception("Error en BD: " . $e->getMessage());
            }
            return null;
        }
    }
}
