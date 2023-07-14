<?php

namespace Aigletter\TestTask\Repositories;

use Aigletter\TestTask\Dto;
use Aigletter\TestTask\RepositoryInterface;

class DatabaseRepository implements RepositoryInterface
{
    public const DEFAULT_TABLE = 'banner_views';

    protected $dsn;

    protected $username;

    protected $password;

    protected $table;

    protected $connection;

    public function __construct(
        string $dsn,
        string $username,
        string $password,
        string $table = self::DEFAULT_TABLE
    ) {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->table = $table;
    }

    public function getConnection()
    {
        if ($this->connection === null) {
            $this->connection = new \PDO($this->dsn, $this->username, $this->password);
        }

        return $this->connection;
    }

    public function getByParams(string $ipAddress, string $userAgent, string $pageUrl): Dto|null
    {
        $statement = $this->getConnection()->prepare("
            SELECT * FROM $this->table
            WHERE ip_address = :ip_address 
            AND user_agent = :user_agent
            AND page_url = :page_url
        ");

        $statement->execute([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'page_url' => $pageUrl
        ]);

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return $this->makeDto($result);
    }

    public function insert(Dto $view): bool
    {
        $statement = $this->getConnection()->prepare("
            INSERT INTO $this->table
            (`ip_address`, `user_agent`, `page_url`)
            VALUES (:ip_address, :user_agent, :page_url)
        ");

        return $statement->execute([
            'ip_address' => $view->ipAddress,
            'user_agent' => htmlspecialchars($view->userAgent),
            'page_url' => htmlspecialchars($view->pageUrl)
        ]);
    }

    public function update(Dto $view): bool
    {
        $statement = $this->getConnection()->prepare("
            UPDATE $this->table
            SET `view_date` = :view_date, `views_count` = :views_count
            WHERE `ip_address` = :ip_address AND `user_agent` = :user_agent AND `page_url` = :page_url
        ");

        return $statement->execute([
            'view_date' => $view->viewDate->format('Y-m-d H:i:s'),
            'views_count' => $view->viewsCount,
            'ip_address' => $view->ipAddress,
            'user_agent' => htmlspecialchars($view->userAgent),
            'page_url' => htmlspecialchars($view->pageUrl),
        ]);

    }

    protected function makeDto(array $result)
    {
        $view = new Dto();

        $view->ipAddress = $result['ip_address'];
        $view->userAgent = $result['user_agent'];
        $view->pageUrl = $result['page_url'];
        $view->viewDate = new \DateTimeImmutable($result['view_date']);
        $view->viewsCount = $result['views_count'];

        return $view;
    }








}