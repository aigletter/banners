<?php

namespace Aigletter\TestTask;

class Service
{
    protected $repository;

    public function __construct(RepositoryInterface $repository,) {
        $this->repository = $repository;
    }

    public function show(string $banner): Renderer
    {
        // TODO move to another class for working with requests. Add interface with necessary methods
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $pageUrl = $_SERVER['HTTP_REFERER'] ?? null;

        if (!$pageUrl) {
            throw new \Exception('Direct request is not allowed');
        }

        $view = $this->repository->getByParams(
            $ipAddress,
            $userAgent,
            $pageUrl
        );

        if (!$view) {
            $view = new Dto();
            $view->ipAddress = $ipAddress;
            $view->userAgent = $userAgent;
            $view->pageUrl = $pageUrl;
            $this->repository->insert($view);
        } else {
            $view->viewDate = new \DateTimeImmutable();
            $view->viewsCount++;
            $this->repository->update($view);
        }

        return new Renderer($banner);
    }
}