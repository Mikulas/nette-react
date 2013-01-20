<?php

namespace ReactNette\Application;


use Nette,
	Nette\Application\IResponse,
	Nette\Application\IPresenterFactory,
	Nette\Application\IRouter,
	Nette\Application\ApplicationException,
	Nette\Application\BadRequestException,
	Nette\Application\AbortException;

class Application extends Nette\Application\Application
{

	/** @var Request[] */
	private $requests = array();

	/** @var IPresenter */
	private $presenter;

	/** @var Nette\Http\IRequest */
	private $httpRequest;

	/** @var Nette\Http\IResponse */
	private $httpResponse;

	/** @var IPresenterFactory */
	private $presenterFactory;

	/** @var IRouter */
	private $router;



	public function __construct(IPresenterFactory $presenterFactory, IRouter $router, Nette\Http\IRequest $httpRequest, Nette\Http\IResponse $httpResponse)
	{
		$this->httpRequest = $httpRequest;
		$this->httpResponse = $httpResponse;
		$this->presenterFactory = $presenterFactory;
		$this->router = $router;
	}



	public function getRouter()
	{
		return $this->router;
	}



	public function getHttpRequest()
	{
		return $this->httpRequest;
	}



	public function getHttpResponse()
	{
		return $this->httpResponse;
	}



	public function runAsync($req, $res)
	{
		$this->httpRequest = new \ReactNette\Http\Request($req);
		$this->httpResponse = new \ReactNette\Http\Response($res);

		$request = NULL;
		$repeatedError = FALSE;
		do {
			try {
				if (count($this->requests) > self::$maxLoop) {
					throw new ApplicationException('Too many loops detected in application life cycle.');
				}

				if (!$request) {
					$this->onStartup($this);
					$request = $this->router->match($this->httpRequest);
					if (!$request instanceof Nette\Application\Request) {
						$request = NULL;
						throw new BadRequestException('No route for HTTP request.');
					}

					if (strcasecmp($request->getPresenterName(), $this->errorPresenter) === 0) {
						throw new BadRequestException('Invalid request. Presenter is not achievable.');
					}
				}

				$this->requests[] = $request;
				$this->onRequest($this, $request);

				// Instantiate presenter
				$presenterName = $request->getPresenterName();
				try {
					$this->presenter = $this->presenterFactory->createPresenter($presenterName);
				} catch (InvalidPresenterException $e) {
					throw new BadRequestException($e->getMessage(), 404, $e);
				}

				$this->presenterFactory->getPresenterClass($presenterName);
				$request->setPresenterName($presenterName);
				$request->freeze();

				// Execute presenter
				$response = $this->presenter->run($request);
				if ($response) {
					$this->onResponse($this, $response);
				}

				// Send response
				if ($response instanceof Responses\ForwardResponse) {
					$request = $response->getRequest();
					continue;

				} elseif ($response instanceof IResponse) {
					$headers = array_merge(['X-Powered-By' => 'Nette Framework', 'Content-Type' => 'text/html'], (array) $this->httpResponse->getHeaders());
					$res->writeHead($this->httpResponse->getCode(), $headers);
					ob_start();
					$response->send($this->httpRequest, $this->httpResponse);
					$res->end(ob_get_clean());
				}
				break;

			} catch (\Exception $e) {
				$this->onError($this, $e);

				if ($repeatedError) {
					$e = new ApplicationException("An error occurred while executing error-presenter '$this->errorPresenter'.", 0, $e);
				}
				if ($repeatedError || !$this->catchExceptions) {
					$this->onShutdown($this, $e);
					throw $e;
				}

				$repeatedError = TRUE;
				$this->errorPresenter = $this->errorPresenter ?: 'Nette:Error';

				if (!$this->httpResponse->isSent()) {
					$this->httpResponse->setCode($e instanceof BadRequestException ? $e->getCode() : 500);
				}

				if ($this->presenter instanceof UI\Presenter) {
					try {
						$this->presenter->forward(":$this->errorPresenter:", array('exception' => $e));
					} catch (AbortException $foo) {
						$request = $this->presenter->getLastCreatedRequest();
					}
				} else {
					$request = new Request($this->errorPresenter, Request::FORWARD, array('exception' => $e));
				}
				// continue
			}
		} while (1);

		$this->requests = [];
		$this->onShutdown($this, isset($e) ? $e : NULL);
	}

}
