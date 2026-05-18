<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.bank_api.url'), '/');
    }

    protected function http(): \Illuminate\Http\Client\PendingRequest
    {
        $request = Http::baseUrl($this->baseUrl . '/api')
            ->acceptJson()
            ->timeout(10);

        if (Session::has('api_token')) {
            $request = $request->withToken(Session::get('api_token'));
        }

        return $request;
    }

    // ---------- Autenticació ----------

    public function register(array $data): Response
    {
        return $this->http()->post('/register', $data);
    }

    public function login(array $data): Response
    {
        return $this->http()->post('/login', $data);
    }

    public function logout(): Response
    {
        return $this->http()->post('/logout');
    }

    // ---------- Categories ----------

    public function getCategories(): Response
    {
        return $this->http()->get('/categories');
    }

    public function getCategoria(int $id): Response
    {
        return $this->http()->get("/categories/{$id}");
    }

    public function createCategoria(array $data): Response
    {
        return $this->http()->post('/categories', $data);
    }

    public function updateCategoria(int $id, array $data): Response
    {
        return $this->http()->put("/categories/{$id}", $data);
    }

    public function deleteCategoria(int $id): Response
    {
        return $this->http()->delete("/categories/{$id}");
    }

    // ---------- Preguntes ----------

    public function getPreguntes(): Response
    {
        return $this->http()->get('/preguntes');
    }

    public function getPregunta(int $id): Response
    {
        return $this->http()->get("/preguntes/{$id}");
    }

    public function createPregunta(array $data): Response
    {
        return $this->http()->post('/preguntes', $data);
    }

    public function updatePregunta(int $id, array $data): Response
    {
        return $this->http()->put("/preguntes/{$id}", $data);
    }

    public function deletePregunta(int $id): Response
    {
        return $this->http()->delete("/preguntes/{$id}");
    }

    // ---------- Respostes ----------

    public function getRespostes(): Response
    {
        return $this->http()->get('/respostes');
    }

    public function getResposta(int $id): Response
    {
        return $this->http()->get("/respostes/{$id}");
    }

    public function createResposta(array $data): Response
    {
        return $this->http()->post('/respostes', $data);
    }

    public function updateResposta(int $id, array $data): Response
    {
        return $this->http()->put("/respostes/{$id}", $data);
    }

    public function deleteResposta(int $id): Response
    {
        return $this->http()->delete("/respostes/{$id}");
    }

    // ---------- Partides ----------

    public function createPartida(array $data = []): Response
    {
        return $this->http()->post('/partides', $data);
    }

    public function getPartida(int $id): Response
    {
        return $this->http()->get("/partides/{$id}");
    }

    public function getPartidaPreguntes(int $id): Response
    {
        return $this->http()->get("/partides/{$id}/preguntes");
    }

    public function guardarRespostes(int $id, array $data): Response
    {
        return $this->http()->post("/partides/{$id}/respostes", $data);
    }

    public function puntuarPartida(int $id, array $data = []): Response
    {
        return $this->http()->post("/partides/{$id}/puntuar", $data);
    }

    public function getPartidesUsuari(): Response
    {
        return $this->http()->get('/partides');
    }
}
