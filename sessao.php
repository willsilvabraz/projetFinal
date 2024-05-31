<?php
class Sessao {
    private static $instancia = null;

    private function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function getInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new Sessao();
        }
        return self::$instancia;
    }

    public function obter($chave) {
        return $_SESSION[$chave] ?? null;
    }

    public function definir($chave, $valor) {
        $_SESSION[$chave] = $valor;
    }

    public function deletar($chave) {
        unset($_SESSION[$chave]);
    }

    public function destruir() {
        session_destroy();
        self::$instancia = null;
    }

    public function estaLogado() {
        return isset($_SESSION['cargo']);
    }

    public function requerLogin() {
        if (!$this->estaLogado()) {
            header("Location: login.php");
            exit();
        }
    }
}
